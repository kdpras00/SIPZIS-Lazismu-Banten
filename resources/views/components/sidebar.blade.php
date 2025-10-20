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
            <a href="javascript:void(0)"
                class="nav-link d-flex align-items-center {{ str_starts_with($currentRoute, 'reports.') ? 'active' : '' }}"
                aria-expanded="true"
                aria-controls="reportsSubmenu"
                id="reportsDropdown">
                <i class="bi bi-file-earmark-text me-2"></i>
                <span>Laporan</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>

            <ul class="collapse show" id="reportsSubmenu">
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
    <li>
        <hr class="dropdown-divider">
    </li>
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
    /* GANTI SEMUA CSS LAMA ANDA DENGAN BLOK INI */

    /* ===== SIDEBAR BASE ===== */
    #sidebar {
        background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%);
        min-height: 100vh;
        width: 100%;
        max-width: 280px;
        overflow-y: auto;
        /* HANYA scroll vertikal */
        /* overflow-x: hidden; <-- INI DIHAPUS, PENYEBAB UTAMA MASALAH */
        position: sticky;
        top: 0;
    }

    /* ===== NAV LINKS ===== */
    #sidebar .nav-link {
        color: rgba(255, 255, 255, 0.85);
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        margin-bottom: 0.25rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        white-space: nowrap;
        width: 100%;
    }

    #sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    #sidebar .nav-link.active {
        background-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        font-weight: 500;
    }

    #sidebar .nav-link i {
        font-size: 1.1rem;
        width: 24px;
        min-width: 24px;
        text-align: center;
        flex-shrink: 0;
    }

    #sidebar .nav-link span {
        flex-grow: 1;
        white-space: nowrap;
        overflow: hidden;
        /* Biarkan ini hidden agar teks panjang terpotong rapi */
        text-overflow: ellipsis;
    }

    /* ===== SUBMENU / COLLAPSE ===== */
    #sidebar .collapse {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 0.5rem;
        margin: 0.25rem 0;
        padding: 0.5rem 0;
    }

    #sidebar .collapse .nav-link {
        padding: 0.6rem 1rem 0.6rem 2.5rem;
        /* Indentasi untuk link submenu */
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.8);
    }

    #sidebar .collapse .nav-link:hover {
        color: #ffffff;
        background-color: rgba(255, 255, 255, 0.1);
    }

    #sidebar .collapse .nav-link.active {
        color: #ffffff;
        font-weight: bold;
        background-color: transparent;
        /* Tidak perlu background pada link aktif di submenu */
    }

    /* Chevron rotation */
    #sidebar .nav-link[data-bs-toggle="collapse"] .bi-chevron-down {
        transition: transform 0.3s ease;
        font-size: 0.8rem;
        margin-left: auto;
    }

    #sidebar .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] .bi-chevron-down {
        transform: rotate(180deg);
    }

    /* ===== MOBILE RESPONSIVE ===== */
    @media (max-width: 767.98px) {
        #sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 1050;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        #sidebar.show {
            transform: translateX(0);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }
    }

    /* ===== UTILITAS LAINNYA ===== */
    #sidebar ul {
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }

    #sidebar hr {
        margin: 1rem 0;
        opacity: 0.25;
        border-color: white;
    }

    aside.col-md-3,
    aside.col-lg-2 {
        padding: 0;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.querySelector('.sidebar-toggle');
        const reportsDropdown = document.getElementById('reportsDropdown');
        const reportsSubmenu = document.getElementById('reportsSubmenu');

        if (!sidebar || !toggleBtn) return;

        // Toggle sidebar (mobile)
        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('show');
        });

        // Handle reports dropdown - keep it always open
        if (reportsDropdown && reportsSubmenu) {
            // Prevent the default click behavior
            reportsDropdown.addEventListener('click', function(e) {
                e.preventDefault();
                // Keep the submenu always shown
                reportsSubmenu.classList.add('show');
                reportsDropdown.setAttribute('aria-expanded', 'true');

                // Ensure chevron shows correct state
                const chevron = reportsDropdown.querySelector('.bi-chevron-down');
                if (chevron) {
                    chevron.style.transform = 'rotate(180deg)';
                }
            });

            // Initialize as expanded
            reportsSubmenu.classList.add('show');
            reportsDropdown.setAttribute('aria-expanded', 'true');

            // Set chevron to expanded state
            const chevron = reportsDropdown.querySelector('.bi-chevron-down');
            if (chevron) {
                chevron.style.transform = 'rotate(180deg)';
            }
        }

        // Perbaikan utama:
        // Jangan tutup sidebar ketika klik di dalamnya, termasuk submenu dropdown
        sidebar.addEventListener('click', function(e) {
            // Jika elemen yang diklik berada di dalam sidebar, jangan lanjutkan event close
            e.stopPropagation();
        });

        // Tutup sidebar hanya jika klik di luar sidebar dan bukan tombol toggle
        document.addEventListener('click', function(e) {
            const clickedOutside = !sidebar.contains(e.target) && !toggleBtn.contains(e.target);
            if (clickedOutside && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });

        // Tutup sidebar otomatis kalau layar diperbesar
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('show');
            }
        });
    });
</script>