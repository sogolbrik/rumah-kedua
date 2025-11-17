<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
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
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8arakter.',
            'password.confirmed' => 'Password dan konfirmasi password tidak cocok.',
            'telepon.required' => 'Telepon harus diisi.',
        ]);

        try {
            // Normalisasi nomor telepon: hilangkan spasi, +, dan -; ganti leading 0 dengan 62
            $telepon = preg_replace('/[^0-9]/', '', $validation['telepon']);
            if (str_starts_with($telepon, '0')) {
                $telepon = '62' . substr($telepon, 1);
            }
            $validation['telepon'] = $telepon;

            $validation['password'] = password_hash($validation['password'], PASSWORD_BCRYPT);
            $validation['role'] = 'user';

            $user = User::create($validation);

            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Registrasi Berhasil! Selamat datang.');
        } catch (\Throwable $th) {
            //throw $th;
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
            'password.min' => 'Password minimal 8arakter.',
        ]);

        if (Auth::attempt($validation)) {
            $request->session()->regenerate();
            if (Auth::user()->role == 'admin') {
                return redirect()->intended('dashboard-admin')->with('success', 'Login Berhasil');
            } elseif (Auth::user()->role == 'penghuni') {
                return redirect()->intended('/')->with('success', 'Login Berhasil');
            } else {
                return redirect()->intended('/')->with('success', 'Login Berhasil');
            }
        }

        return redirect()->back()->with('error', 'Email atau password salah.');
    }
}
