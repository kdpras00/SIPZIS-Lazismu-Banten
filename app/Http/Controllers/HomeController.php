<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Jika user login dan role-nya admin/staff → redirect ke dashboard
        if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'staff')) {
            return redirect()->route('dashboard');
        }

        // Jika tidak, tampilkan halaman umum
        return view('pages.home');
    }
}
