@extends('layouts.app')

@section('page-title', 'Dashboard Muzakki')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Assalamualaikum, {{ $muzakki->name }}!</h2>
                <p class="text-muted">Dashboard Muzakki - Sistem Zakat</p>
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
                        <small class="text-light">{{ $stats['last_payment']->zakatType->name ?? 'Donasi Umum' }}</small>
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

<div class="row">
    <!-- Quick Actions -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-lightning"></i> Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('payments.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Bayar Zakat
                    </a>
                    <a href="{{ route('calculator.index') }}" class="btn btn-info">
                        <i class="bi bi-calculator"></i> Hitung Zakat
                    </a>
                    <a href="{{ route('calculator.guide') }}" class="btn btn-success">
                        <i class="bi bi-book"></i> Panduan Zakat
                    </a>
                </div>

                <!-- Zakat Calculator Mini -->
                <hr>
                <h6>Kalkulator Zakat Cepat</h6>
                <form id="quickCalculator">
                    @csrf
                    <div class="mb-2">
                        <select name="zakat_type_id" class="form-select form-select-sm" required>
                            <option value="">Pilih Jenis</option>
                            @foreach($zakatTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <input type="text" name="wealth_amount" class="form-control form-control-sm currency-input" placeholder="Jumlah Harta" required>
                    </div>
                    <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                        <i class="bi bi-calculator"></i> Hitung
                    </button>
                </form>
                <div id="quickResult" class="mt-2"></div>
            </div>
        </div>
    </div>

    <!-- Yearly Summary -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Ringkasan Per Tahun</h5>
            </div>
            <div class="card-body">
                @forelse($yearlyPayments as $yearly)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0">{{ $yearly->year }}</h6>
                        <small class="text-muted">Tahun</small>
                    </div>
                    <div class="text-end">
                        <strong>Rp {{ number_format($yearly->total, 0, ',', '.') }}</strong>
                    </div>
                </div>
                @empty
                <p class="text-center text-muted">
                    <i class="bi bi-inbox display-4 d-block mb-2"></i>
                    Belum ada riwayat pembayaran
                </p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-credit-card"></i> Riwayat Terbaru</h5>
                <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @forelse($recentPayments as $payment)
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                    <div>
                        <h6 class="mb-1">{{ $payment->zakatType->name ?? 'Donasi Umum' }}</h6>
                        <small class="text-muted">{{ $payment->payment_code }}</small>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold">Rp {{ number_format($payment->paid_amount, 0, ',', '.') }}</div>
                        <small class="text-muted">{{ $payment->payment_date->format('d M Y') }}</small>
                    </div>
                </div>
                @empty
                <div class="p-3 text-center text-muted">
                    <i class="bi bi-inbox display-4 d-block mb-2"></i>
                    Belum ada pembayaran
                    <div class="mt-2">
                        <a href="{{ route('payments.create') }}" class="btn btn-sm btn-primary">
                            Bayar Sekarang
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Profile Information -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-person-circle"></i> Informasi Profil</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>Nama</strong></td>
                                <td>: {{ $muzakki->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>: {{ $muzakki->email ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Telepon</strong></td>
                                <td>: {{ $muzakki->phone ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>NIK</strong></td>
                                <td>: {{ $muzakki->nik ?: '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>Alamat</strong></td>
                                <td>: {{ $muzakki->address ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kota</strong></td>
                                <td>: {{ $muzakki->city ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pekerjaan</strong></td>
                                <td>: {{ ucfirst(str_replace('_', ' ', $muzakki->occupation)) ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Bergabung</strong></td>
                                <td>: {{ $muzakki->created_at->format('d F Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quick calculator form
        const quickForm = document.getElementById('quickCalculator');
        if (quickForm) {
            quickForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(quickForm);
                const resultDiv = document.getElementById('quickResult');

                resultDiv.innerHTML = '<div class="spinner-zakat mx-auto"></div>';

                fetch('/calculator/calculate', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        let html = '';
                        if (data.is_eligible) {
                            html = `<div class="alert alert-success alert-sm p-2">
                        <strong>Wajib Zakat</strong><br>
                        <small>Zakat: Rp ${new Intl.NumberFormat('id-ID').format(data.zakat_amount)}</small>
                    </div>`;
                        } else {
                            html = `<div class="alert alert-warning alert-sm p-2">
                        <strong>Belum Wajib</strong><br>
                        <small>Nisab: Rp ${new Intl.NumberFormat('id-ID').format(data.nisab_amount)}</small>
                    </div>`;
                        }
                        resultDiv.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        resultDiv.innerHTML = '<div class="alert alert-danger alert-sm p-2">Error calculating</div>';
                    });
            });
        }
    });
</script>
@endpush