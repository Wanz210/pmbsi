<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // ==========================================================
    // 1. UNTUK USER (CALON MAHASISWA)
    // ==========================================================

    public function userDashboard()
    {
        $data_pendaftar = Pendaftar::where('user_id', Auth::id())->first();
        $jadwals = Jadwal::orderBy('tanggal_mulai', 'asc')->get();

        return view('user.dashboard', compact('data_pendaftar', 'jadwals'));
    }

    public function userForm()
    {
        $cek = Pendaftar::where('user_id', Auth::id())->first();
        if ($cek) {
            return redirect()->route('user.dashboard')->with('warning', 'Anda sudah mengisi formulir.');
        }
        return view('user.formulir');
    }

    public function storeFormulir(Request $request)
    {
        // [PERHATIAN: Tambahkan 'unique:pendaftars,nisn' jika Anda ingin NISN unik]
        $request->validate([
            'nisn' => 'required',
            'asal_sekolah' => 'required',
            'no_hp' => 'required',
            'foto' => 'required|image|max:2048',
            'ijazah' => 'required|mimes:pdf,jpg,jpeg|max:2048',
        ]);

        $pathFoto = $request->file('foto')->store('uploads', 'public');
        $pathIjazah = $request->file('ijazah')->store('uploads', 'public');

        Pendaftar::create([
            'user_id' => Auth::id(),
            'nisn' => $request->nisn,
            'asal_sekolah' => $request->asal_sekolah,
            'no_hp' => $request->no_hp,
            'path_foto' => $pathFoto,
            'path_ijazah' => $pathIjazah,
            'status_berkas' => 'pending'
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Pendaftaran berhasil dikirim!');
    }

    public function userCetakKartu()
    {
        $pendaftar = Pendaftar::where('user_id', Auth::id())->first();

        if (!$pendaftar) {
            return redirect()->route('user.dashboard')->with('error', 'Anda belum mengisi formulir pendaftaran.');
        }

        // Cek Syarat: Berkas harus valid DAN pembayaran harus lunas
        if ($pendaftar->status_berkas != 'valid' || $pendaftar->status_bayar != 'lunas') {
            return view('user.kartu', [
                'pendaftar' => $pendaftar,
                'status' => 'belum_siap'
            ]);
        }
        return view('user.kartu', ['pendaftar' => $pendaftar, 'status' => 'siap']);
    }

    public function userStatusLulus()
    {
        $pendaftar = Pendaftar::where('user_id', Auth::id())->first();
        return view('user.kelulusan', compact('pendaftar'));
    }


    // ==========================================================
    // 2. UNTUK ADMIN
    // ==========================================================

    public function adminDashboard()
    {
        $total_pendaftar = Pendaftar::count();
        $perlu_verifikasi = Pendaftar::where('status_berkas', 'pending')->count();
        $lulus_seleksi = Pendaftar::where('status_lulus', 'lulus')->count();

        return view('admin.dashboard', compact('total_pendaftar', 'perlu_verifikasi', 'lulus_seleksi'));
    }

    public function adminVerifikasi()
    {
        $pendaftar = Pendaftar::where('status_berkas', 'pending')->with('user')->get();
        return view('admin.verifikasi', compact('pendaftar'));
    }

    public function prosesVerifikasi(Request $request, $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);

        if ($request->aksi == 'valid') {
            $pendaftar->update(['status_berkas' => 'valid']);
        } elseif ($request->aksi == 'tolak') {
            $pendaftar->update(['status_berkas' => 'invalid']);
        }

        return redirect()->back()->with('success', 'Status berkas berhasil diperbarui.');
    }

    public function adminUsers()
    {
        $users = \App\Models\User::latest()->get();
        return view('admin.users', compact('users'));
    }

    public function destroyUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }

    public function adminJadwal()
    {
        $jadwals = Jadwal::latest()->get();
        return view('admin.jadwal', compact('jadwals'));
    }

    public function storeJadwal(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'deskripsi' => 'nullable',
        ]);

        Jadwal::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()->route('admin.jadwal')->with('success', 'Jadwal baru berhasil ditambahkan!');
    }

    public function updateJadwal(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'deskripsi' => 'nullable',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()->route('admin.jadwal')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroyJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
    }

    public function adminKelulusan()
    {
        $pendaftar_siap = Pendaftar::where('status_berkas', 'valid')
                                   ->where('status_bayar', 'lunas')
                                   ->with('user')
                                   ->get();

        return view('admin.kelulusan', compact('pendaftar_siap'));
    }

    public function prosesKelulusan(Request $request, $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);

        if ($request->aksi == 'lulus') {
            $pendaftar->update(['status_lulus' => 'lulus']);
            $pesan = 'Pendaftar ' . $pendaftar->user->name . ' dinyatakan LULUS!';
        } elseif ($request->aksi == 'tidak') {
            $pendaftar->update(['status_lulus' => 'tidak']);
            $pesan = 'Pendaftar ' . $pendaftar->user->name . ' dinyatakan TIDAK LULUS.';
        } else {
            return redirect()->back()->with('error', 'Aksi tidak valid.');
        }

        return redirect()->route('admin.kelulusan')->with('success', $pesan);
    }


    // ==========================================================
    // 3. UNTUK MANAJEMEN KAMPUS (GABUNGAN KEUANGAN & PIMPINAN)
    // ==========================================================

    public function manajemenDashboard()
    {
        // Statistik Pimpinan
        $total_pendaftar = Pendaftar::count();
        $lulus_seleksi = Pendaftar::where('status_lulus', 'lulus')->count();

        // Statistik Keuangan
        $belum_bayar = Pendaftar::where('status_bayar', 'belum')->count();
        $lunas = Pendaftar::where('status_bayar', 'lunas')->count();

        // Mengarahkan ke view baru
        return view('manajemen.dashboard', compact('total_pendaftar', 'lulus_seleksi', 'belum_bayar', 'lunas'));
    }

    public function keuanganValidasi()
    {
        // Mengambil pendaftar yang statusnya 'belum_bayar'
        $pendaftar_belum_bayar = Pendaftar::where('status_bayar', 'belum')->with('user')->get();
        return view('manajemen.validasi', compact('pendaftar_belum_bayar'));
    }

    public function prosesPembayaran($id)
    {
        $pendaftar = Pendaftar::findOrFail($id);

        // Update status pembayaran menjadi 'lunas'
        $pendaftar->update(['status_bayar' => 'lunas']);

        return redirect()->back()->with('success', 'Pembayaran atas nama ' . $pendaftar->user->name . ' berhasil dikonfirmasi (LUNAS).');
    }

    public function keuanganLaporan()
    {
        // Ambil semua data pendaftar yang sudah diverifikasi pembayarannya (Lunas/Belum)
        $data_laporan = Pendaftar::whereIn('status_bayar', ['lunas', 'belum'])
                                 ->with('user')
                                 ->orderBy('status_bayar', 'asc')
                                 ->get();

        return view('manajemen.laporan_keuangan', compact('data_laporan'));
    }

    public function pimpinanLaporanPendaftar()
    {
        $data_pendaftar = Pendaftar::with('user')->orderBy('created_at', 'asc')->get();
        return view('manajemen.laporan_pendaftar', compact('data_pendaftar'));
    }

    public function pimpinanLaporanKelulusan()
    {
        $data_kelulusan = Pendaftar::whereIn('status_lulus', ['lulus', 'tidak'])
                                   ->with('user')
                                   ->orderBy('status_lulus', 'desc')
                                   ->get();
        return view('manajemen.laporan_kelulusan', compact('data_kelulusan'));
    }
}
