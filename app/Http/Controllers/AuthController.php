<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pendaftar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // Wajib di-import

class AuthController extends Controller
{
    public function showLogin() {
        return view('login');
    }

    public function prosesLogin(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status !== 'active') {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun Anda belum aktif. Silakan hubungi Admin.']);
            }

            $role = $user->role;

            if($role == 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if($role == 'manajemen') {
                return redirect()->route('manajemen.dashboard');
            }

            if($role == 'user') {
                return redirect()->route('user.dashboard');
            }
        }

        return back()->withErrors(['email' => 'Akun tidak ditemukan atau password salah']);
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }

    public function showRegister() {
        return view('register');
    }

    public function prosesRegister(Request $request) {

        // 1. Validasi Input Lengkap (Termasuk File)
        $request->validate([
            // Akun
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',

            // Biodata
            'nisn' => 'required|numeric',
            'asal_sekolah' => 'required|string',
            'no_hp' => 'required|numeric',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'jalur' => 'required|in:SNBP,SNBT,Mandiri,Lainnya',
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'alamat' => 'required|string',

            // File Upload
            'foto' => 'required|image|max:2048',
            'ijazah' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // 2. Upload File (Dilakukan sebelum transaction)
        $pathFoto = $request->file('foto')->store('uploads/foto', 'public');
        $pathIjazah = $request->file('ijazah')->store('uploads/ijazah', 'public');


        // 3. Simpan Data ke DB dalam Transaction
        DB::transaction(function () use ($request, $pathFoto, $pathIjazah) {

            // A. Buat Akun User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
                'status' => 'pending'
            ]);

            // B. Buat Data Biodata Pendaftar
            Pendaftar::create([
                'user_id' => $user->id,
                'nisn' => $request->nisn,
                'asal_sekolah' => $request->asal_sekolah,
                'no_hp' => $request->no_hp,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'jalur' => $request->jalur,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'alamat' => $request->alamat,

                // Simpan Path File
                'path_foto' => $pathFoto,
                'path_ijazah' => $pathIjazah,

                'status_berkas' => 'pending'
            ]);

        });

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Akun Anda sedang menunggu verifikasi Admin.');
    }
}
