<?php

namespace App\Http\Controllers;

use App\Jobs\SendWelcomeWhatsApp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        if (!Auth::check()) {
            Auth::viaRemember();
        }

        if (Auth::check()) {
            // Berhasil login via remember cookie → redirect ke dashboard
            if (Auth::user()->role === 'admin') {
                return redirect('dashboard-admin');
            } elseif (Auth::user()->role === 'penghuni') {
                return redirect('dashboard-penghuni');
            }
            return redirect('/');
        }

        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'telepon' => 'required',
            'terms' => 'required|accepted'
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Password dan konfirmasi password tidak cocok.',
            'telepon.required' => 'Telepon harus diisi.',
            'terms.required' => 'Anda harus menyetujui syarat dan ketentuan.',
        ]);

        try {
            $telepon = preg_replace('/[^0-9]/', '', $validation['telepon']);
            if (str_starts_with($telepon, '0')) {
                $telepon = '62' . substr($telepon, 1);
            }
            $validation['telepon'] = $telepon;

            $plainPassword = $validation['password'];
            $validation['password'] = bcrypt($plainPassword);
            $validation['role'] = 'user';

            $user = User::create($validation);

            SendWelcomeWhatsApp::dispatch($telepon, $validation['name'], $validation['email'], $plainPassword);

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('/')->with('success', 'Registrasi Berhasil! Selamat datang.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Registrasi gagal, periksa kembali.');
        }
    }


    public function authentication(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($validation, $remember)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect('dashboard-admin')->with('success', 'Login Berhasil');
            } elseif (Auth::user()->role === 'penghuni') {
                return redirect()->intended('dashboard-penghuni')->with('success', 'Login Berhasil');
            }

            return redirect()->intended('/')->with('success', 'Login Berhasil');
        }

        return redirect()->back()->with('error', 'Email atau password salah.');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/')->with('success', 'Logout Berhasil');
        } else {
            return redirect()->back()->with('error', 'Logout Gagal');
        }
    }
}