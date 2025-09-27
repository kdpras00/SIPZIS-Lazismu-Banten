<nav class="navbar navbar-expand-lg shadow-sm py-3 mb-3" style="background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%); border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container-fluid">
        <button class="btn btn-outline-light d-lg-none" type="button" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>

        <div class="ms-auto d-flex align-items-center">
            <div class="dropdown me-4">
                <button class="btn btn-outline-light position-relative px-3 py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-5"></i>
                    @if(auth()->user()->role !== 'muzakki')
                    @php
                    $pendingMustahik = \App\Models\Mustahik::pending()->count();
                    @endphp
                    @if($pendingMustahik > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $pendingMustahik }}
                    </span>
                    @endif
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                    @if(auth()->user()->role !== 'muzakki')
                    @if($pendingMustahik > 0)
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('mustahik.index', ['status' => 'pending']) }}">
                            <i class="bi bi-person-exclamation-fill text-warning me-2"></i>
                            {{ $pendingMustahik }} mustahik menunggu verifikasi
                        </a>
                    </li>
                    @else
                    <li><span class="dropdown-item text-muted">Tidak ada notifikasi</span></li>
                    @endif
                    @else
                    <li><span class="dropdown-item text-muted">Tidak ada notifikasi</span></li>
                    @endif
                </ul>
            </div>

            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle px-3 py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle fs-5 me-2"></i>
                    {{ auth()->user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                    <li>
                        <h6 class="dropdown-header">{{ ucfirst(auth()->user()->role) }}</h6>
                    </li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>