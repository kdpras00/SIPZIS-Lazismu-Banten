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

    public function showAdminLogin()
    {
        return view('auth.admin-login');
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

            // Check if user has muzakki role
            if ($user->role !== 'muzakki') {
                Auth::logout();
                return back()->withErrors(['email' => 'Halaman ini hanya untuk muzakki. Silakan gunakan halaman login admin.']);
            }

            $request->session()->regenerate();

            // Redirect muzakki users to home page
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    public function adminLogin(Request $request)
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

            // Check if user has admin or staff role
            if ($user->role !== 'admin' && $user->role !== 'staff') {
                Auth::logout();
                return back()->withErrors(['email' => 'Anda tidak memiliki akses ke halaman admin.']);
            }

            $request->session()->regenerate();

            // Redirect to appropriate dashboard based on role
            if ($user->role === 'admin') {
                return redirect()->route('dashboard');
            } else {
                // For staff, you might want a different dashboard
                return redirect()->route('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    public function showRegister()
    {
        // Get email from session if available (for pre-filling)
        $prefillEmail = session('registered_email', '');

        return view('auth.register', compact('prefillEmail'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'muzakki',
                'is_active' => true,
                'phone' => $request->phone ?? null,
            ]);

            // Gunakan updateOrCreate untuk hindari duplikat
            Muzakki::updateOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'phone' => $request->phone ?? null,
                    'nik' => $request->nik ?? null,
                    'gender' => $request->gender ?? null,
                    'address' => $request->address ?? null,
                    'city' => $request->city ?? null,
                    'province' => $request->province ?? null,
                    'occupation' => $request->occupation ?? null,
                    'monthly_income' => $request->monthly_income ?? null,
                    'date_of_birth' => $request->date_of_birth ?? null,
                    'user_id' => $user->id,
                    'is_active' => true,
                ]
            );

            // Store the registered email in session for pre-filling on next registration
            session(['registered_email' => $request->email]);

            // Redirect to login page with success message instead of auto-login
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
        } catch (\Exception $e) {
            if (isset($user)) {
                $user->delete();
            }

            return back()->withErrors([
                'email' => 'Registrasi gagal: ' . $e->getMessage(),
            ])->withInput();
        }
    }


    public function logout(Request $request)
    {
        // Store the referrer URL before logout
        $referrer = $request->headers->get('referer');

        // Get the authenticated user before logging out
        $user = Auth::user();

        // Perform logout
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Check if the referrer contains admin paths
        if ($referrer && (strpos($referrer, '/admin') !== false || strpos($referrer, '/dashboard') !== false)) {
            return redirect('/admin/login')->with('success', 'Anda telah berhasil logout.');
        } else {
            return redirect('/')->with('success', 'Anda telah berhasil logout.');
        }
    }
}
