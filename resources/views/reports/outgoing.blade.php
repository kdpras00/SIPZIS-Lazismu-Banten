@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Laporan Keluar</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Laporan Keluar</li>
    </ol>
    
    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i>
            Filter Data
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.outgoing') }}" id="filterForm">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="date_from" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="date_to" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="distribution_type" class="form-label">Jenis Distribusi</label>
                        <select class="form-select" id="distribution_type" name="distribution_type">
                            <option value="">Semua Jenis</option>
                            <option value="cash" {{ request('distribution_type') == 'cash' ? 'selected' : '' }}>Tunai</option>
                            <option value="goods" {{ request('distribution_type') == 'goods' ? 'selected' : '' }}>Barang</option>
                            <option value="voucher" {{ request('distribution_type') == 'voucher' ? 'selected' : '' }}>Voucher</option>
                            <option value="service" {{ request('distribution_type') == 'service' ? 'selected' : '' }}>Layanan</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="category" class="form-label">Kategori Mustahik</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ \App\Models\Mustahik::CATEGORIES[$category] ?? $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="search" class="form-label">Cari (Kode Distribusi, Nama Mustahik)</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Masukkan kata kunci..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-end">
                        <div>
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-1"></i> Filter
                            </button>
                            <a href="{{ route('reports.outgoing') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-sync me-1"></i> Reset
                            </a>
                            <!-- Export Buttons -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-download me-1"></i> Export
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button type="button" class="dropdown-item" onclick="exportReport('pdf')">
                                            PDF
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item" onclick="exportReport('excel')">
                                            Excel (CSV)
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Distribusi</div>
                            <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['total_count'], 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-donate fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Nominal</div>
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($stats['this_month'], 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Pending Diterima</div>
                            <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['pending_receipt'], 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Balance Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Saldo Tersedia</div>
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($stats['available_balance'], 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Distribusi Zakat
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Distribusi</th>
                            <th>Nama Mustahik</th>
                            <th>Kategori</th>
                            <th>Jenis Distribusi</th>
                            <th>Nominal</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($distributions as $distribution)
                            <tr>
                                <td>{{ $loop->iteration + ($distributions->currentPage() - 1) * $distributions->perPage() }}</td>
                                <td>{{ $distribution->distribution_code }}</td>
                                <td>{{ $distribution->mustahik->name }}</td>
                                <td>{{ \App\Models\Mustahik::CATEGORIES[$distribution->mustahik->category] ?? $distribution->mustahik->category }}</td>
                                <td>
                                    @switch($distribution->distribution_type)
                                        @case('cash')
                                            Tunai
                                            @break
                                        @case('goods')
                                            Barang
                                            @break
                                        @case('voucher')
                                            Voucher
                                            @break
                                        @case('service')
                                            Layanan
                                            @break
                                    @endswitch
                                </td>
                                <td>Rp {{ number_format($distribution->amount, 0, ',', '.') }}</td>
                                <td>{{ $distribution->distribution_date->format('d M Y') }}</td>
                                <td>
                                    @if($distribution->is_received)
                                        <span class="badge bg-success">Sudah Diterima</span>
                                    @else
                                        <span class="badge bg-warning">Belum Diterima</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data distribusi zakat</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Menampilkan {{ $distributions->count() }} dari {{ $distributions->total() }} data
                </div>
                <div>
                    {{ $distributions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function exportReport(format) {
    // Get current form data
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    
    // Build query string
    const params = new URLSearchParams();
    for (const [key, value] of formData.entries()) {
        if (value) {
            params.append(key, value);
        }
    }
    
    // Add export parameter
    params.append('export', format);
    
    // Redirect to export URL
    window.location.href = "{{ route('reports.outgoing') }}?" + params.toString();
}

document.addEventListener('DOMContentLoaded', function() {
    // Ensure dropdown functionality works
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });
});
</script>
@endpush
@endsection