<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pendaftar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin() {
        return view('login');
    }

    public function prosesLogin(Request $request) {
        $credentials = $request->only('email', 'password');

        // 1. Cek Login
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // 2. Cek Status Akun (Wajib Active untuk login)
            if ($user->status !== 'active') {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun Anda belum aktif. Silakan hubungi Admin.']);
            }

            // 3. Redirection Sesuai Role
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
        // 1. Validasi Input Lengkap (Akun + Biodata)
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
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'alamat' => 'required|string',
        ]);

        // Gunakan Database Transaction agar pembuatan User dan Pendaftar aman
        DB::transaction(function () use ($request) {

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
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'alamat' => $request->alamat,
                'status_berkas' => 'pending'
            ]);

        });

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Akun Anda sedang menunggu verifikasi Admin.');
    }
}
