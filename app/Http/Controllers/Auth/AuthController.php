<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Muzakki;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.']);
            }

            $request->session()->regenerate();

            // Redirect based on role
            switch ($user->role) {
                case 'admin':
                case 'staff':
                    return redirect()->intended('/dashboard');
                case 'muzakki':
                    return redirect()->intended('/muzakki/dashboard');
                default:
                    return redirect()->intended('/');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'nik' => 'required|string|max:20|unique:muzakki',
            'gender' => 'required|in:male,female',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'occupation' => 'required|in:employee,entrepreneur,civil_servant,teacher,doctor,farmer,trader,other',
            'monthly_income' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'muzakki',
            'is_active' => true,
            'phone' => $request->phone,
        ]);

        // Create muzakki profile
        Muzakki::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nik' => $request->nik,
            'gender' => $request->gender,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'occupation' => $request->occupation,
            'monthly_income' => $request->monthly_income,
            'date_of_birth' => $request->date_of_birth,
            'user_id' => $user->id,
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect('/muzakki/dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Sistem Zakat.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}
