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

    // Di method login() setelah Auth::login($user)
    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'muzakki') {
            $muzakki = Muzakki::where('user_id', $user->id)->first();

            if ($muzakki && (empty($muzakki->campaign_url) || !$muzakki->campaign_url)) {
                $muzakki->campaign_url = url('/campaigner/' . $muzakki->email);
                $muzakki->save();
            }
        }
    }

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

            // Generate campaign URL if not exists
            if ($user->role === 'muzakki') {
                $muzakki = Muzakki::where('user_id', $user->id)->first();

                if ($muzakki && (empty($muzakki->campaign_url) || !$muzakki->campaign_url)) {
                    $muzakki->campaign_url = url('/campaigner/' . $muzakki->email);
                    $muzakki->save();
                }
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
            'phone' => 'nullable|string|max:20|unique:users', // Tambahkan unique validation
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'phone.unique' => 'Nomor telepon sudah terdaftar.', // Custom error message
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Gabungkan kode negara dengan nomor telepon
            $fullPhone = null;
            if ($request->phone) {
                $countryCode = $request->country_code ?? '+62';
                // Hapus karakter + dari country code
                $countryCode = str_replace('+', '', $countryCode);
                // Hapus leading zero jika ada
                $phone = ltrim($request->phone, '0');
                $fullPhone = $countryCode . $phone;
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'muzakki',
                'is_active' => true,
                'phone' => $fullPhone,
            ]);

            // Generate campaign URL
            $campaignUrl = url('/campaigner/' . $request->email);

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
                    'campaign_url' => $campaignUrl, // Add campaign URL
                ]
            );

            session(['registered_email' => $request->email]);

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
        // Ambil data user sebelum logout
        $user = Auth::user();

        // Logout pengguna
        Auth::logout();

        // Invalidate session dan regenerate token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect dengan pesan sukses
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }

    // Handle Firebase authentication
    public function firebaseLogin(Request $request)
    {
        $request->validate([
            'uid' => 'required|string',
            'email' => 'required|email',
            'name' => 'required|string',
            'phone' => 'nullable|string',
        ]);

        try {
            // Check if user exists or create new one
            $user = User::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'password' => Hash::make(uniqid()), // Generate random password for Firebase users
                    'role' => 'muzakki',
                    'is_active' => true,
                    'phone' => $request->phone ?? null,
                ]
            );

            // Update or create muzakki profile
            // Generate campaign URL
            $campaignUrl = url('/campaigner/' . $request->email);

            Muzakki::updateOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'phone' => $request->phone ?? null,
                    'user_id' => $user->id,
                    'is_active' => true,
                    'campaign_url' => $campaignUrl, // Add campaign URL
                ]
            );

            // Log in the user
            Auth::login($user);

            return response()->json([
                'success' => true,
                'redirect' => '/',
                'message' => 'Login successful'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
