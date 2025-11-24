<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // ==========================================================
    // A. LOGIC USER (MABA)
    // ==========================================================
    public function userDashboard() {
        $data_pendaftar = Pendaftar::where('user_id', Auth::id())->first();
        $jadwals = Jadwal::orderBy('tanggal_mulai', 'asc')->get();
        return view('user.dashboard', compact('data_pendaftar', 'jadwals'));
    }

    public function userForm() {
        $cek = Pendaftar::where('user_id', Auth::id())->first();
        if ($cek) return redirect()->route('user.dashboard')->with('warning', 'Anda sudah mengisi formulir.');
        return view('user.formulir');
    }

    public function storeFormulir(Request $request) {
        $request->validate([
            'nisn' => 'required', 'asal_sekolah' => 'required', 'no_hp' => 'required',
            'foto' => 'required|image|max:2048', 'ijazah' => 'required|mimes:pdf,jpg,jpeg|max:2048',
        ]);
        $pathFoto = $request->file('foto')->store('uploads', 'public');
        $pathIjazah = $request->file('ijazah')->store('uploads', 'public');

        Pendaftar::create([
            'user_id' => Auth::id(), 'nisn' => $request->nisn, 'asal_sekolah' => $request->asal_sekolah,
            'no_hp' => $request->no_hp, 'path_foto' => $pathFoto, 'path_ijazah' => $pathIjazah,
            'status_berkas' => 'pending'
        ]);
        return redirect()->route('user.dashboard')->with('success', 'Pendaftaran berhasil dikirim!');
    }

    public function userCetakKartu() {
        $pendaftar = Pendaftar::where('user_id', Auth::id())->first();
        if (!$pendaftar) return redirect()->route('user.dashboard');

        $status = ($pendaftar->status_berkas == 'valid' && $pendaftar->status_bayar == 'lunas') ? 'siap' : 'belum_siap';
        return view('user.kartu', compact('pendaftar', 'status'));
    }

    public function userStatusLulus() {
        $pendaftar = Pendaftar::where('user_id', Auth::id())->first();
        return view('user.kelulusan', compact('pendaftar'));
    }

    // ==========================================================
    // B. LOGIC ADMIN
    // ==========================================================
    public function adminDashboard() {
        $total_pendaftar = Pendaftar::count();
        $perlu_verifikasi = Pendaftar::where('status_berkas', 'pending')->count();
        $lulus_seleksi = Pendaftar::where('status_lulus', 'lulus')->count();
        return view('admin.dashboard', compact('total_pendaftar', 'perlu_verifikasi', 'lulus_seleksi'));
    }

    public function adminVerifikasi() {
        $pendaftar = Pendaftar::where('status_berkas', 'pending')->with('user')->get();
        return view('admin.verifikasi', compact('pendaftar'));
    }

    public function prosesVerifikasi(Request $request, $id) {
        $pendaftar = Pendaftar::findOrFail($id);
        if ($request->aksi == 'valid') $pendaftar->update(['status_berkas' => 'valid']);
        elseif ($request->aksi == 'tolak') $pendaftar->update(['status_berkas' => 'invalid']);
        return redirect()->back()->with('success', 'Status berkas diperbarui.');
    }

    public function adminUsers() {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    public function destroyUser($id) {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User dihapus.');
    }

    public function adminJadwal() {
        $jadwals = Jadwal::latest()->get();
        return view('admin.jadwal', compact('jadwals'));
    }

    public function storeJadwal(Request $request) {
        Jadwal::create($request->except('_token')); // Pastikan model Jadwal fillable aman
        return redirect()->route('admin.jadwal')->with('success', 'Jadwal ditambah.');
    }

    public function updateJadwal(Request $request, $id) {
        Jadwal::findOrFail($id)->update($request->except('_token', '_method'));
        return redirect()->route('admin.jadwal')->with('success', 'Jadwal diupdate.');
    }

    public function destroyJadwal($id) {
        Jadwal::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Jadwal dihapus.');
    }

    public function adminKelulusan() {
        $pendaftar_siap = Pendaftar::where('status_berkas', 'valid')->where('status_bayar', 'lunas')->with('user')->get();
        return view('admin.kelulusan', compact('pendaftar_siap'));
    }

    public function prosesKelulusan(Request $request, $id) {
        $pendaftar = Pendaftar::findOrFail($id);
        $pendaftar->update(['status_lulus' => $request->aksi]); // 'lulus' atau 'tidak'
        return redirect()->route('admin.kelulusan')->with('success', 'Status kelulusan diperbarui.');
    }

    // ==========================================================
    // C. LOGIC MANAJEMEN KAMPUS (Gabungan)
    // ==========================================================
    public function manajemenDashboard() {
        $total_pendaftar = Pendaftar::count();
        $lulus_seleksi = Pendaftar::where('status_lulus', 'lulus')->count();
        $belum_bayar = Pendaftar::where('status_bayar', 'belum')->count();
        $lunas = Pendaftar::where('status_bayar', 'lunas')->count();

        return view('manajemen.dashboard', compact('total_pendaftar', 'lulus_seleksi', 'belum_bayar', 'lunas'));
    }

    public function manajemenValidasi() {
        $pendaftar_belum_bayar = Pendaftar::where('status_bayar', 'belum')->with('user')->get();
        return view('manajemen.validasi', compact('pendaftar_belum_bayar'));
    }

    public function prosesPembayaran($id) {
        Pendaftar::findOrFail($id)->update(['status_bayar' => 'lunas']);
        return redirect()->back()->with('success', 'Pembayaran dikonfirmasi LUNAS.');
    }

    public function manajemenLaporanKeuangan() {
        $data_laporan = Pendaftar::whereIn('status_bayar', ['lunas', 'belum'])->with('user')->orderBy('status_bayar', 'asc')->get();
        return view('manajemen.laporan_keuangan', compact('data_laporan'));
    }

    public function manajemenLaporanPendaftar() {
        $data_pendaftar = Pendaftar::with('user')->orderBy('created_at', 'asc')->get();
        return view('manajemen.laporan_pendaftar', compact('data_pendaftar'));
    }

    public function manajemenLaporanKelulusan() {
        $data_kelulusan = Pendaftar::whereIn('status_lulus', ['lulus', 'tidak'])->with('user')->orderBy('status_lulus', 'desc')->get();
        return view('manajemen.laporan_kelulusan', compact('data_kelulusan'));
    }
}
