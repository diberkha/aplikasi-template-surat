<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        if (Auth::check()) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('login')->with('info', 'Sesi sebelumnya telah berakhir. Silakan login kembali');
        }

        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required']
        ]);

        if (
            Auth::attempt([
                'username' => $credentials['username'],
                'password' => $credentials['password']
            ])
        ) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah',
        ])->withInput();
    }
}
