@extends('layouts.app')

@section('page-title', 'Dashboard Muzakki')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Assalamualaikum, {{ $muzakki->name }}!</h2>
                <p class="text-muted">Selamat datang di dashboard muzakki Anda</p>
            </div>
            <div class="text-end">
                <small class="text-muted">{{ now()->format('d F Y') }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase mb-1">Total Zakat</h6>
                        <h4 class="mb-0">Rp {{ number_format($stats['total_zakat_paid'], 0, ',', '.') }}</h4>
                        <small class="text-light">Sepanjang masa</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-currency-dollar display-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase mb-1">Zakat {{ date('Y') }}</h6>
                        <h4 class="mb-0">Rp {{ number_format($stats['zakat_this_year'], 0, ',', '.') }}</h4>
                        <small class="text-light">Tahun ini</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-calendar display-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm stat-card info">
            <div class="card-body text-dark">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase mb-1">Jumlah Pembayaran</h6>
                        <h4 class="mb-0">{{ number_format($stats['payment_count']) }}</h4>
                        <small>Kali pembayaran</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-credit-card display-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase mb-1">Terakhir Bayar</h6>
                        @if($stats['last_payment'])
                        <h6 class="mb-0">{{ $stats['last_payment']->payment_date->format('d M Y') }}</h6>
                        <small class="text-light">{{ $stats['last_payment']->programType ? $stats['last_payment']->programType->name : 'Donasi Umum' }}</small>
                        @else
                        <h6 class="mb-0">Belum ada</h6>
                        <small class="text-light">Pembayaran</small>
                        @endif
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-clock display-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Navigation Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <a href="{{ route('muzakki.dashboard.transactions') }}" class="card border-0 shadow-sm text-decoration-none h-100">
            <div class="card-body text-center">
                <i class="bi bi-credit-card display-4 text-primary mb-3"></i>
                <h5>Transaksi Saya</h5>
                <p class="text-muted small">Lihat riwayat pembayaran zakat Anda</p>
            </div>
        </a>
    </div>

    <div class="col-md-3 mb-3">
        <a href="{{ route('muzakki.dashboard.recurring') }}" class="card border-0 shadow-sm text-decoration-none h-100">
            <div class="card-body text-center">
                <i class="bi bi-arrow-repeat display-4 text-success mb-3"></i>
                <h5>Donasi Rutin</h5>
                <p class="text-muted small">Atur donasi otomatis setiap bulan</p>
            </div>
        </a>
    </div>

    <div class="col-md-3 mb-3">
        <a href="{{ route('muzakki.dashboard.bank-accounts') }}" class="card border-0 shadow-sm text-decoration-none h-100">
            <div class="card-body text-center">
                <i class="bi bi-bank display-4 text-info mb-3"></i>
                <h5>Akun Bank</h5>
                <p class="text-muted small">Kelola rekening bank Anda</p>
            </div>
        </a>
    </div>

    <div class="col-md-3 mb-3">
        <a href="{{ route('muzakki.dashboard.management') }}" class="card border-0 shadow-sm text-decoration-none h-100">
            <div class="card-body text-center">
                <i class="bi bi-person-gear display-4 text-warning mb-3"></i>
                <h5>Manajemen Akun</h5>
                <p class="text-muted small">Kelola profil dan pengaturan akun</p>
            </div>
        </a>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Aktivitas Terbaru</h5>
            </div>
            <div class="card-body p-0">
                @if($recentPayments->count() > 0)
                @foreach($recentPayments as $payment)
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                    <div>
                        <h6 class="mb-1">{{ $payment->programType ? $payment->programType->name : 'Donasi Umum' }}</h6>
                        <small class="text-muted">{{ $payment->payment_code }}</small>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold">Rp {{ number_format($payment->paid_amount, 0, ',', '.') }}</div>
                        <small class="text-muted">{{ $payment->payment_date->format('d M Y') }}</small>
                    </div>
                </div>
                @endforeach
                @else
                <div class="p-3 text-center text-muted">
                    <i class="bi bi-inbox display-4 d-block mb-2"></i>
                    Belum ada aktivitas
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection