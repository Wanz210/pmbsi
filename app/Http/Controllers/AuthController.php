<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // [PERBAIKAN] TAMBAHKAN INI
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin() { return view('login'); }

    public function prosesLogin(Request $request) {
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate(); // Penting untuk keamanan session

            $role = Auth::user()->role;

            if($role == 'admin') return redirect()->route('admin.dashboard');
            if($role == 'keuangan' || $role == 'pimpinan' || $role == 'manajemen') {
                return redirect()->route('manajemen.dashboard');
            }

            return redirect()->route('user.dashboard');
        }
        return back()->withErrors(['email' => 'Akun tidak ditemukan']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function prosesRegister(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed', // 'confirmed' berarti harus ada kolom password_confirmation
        ]);

        // 2. Simpan User Baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Otomatis mengatur role pendaftar baru sebagai 'user'
        ]);

        // 3. Langsung Login setelah berhasil daftar
        Auth::login($user);

        // 4. Redirect ke dashboard user
        return redirect()->route('user.dashboard')->with('success', 'Akun berhasil dibuat! Silakan lengkapi formulir pendaftaran.');
    }
}
