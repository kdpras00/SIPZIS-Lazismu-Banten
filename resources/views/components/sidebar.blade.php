@php
$user = auth()->user();
$currentRoute = Route::currentRouteName();
@endphp

<div id="sidebar" class="sidebar d-flex flex-column p-3 h-100" style="background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%);">
    {{-- SIPZIS Logo and Text --}}
    {{-- Menggunakan d-flex dan align-items-center untuk memastikan ikon dan teks sejajar --}}
    <div class="d-flex justify-content-center align-items-center mb-3">
        <a href="{{ $user->role === 'muzakki' ? route('muzakki.dashboard') : route('dashboard') }}" class="navbar-brand text-decoration-none d-flex align-items-center">
            <i class="fas fa-mosque me-2 text-white fs-4"></i>
            <div class="d-flex flex-column">
                <span class="fw-bold fs-5" style="color: white; font-family: 'Poppins', sans-serif; margin-left: -5px;">SIPZIS</span>
            </div>
        </a>
    </div>

    <hr class="text-white">

    <ul class="nav nav-pills flex-column mb-auto">
        {{-- Dashboard --}}
        <li class="nav-item">
            <a href="{{ $user->role === 'muzakki' ? route('muzakki.dashboard') : route('dashboard') }}"
                class="nav-link {{ str_contains($currentRoute, 'dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>
        </li>

        @if($user->role === 'muzakki')
        {{-- Muzakki-specific menu items --}}
        <li class="nav-item">
            <a href="{{ route('muzakki.dashboard.transactions') }}"
                class="nav-link {{ str_contains($currentRoute, 'transactions') && str_contains($currentRoute, 'muzakki.dashboard') ? 'active' : '' }}">
                <i class="bi bi-credit-card me-2"></i>
                Transaksi saya
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('muzakki.dashboard.recurring') }}"
                class="nav-link {{ str_contains($currentRoute, 'recurring') && str_contains($currentRoute, 'muzakki.dashboard') ? 'active' : '' }}">
                <i class="bi bi-arrow-repeat me-2"></i>
                Donasi rutin saya
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('muzakki.dashboard.bank-accounts') }}"
                class="nav-link {{ str_contains($currentRoute, 'bank-accounts') && str_contains($currentRoute, 'muzakki.dashboard') ? 'active' : '' }}">
                <i class="bi bi-bank me-2"></i>
                Akun bank
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('muzakki.dashboard.management') }}"
                class="nav-link {{ str_contains($currentRoute, 'management') && str_contains($currentRoute, 'muzakki.dashboard') ? 'active' : '' }}">
                <i class="bi bi-person me-2"></i>
                Manajemen akun
            </a>
        </li>
        @else
        {{-- Admin/Staff menu items --}}
        {{-- Muzakki Management --}}
        <li class="nav-item">
            <a href="{{ route('muzakki.index') }}"
                class="nav-link {{ str_contains($currentRoute, 'muzakki') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i>
                Muzakki
            </a>
        </li>

        {{-- Mustahik Management --}}
        <li class="nav-item">
            <a href="{{ route('mustahik.index') }}"
                class="nav-link {{ str_contains($currentRoute, 'mustahik') ? 'active' : '' }}">
                <i class="bi bi-person-hearts me-2"></i>
                Mustahik
            </a>
        </li>

        {{-- Zakat Payments --}}
        <li class="nav-item">
            <a href="{{ route('payments.index') }}"
                class="nav-link {{ str_contains($currentRoute, 'payments') ? 'active' : '' }}">
                <i class="bi bi-credit-card me-2"></i>
                Pembayaran Zakat
            </a>
        </li>

        {{-- Zakat Distributions --}}
        <li class="nav-item">
            <a href="{{ route('distributions.index') }}"
                class="nav-link {{ str_contains($currentRoute, 'distributions') ? 'active' : '' }}">
                <i class="bi bi-box-seam me-2"></i>
                Distribusi Zakat
            </a>
        </li>

        {{-- News Management --}}
        <li class="nav-item">
            <a href="{{ route('admin.news.index') }}"
                class="nav-link {{ str_contains($currentRoute, 'admin.news') ? 'active' : '' }}">
                <i class="bi bi-newspaper me-2"></i>
                Kelola Berita
            </a>
        </li>

        {{-- Artikel Management --}}
        <li class="nav-item">
            <a href="{{ route('admin.artikel.index') }}"
                class="nav-link {{ str_contains($currentRoute, 'admin.artikel') ? 'active' : '' }}">
                <i class="bi bi-file-text me-2"></i>
                Kelola Artikel
            </a>
        </li>

        {{-- Reports --}}
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-file-earmark-text me-2"></i>
                Laporan
            </a>
            <ul class="dropdown-menu ms-3">
                <li>
                    <a href="{{ route('reports.incoming') }}" class="dropdown-item">
                        <i class="bi bi-arrow-down-circle me-2"></i>
                        Laporan Masuk
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports.outgoing') }}" class="dropdown-item">
                        <i class="bi bi-arrow-up-circle me-2"></i>
                        Laporan Keluar
                    </a>
                </li>
            </ul>
        </li>

        {{-- Campaign Management --}}
        <li class="nav-item">
            <a href="{{ route('admin.campaigns.index') }}"
                class="nav-link {{ str_contains($currentRoute, 'campaigns') ? 'active' : '' }}">
                <i class="bi bi-bullseye me-2"></i>
                Kelola Campaign
            </a>
        </li>

        {{-- Program Management --}}
        <li class="nav-item">
            <a href="{{ route('admin.programs.index') }}"
                class="nav-link {{ str_contains($currentRoute, 'programs') ? 'active' : '' }}">
                <i class="bi bi-grid me-2"></i>
                <span style="margin-left: -5px;">Kelola Program</span>
            </a>
        </li>
        @endif

        {{-- Divider --}}
        <hr class="text-white">
    </ul>

    {{-- User info --}}
    <div class="dropdown border-top pt-3 mt-auto">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle me-2 fs-4"></i>
            <div>
                <strong>{{ $user->name }}</strong>
                <small class="d-block">{{ ucfirst($user->role) }}</small>
            </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">Sign out</button>
                </form>
            </li>
        </ul>
    </div>
</div>

<style>
    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
    }

    /* Pastikan sidebar punya background hijau (ganti kode warna bila perlu) */
    #sidebar {
        background-color: #198754;
        /* atau ganti sesuai warna sidebarmu */
        overflow: visible;
        /* biarkan dropdown terlihat, kalau parent overflow hidden => hilang */
    }

    /* Base link warna putih */
    #sidebar .nav-link,
    #sidebar .dropdown-toggle {
        color: #fff;
    }

    /* Make dropdown behave like nested nav (tidak absolute) */
    #sidebar .nav-item.dropdown {
        position: relative;
        /* safe */
    }

    /* Override dropdown menu: tampilkan sebagai bagian sidebar, nggak putih */
    #sidebar .nav-item .dropdown-menu {
        position: static;
        /* jangan absolute */
        display: none;
        /* hidden by default, ditampilkan di hover */
        float: none;
        margin: 0;
        /* rapikan margin */
        padding: 0.25rem 0;
        /* sedikit padding vertikal */
        border: 0;
        box-shadow: none;
        background: transparent;
        /* biarkan warna sidebar terlihat */
    }

    /* Tampilkan on hover — hanya di perangkat yang support hover (desktop) */
    @media (hover: hover) and (pointer: fine) {
        #sidebar .nav-item.dropdown:hover>.dropdown-menu {
            display: block;
        }
    }

    /* Dropdown items style (sesuaikan spacing) */
    #sidebar .dropdown-item {
        color: #fff;
        padding: 0.5rem 1rem;
        background: transparent;
        border-left: 0.25rem solid transparent;
        /* opsi: indikator aktif */
    }

    /* Hover / fokus item */
    #sidebar .dropdown-item:hover,
    #sidebar .dropdown-item:focus {
        background-color: rgba(255, 255, 255, 0.06);
        /* highlight lembut */
        color: #fff;
        text-decoration: none;
    }

    /* Active state */
    #sidebar .dropdown-item.active,
    #sidebar .dropdown-item:active {
        background-color: rgba(255, 255, 255, 0.12);
        color: #fff;
        border-left-color: rgba(255, 255, 255, 0.18);
        /* optional */
    }

    /* Untuk safety: jika ada dropdown-menu-dark, override agar tetap transparan */
    #sidebar .dropdown-menu.dropdown-menu-dark {
        background: transparent;
        border: 0;
        box-shadow: none;
    }

    /* Mobile fallback: jangan paksa hover di layar kecil (biarkan klik bootstrap bekerja) */
    @media (max-width: 767.98px) {
        #sidebar .nav-item.dropdown:hover>.dropdown-menu {
            display: none;
        }

        /* Ensure dropdown works on mobile with click */
        #sidebar .nav-item.dropdown.show .dropdown-menu {
            display: block;
        }
    }

    /* Mobile sidebar toggle */
    @media (max-width: 767.98px) {
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1050;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        #sidebar.show {
            transform: translateX(0);
        }
    }



    .sidebar a {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: white;
        padding: 10px 15px;
        white-space: nowrap;
        /* 👈 mencegah teks turun ke bawah */
    }


    .sidebar a:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .sidebar i {
        font-size: 1.2rem;
    }
</style>