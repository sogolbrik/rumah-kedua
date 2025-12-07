<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str; // ✅ Import ini

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
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Password dan konfirmasi password tidak cocok.',
            'telepon.required' => 'Telepon harus diisi.',
        ]);

        try {
            $telepon = preg_replace('/[^0-9]/', '', $validation['telepon']);
            if (str_starts_with($telepon, '0')) {
                $telepon = '62' . substr($telepon, 1);
            }
            $validation['telepon'] = $telepon;
            $validation['password'] = bcrypt($validation['password']);
            $validation['role'] = 'user';

            $user = User::create($validation);

            $this->sendWelcomeWhatsApp($validation['telepon'], $validation['name']);

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

        if (Auth::attempt($validation)) {
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

    private function sendWelcomeWhatsApp($number, $name)
    {
        try {
            $message = "Halo *{$name}*! 👋

            Terima kasih sudah mendaftar di *RumahKedua*.

            Sekarang kamu bisa:
            > • *Cari & pesan kamar kos* langsung dari Website  
            > • *Pantau status pembayaran* dengan mudah  
            > • *Dapat update kamar kosong* lebih cepat

            Jika butuh bantuan, cukup balas pesan ini ya.  
            - *RumahKedua*";

            $response = Http::timeout(30)->get("http://localhost:5000/api/Whatsapp/openandsend", [
                'number' => $number,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            //
        }
    }
}