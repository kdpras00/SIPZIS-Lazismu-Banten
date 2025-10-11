@php
$user = auth()->user();
$currentRoute = Route::currentRouteName();
@endphp

<div id="sidebar" class="sidebar d-flex flex-column p-3 h-100">
    {{-- SIPZIS Logo --}}
    <div class="d-flex justify-content-center align-items-center mb-3">
        <a href="{{ $user->role === 'muzakki' ? route('muzakki.dashboard') : route('dashboard') }}" 
           class="navbar-brand text-decoration-none d-flex align-items-center">
            <i class="fas fa-mosque me-2 text-white fs-4"></i>
            <span class="fw-bold fs-5 text-white" style="font-family: 'Poppins', sans-serif;">SIPZIS</span>
        </a>
    </div>

    <hr class="text-white opacity-25">

    <ul class="nav nav-pills flex-column mb-auto">
        {{-- Dashboard --}}
        <li class="nav-item">
            <a href="{{ $user->role === 'muzakki' ? route('muzakki.dashboard') : route('dashboard') }}"
                class="nav-link {{ $currentRoute === 'dashboard' || $currentRoute === 'muzakki.dashboard' ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if($user->role === 'muzakki')
            {{-- Muzakki Menu --}}
            <li class="nav-item">
                <a href="{{ route('muzakki.dashboard.transactions') }}"
                    class="nav-link {{ $currentRoute === 'muzakki.dashboard.transactions' ? 'active' : '' }}">
                    <i class="bi bi-credit-card me-2"></i>
                    <span>Transaksi Saya</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('muzakki.dashboard.recurring') }}"
                    class="nav-link {{ $currentRoute === 'muzakki.dashboard.recurring' ? 'active' : '' }}">
                    <i class="bi bi-arrow-repeat me-2"></i>
                    <span>Donasi Rutin</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('muzakki.dashboard.bank-accounts') }}"
                    class="nav-link {{ $currentRoute === 'muzakki.dashboard.bank-accounts' ? 'active' : '' }}">
                    <i class="bi bi-bank me-2"></i>
                    <span>Akun Bank</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('muzakki.dashboard.management') }}"
                    class="nav-link {{ $currentRoute === 'muzakki.dashboard.management' ? 'active' : '' }}">
                    <i class="bi bi-person me-2"></i>
                    <span>Manajemen Akun</span>
                </a>
            </li>
        @else
            {{-- Admin/Staff Menu --}}
            <li class="nav-item">
                <a href="{{ route('muzakki.index') }}"
                    class="nav-link {{ str_starts_with($currentRoute, 'muzakki.') && !str_contains($currentRoute, 'dashboard') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i>
                    <span>Muzakki</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('mustahik.index') }}"
                    class="nav-link {{ str_starts_with($currentRoute, 'mustahik.') ? 'active' : '' }}">
                    <i class="bi bi-person-hearts me-2"></i>
                    <span>Mustahik</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('payments.index') }}"
                    class="nav-link {{ str_starts_with($currentRoute, 'payments.') ? 'active' : '' }}">
                    <i class="bi bi-credit-card me-2"></i>
                    <span>Pembayaran Zakat</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('distributions.index') }}"
                    class="nav-link {{ str_starts_with($currentRoute, 'distributions.') ? 'active' : '' }}">
                    <i class="bi bi-box-seam me-2"></i>
                    <span>Distribusi Zakat</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.news.index') }}"
                    class="nav-link {{ str_starts_with($currentRoute, 'admin.news.') ? 'active' : '' }}">
                    <i class="bi bi-newspaper me-2"></i>
                    <span>Kelola Berita</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.artikel.index') }}"
                    class="nav-link {{ str_starts_with($currentRoute, 'admin.artikel.') ? 'active' : '' }}">
                    <i class="bi bi-file-text me-2"></i>
                    <span>Kelola Artikel</span>
                </a>
            </li>

            {{-- Reports Dropdown --}}
            <li class="nav-item">
                <a href="#reportsSubmenu" 
                   class="nav-link {{ str_starts_with($currentRoute, 'reports.') ? 'active' : '' }}" 
                   data-bs-toggle="collapse" 
                   aria-expanded="{{ str_starts_with($currentRoute, 'reports.') ? 'true' : 'false' }}">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    <span>Laporan</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse nav flex-column ms-3 {{ str_starts_with($currentRoute, 'reports.') ? 'show' : '' }}" 
                    id="reportsSubmenu">
                    <li class="nav-item">
                        <a href="{{ route('reports.incoming') }}" 
                           class="nav-link {{ $currentRoute === 'reports.incoming' ? 'active' : '' }}">
                            <i class="bi bi-arrow-down-circle me-2"></i>
                            <span>Laporan Masuk</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.outgoing') }}" 
                           class="nav-link {{ $currentRoute === 'reports.outgoing' ? 'active' : '' }}">
                            <i class="bi bi-arrow-up-circle me-2"></i>
                            <span>Laporan Keluar</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.campaigns.index') }}"
                    class="nav-link {{ str_starts_with($currentRoute, 'admin.campaigns.') ? 'active' : '' }}">
                    <i class="bi bi-bullseye me-2"></i>
                    <span>Kelola Campaign</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.programs.index') }}"
                    class="nav-link {{ str_starts_with($currentRoute, 'admin.programs.') ? 'active' : '' }}">
                    <i class="bi bi-grid me-2"></i>
                    <span>Kelola Program</span>
                </a>
            </li>
        @endif

        <hr class="text-white opacity-25 mt-2">
    </ul>

    {{-- User Info --}}
    {{-- <div class="dropdown border-top pt-3 mt-auto">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
            id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle me-2 fs-4"></i>
            <div class="overflow-hidden flex-grow-1">
                <strong class="d-block text-truncate">{{ $user->name }}</strong>
                <small class="d-block text-white-50">{{ ucfirst($user->role) }}</small>
            </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark shadow" aria-labelledby="dropdownUser">
            <li><a class="dropdown-item" href="{{ route('profile.show') }}">
                <i class="bi bi-person me-2"></i>Profile
            </a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="bi bi-box-arrow-right me-2"></i>Sign out
                    </button>
                </form>
            </li>
        </ul>
    </div> --}}
</div>

{{-- Mobile Toggle Button --}}
<button class="btn btn-primary d-md-none sidebar-toggle" type="button" style="position: fixed; top: 10px; left: 10px; z-index: 1060;">
    <i class="bi bi-list"></i>
</button>

<style>
/* ===== SIDEBAR BASE ===== */
#sidebar {
    background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%) !important;
    min-height: 100vh !important;
    width: 100% !important;
    max-width: 280px !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    position: sticky !important;
    top: 0 !important;
}

/* Override Tailwind conflicts */
.sidebar * {
    box-sizing: border-box !important;
}

/* ===== NAV LINKS ===== */
#sidebar .nav-link {
    color: rgba(255, 255, 255, 0.85) !important;
    padding: 0.75rem 1rem !important;
    border-radius: 0.5rem !important;
    margin-bottom: 0.25rem !important;
    transition: all 0.2s ease !important;
    display: flex !important;
    align-items: center !important;
    white-space: nowrap !important;
    width: 100% !important;
}

#sidebar .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
    color: #ffffff !important;
}

#sidebar .nav-link.active {
    background-color: rgba(255, 255, 255, 0.2) !important;
    color: #ffffff !important;
    font-weight: 500 !important;
}

#sidebar .nav-link i {
    font-size: 1.1rem !important;
    width: 24px !important;
    min-width: 24px !important;
    text-align: center !important;
    flex-shrink: 0 !important;
}

#sidebar .nav-link span {
    flex-grow: 1 !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
}

/* ===== SUBMENU / COLLAPSE ===== */
#sidebar .collapse .nav-link {
    padding: 0.6rem 1rem 0.6rem 2.5rem !important;
    font-size: 0.9rem !important;
}

#sidebar .collapse .nav-link i {
    font-size: 0.95rem !important;
}

/* Chevron rotation */
#sidebar .nav-link[data-bs-toggle="collapse"] .bi-chevron-down {
    transition: transform 0.2s ease !important;
    font-size: 0.8rem !important;
    margin-left: auto !important;
}

#sidebar .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] .bi-chevron-down {
    transform: rotate(180deg) !important;
}

/* ===== USER DROPDOWN ===== */
#sidebar .dropdown-menu {
    margin-bottom: 0.5rem !important;
    min-width: 200px !important;
}

#sidebar .dropdown-item {
    display: flex !important;
    align-items: center !important;
}

#sidebar .dropdown-item i {
    width: 20px !important;
    min-width: 20px !important;
}

/* ===== MOBILE RESPONSIVE ===== */
@media (max-width: 767.98px) {
    #sidebar {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        bottom: 0 !important;
        z-index: 1050 !important;
        width: 280px !important;
        max-width: 280px !important;
        transform: translateX(-100%) !important;
        transition: transform 0.3s ease-in-out !important;
    }

    #sidebar.show {
        transform: translateX(0) !important;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5) !important;
    }

    /* Overlay */
    #sidebar.show::before {
        content: '' !important;
        position: fixed !important;
        top: 0 !important;
        left: 280px !important;
        right: 0 !important;
        bottom: 0 !important;
        background: rgba(0, 0, 0, 0.5) !important;
        z-index: -1 !important;
    }
}

/* ===== SCROLLBAR ===== */
#sidebar::-webkit-scrollbar {
    width: 6px !important;
}

#sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05) !important;
}

#sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2) !important;
    border-radius: 3px !important;
}

#sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3) !important;
}

/* ===== PREVENT TAILWIND CONFLICTS ===== */
#sidebar .nav-item {
    width: 100% !important;
}

#sidebar ul {
    padding-left: 0 !important;
    margin-bottom: 0 !important;
    list-style: none !important;
}

#sidebar hr {
    margin: 1rem 0 !important;
    opacity: 0.25 !important;
    border-color: white !important;
}

/* Fix for parent col */
aside.col-md-3,
aside.col-lg-2 {
    padding: 0 !important;
}
</style>

<script>
// Mobile sidebar toggle
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.querySelector('.sidebar-toggle');
    
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', function(e) {
            if (sidebar.classList.contains('show') && 
                !sidebar.contains(e.target) && 
                !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    }
});
</script>