<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login (){
        return view('auth.login');
    }

    public function register (){
        return view('auth.register');
    }

    public function store (Request $request) {
        $validation = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:8|confirmed',
            'telepon'         => 'required',
        ], [
            'name.required'     => 'Nama harus diisi.',
            'email.required'    => 'Email harus diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah digunakan oleh pengguna lain.',
            'password.required' => 'Password harus diisi.',
            'password.min'      => 'Password minimal 8arakter.',
            'password.confirmed'=> 'Password dan konfirmasi password tidak cocok.',
            'telepon.required'  => 'Telepon harus diisi.',
        ]);

        $validation['password'] = password_hash($validation['password'], PASSWORD_BCRYPT);
        $validation['role'] = 'user';

        User::create($validation);
        return redirect()->route('login')->with('success', 'Registrasi Berhasil');
    }

    public function authentication (Request $request) {
        $validation = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required'    => 'Email harus diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
            'password.min'      => 'Password minimal 8arakter.',
        ]);

        if (Auth::attempt($validation)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard-admin')->with('success', 'Login Berhasil');
        }
    }
}
