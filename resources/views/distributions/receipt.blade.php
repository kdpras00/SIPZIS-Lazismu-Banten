@extends('layouts.guest')

@section('page-title', 'Kwitansi Distribusi Zakat - ' . $distribution->distribution_code)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                    <i class="bi bi-receipt fs-2 text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold text-primary mb-1">SIPZIS</h4>
                                    <p class="text-muted mb-0">Sistem Informasi Pengelolaan Zakat, Infaq & Shodaqoh</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h3 class="fw-bold text-dark mb-2">KWITANSI DISTRIBUSI</h3>
                            <p class="text-muted mb-1">No: {{ $distribution->distribution_code }}</p>
                            <p class="text-muted">Tanggal: {{ $distribution->distribution_date->format('d F Y') }}</p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Distribution Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="fw-semibold text-dark mb-3">
                                <i class="bi bi-person-circle me-2 text-primary"></i>
                                Detail Mustahik
                            </h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" width="120">Nama</td>
                                    <td class="fw-semibold">{{ $distribution->mustahik->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">NIK</td>
                                    <td>{{ $distribution->mustahik->nik ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Kategori</td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $distribution->mustahik->category)) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Alamat</td>
                                    <td>{{ $distribution->mustahik->address }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Telepon</td>
                                    <td>{{ $distribution->mustahik->phone ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-semibold text-dark mb-3">
                                <i class="bi bi-box-seam me-2 text-success"></i>
                                Detail Distribusi
                            </h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" width="120">Program</td>
                                    <td class="fw-semibold">{{ $distribution->program_name ?: 'Distribusi Umum' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jenis</td>
                                    <td>
                                        @switch($distribution->distribution_type)
                                            @case('cash')
                                                <span class="badge bg-success">Tunai</span>
                                                @break
                                            @case('goods')
                                                <span class="badge bg-warning">Barang</span>
                                                @break
                                            @case('service')
                                                <span class="badge bg-primary">Layanan</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ ucwords($distribution->distribution_type) }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Lokasi</td>
                                    <td>{{ $distribution->location ?: '-' }}</td>
                                </tr>
                                @if($distribution->goods_description)
                                <tr>
                                    <td class="text-muted">Deskripsi</td>
                                    <td>{{ $distribution->goods_description }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="text-muted">Diserahkan oleh</td>
                                    <td>{{ $distribution->distributedBy->name ?? 'Sistem' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Amount Section -->
                    <div class="bg-primary bg-opacity-5 rounded-3 p-4 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="text-primary fw-bold mb-2">
                                    <i class="bi bi-currency-dollar me-2"></i>
                                    Jumlah Distribusi
                                </h5>
                                <p class="text-muted mb-0">
                                    {{ $distribution->distribution_type === 'cash' ? 'Bantuan tunai sebesar:' : 'Nilai bantuan barang/layanan:' }}
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <h2 class="fw-bold text-primary mb-0">Rp {{ number_format($distribution->amount, 0, ',', '.') }}</h2>
                                <p class="text-muted small mb-0">{{ \App\Helpers\Terbilang::currencyCapitalized($distribution->amount) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Receipt Status -->
                    @if($distribution->is_received)
                    <div class="bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3 p-3 mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-75 p-2 rounded-circle me-3">
                                <i class="bi bi-check-circle text-white"></i>
                            </div>
                            <div>
                                <h6 class="text-success fw-semibold mb-1">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Distribusi Telah Diterima
                                </h6>
                                <p class="text-success mb-1">
                                    Diterima oleh: <strong>{{ $distribution->received_by_name }}</strong>
                                </p>
                                <p class="text-success small mb-0">
                                    Tanggal: {{ $distribution->received_date->format('d F Y, H:i') }}
                                </p>
                                @if($distribution->received_notes)
                                <p class="text-success small mb-0">
                                    Catatan: {{ $distribution->received_notes }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Notes -->
                    @if($distribution->notes)
                    <div class="alert alert-info">
                        <h6 class="fw-semibold mb-2">
                            <i class="bi bi-info-circle me-2"></i>
                            Catatan
                        </h6>
                        <p class="mb-0">{{ $distribution->notes }}</p>
                    </div>
                    @endif

                    <hr class="my-4">

                    <!-- Footer -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-center">
                                <p class="mb-5">Penerima,</p>
                                @if($distribution->is_received)
                                <div class="border-bottom border-dark d-inline-block px-4 mb-2">
                                    <strong>{{ $distribution->received_by_name }}</strong>
                                </div>
                                @else
                                <div class="border-bottom border-dark d-inline-block px-4 mb-2">
                                    <br><br>
                                </div>
                                @endif
                                <p class="small text-muted">{{ $distribution->mustahik->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center">
                                <p class="mb-5">Petugas Distribusi,</p>
                                <div class="border-bottom border-dark d-inline-block px-4 mb-2">
                                    <strong>{{ $distribution->distributedBy->name ?? 'Admin SIPZIS' }}</strong>
                                </div>
                                <p class="small text-muted">{{ $distribution->distribution_date->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Print Info -->
                    <div class="text-center mt-4 no-print">
                        <p class="text-muted small">
                            <i class="bi bi-info-circle me-1"></i>
                            Kwitansi ini dicetak pada {{ now()->format('d F Y, H:i') }} WIB
                        </p>
                        <div class="btn-group">
                            <button onclick="window.print()" class="btn btn-primary">
                                <i class="bi bi-printer me-2"></i>Cetak Kwitansi
                            </button>
                            <button onclick="window.close()" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print-specific styles -->
<style media="print">
    body {
        margin: 0;
        background: white !important;
    }
    
    .container-fluid {
        padding: 0 !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .no-print {
        display: none !important;
    }
    
    .btn {
        display: none !important;
    }
    
    .bg-primary {
        background-color: #0d6efd !important;
    }
    
    .text-primary {
        color: #0d6efd !important;
    }
    
    .border-bottom {
        border-bottom: 2px solid #000 !important;
    }
    
    @page {
        margin: 1cm;
        size: A4;
    }
}

/* Screen styles */
@media screen {
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
}
</style>
@endsection