<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email atau password salah.');
        }

        // Simpan data user ke session
        session([
            'user_id'   => $user->id,
            'user_name' => $user->name,
<<<<<<< HEAD
            'user_role' => $user->role ?? 'admin',
=======
            'user_role' => $user->role,
>>>>>>> be5b8eccddf63807057a578f2e624d09e99c65b6
        ]);

        return redirect()->route('dashboard')
                         ->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    // Proses logout
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login')
                         ->with('success', 'Berhasil logout.');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> be5b8eccddf63807057a578f2e624d09e99c65b6
