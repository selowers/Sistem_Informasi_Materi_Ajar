<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|in:admin,guru',
        ]);

        $user = User::where('email', $credentials['email'])
            ->where('role', $credentials['role'])
            ->first();

        if ($user && $user->status === 'nonaktif') {
            if (Hash::check($credentials['password'], $user->password)) {
                return back()->withErrors([
                    'email' => 'Akun Anda sudah tidak aktif. Silakan hubungi administrator.',
                ])->onlyInput('email');
            }
        }

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'role' => $credentials['role'],
            'status' => 'aktif',
        ], $request->boolean('remember'))){
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
