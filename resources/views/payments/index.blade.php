@extends('layouts.app')

@section('page-title', 'Manajemen Pembayaran Zakat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">
            @if(auth()->user()->role === 'muzakki')
            Riwayat Pembayaran Zakat
            @else
            Manajemen Pembayaran Zakat
            @endif
        </h2>
        <p class="text-muted">
            @if(auth()->user()->role === 'muzakki')
            Kelola dan lihat riwayat pembayaran zakat Anda
            @else
            Kelola data pembayaran zakat dalam sistem
            @endif
        </p>
    </div>
    <!-- <div>
        @if(auth()->user()->role !== 'muzakki')
        <a href="{{ route('payments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Pembayaran
        </a>
        @else
        <a href="{{ route('muzakki.payments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Bayar Zakat
        </a>
        @endif
    </div> -->
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <input type="text" id="search-input" class="form-control" placeholder="Cari kode bayar, kwitansi, nama..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select id="zakat-type-filter" class="form-select">
                    <option value="">Semua Jenis Zakat</option>
                    @foreach($zakatTypes as $type)
                    <option value="{{ $type->id }}" {{ request('zakat_type') == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select id="payment-method-filter" class="form-select">
                    <option value="">Semua Metode</option>
                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                    <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    <option value="check" {{ request('payment_method') == 'check' ? 'selected' : '' }}>Cek</option>
                    <option value="online" {{ request('payment_method') == 'online' ? 'selected' : '' }}>Online</option>
                    <option value="midtrans" {{ request('payment_method') == 'midtrans' ? 'selected' : '' }}>Midtrans</option>
                </select>
            </div>
            <div class="col-md-2">
                <select id="status-filter" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-6">
                <div class="row g-2">
                    <div class="col-6">
                        <input type="date" id="date-from" class="form-control" placeholder="Dari Tanggal" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-6">
                        <input type="date" id="date-to" class="form-control" placeholder="Sampai Tanggal" value="{{ request('date_to') }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex gap-2">
                    <button type="button" id="reset-filters" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </button>
                    <div id="search-loading" class="d-none">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-credit-card display-4 text-primary mb-2"></i>
                <h4 class="mb-0" id="total-amount">Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}</h4>
                <small class="text-muted">Total Terkumpul</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-check-circle display-4 text-success mb-2"></i>
                <h4 class="mb-0" id="total-count">{{ number_format($stats['total_count']) }}</h4>
                <small class="text-muted">Total Pembayaran</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-calendar-month display-4 text-info mb-2"></i>
                <h4 class="mb-0" id="thismonth-amount">Rp {{ number_format($stats['this_month'], 0, ',', '.') }}</h4>
                <small class="text-muted">Bulan Ini</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-clock display-4 text-warning mb-2"></i>
                <h4 class="mb-0" id="pending-count">{{ $stats['pending'] }}</h4>
                <small class="text-muted">Menunggu</small>
            </div>
        </div>
    </div>
</div>

<!-- Payments Table -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Daftar Pembayaran Zakat</h5>
    </div>
    <div class="card-body p-0" id="payments-table-container">
        @include('payments.partials.table')
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let searchTimeout;
        let currentPage = 1;

        // Configuration from server
        const config = {
            isNotMuzakki: {!! auth()->user()->role !== 'muzakki' ? 'true' : 'false' !!},
            apiRoute: '{!! route('api.payments.search') !!}',
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        // Get CSRF token
        const csrfToken = config.csrfToken;

        // Debounced search function
        function performSearch(page = 1) {
            const searchData = {
                search: document.getElementById('search-input').value,
                zakat_type: document.getElementById('zakat-type-filter').value,
                payment_method: document.getElementById('payment-method-filter').value,
                status: document.getElementById('status-filter').value,
                date_from: document.getElementById('date-from').value,
                date_to: document.getElementById('date-to').value,
                page: page
            };

            // Show loading indicator
            document.getElementById('search-loading').classList.remove('d-none');

            // Create query string
            const params = new URLSearchParams(searchData);

            const apiRoute = config.apiRoute;

            fetch(apiRoute + '?' + params.toString(), {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        // Update table
                        updateTable(response.data.payments, response.data.pagination);
                        // Update statistics
                        updateStatistics(response.data.statistics);
                        // Update current page
                        currentPage = response.data.pagination.current_page;
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                })
                .finally(() => {
                    // Hide loading indicator
                    document.getElementById('search-loading').classList.add('d-none');
                });
        }

        // Update table with new data
        function updateTable(payments, pagination) {
            let tableHtml = '';

            if (payments.length > 0) {
                tableHtml = `
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Kode Pembayaran</th>
                                ${config.isNotMuzakki ? '<th>Muzakki</th>' : ''}
                                <th>Jenis Zakat</th>
                                <th>Jumlah Bayar</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

                payments.forEach(function(payment) {
                    const paymentDate = new Date(payment.payment_date).toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });

                    // Payment method display names
                    const paymentMethods = {
                        'cash': 'Tunai',
                        'transfer': 'Transfer',
                        'check': 'Cek',
                        'online': 'Online',
                        'midtrans': 'Midtrans'
                    };

                    // Status badge classes
                    const statusClasses = {
                        'pending': 'bg-warning',
                        'completed': 'bg-success',
                        'cancelled': 'bg-danger'
                    };

                    const statusTexts = {
                        'pending': 'Menunggu',
                        'completed': 'Selesai',
                        'cancelled': 'Dibatalkan'
                    };

                    const isNotMuzakki = config.isNotMuzakki;
                    const muzakkiCell = isNotMuzakki ? `
                    <td>
                        <div class="fw-semibold">${payment.muzakki.name}</div>
                        ${payment.muzakki.phone ? '<small class="text-muted">' + payment.muzakki.phone + '</small>' : ''}
                    </td>
                ` : '';

                    tableHtml += `
                    <tr>
                        <td>
                            <div class="fw-semibold">${payment.payment_code}</div>
                            <small class="text-muted">${payment.receipt_number}</small>
                        </td>
                        ${muzakkiCell}
                        <td>
                            <span class="badge bg-info">${payment.zakat_type.name}</span>
                        </td>
                        <td>
                            <div class="fw-bold">Rp ${parseInt(payment.paid_amount).toLocaleString('id-ID')}</div>
                            ${payment.zakat_amount ? '<small class="text-muted">Zakat: Rp ' + parseInt(payment.zakat_amount).toLocaleString('id-ID') + '</small>' : ''}
                        </td>
                        <td>
                            <span class="badge bg-secondary">${paymentMethods[payment.payment_method]}</span>
                        </td>
                        <td>
                            <span class="badge ${statusClasses[payment.status]}">
                                ${statusTexts[payment.status]}
                            </span>
                        </td>
                        <td>${paymentDate}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="/payments/${payment.id}" class="btn btn-outline-info btn-sm" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="/payments/${payment.id}/receipt" class="btn btn-outline-success btn-sm" title="Kwitansi" target="_blank">
                                    <i class="bi bi-receipt"></i>
                                </a>
                                ${config.isNotMuzakki ? `
                                <a href="/payments/${payment.id}/edit" class="btn btn-outline-primary btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                ${payment.status !== 'completed' ? `
                                <form action="/payments/${payment.id}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pembayaran ini?')">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                ` : ''}
                                ` : ''}
                            </div>
                        </td>
                    </tr>
                `;
                });

                tableHtml += `
                        </tbody>
                    </table>
                </div>
            `;

                // Add pagination if needed
                if (pagination.last_page > 1) {
                    tableHtml += `
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Menampilkan ${pagination.from} sampai ${pagination.to} dari ${pagination.total} data
                            </div>
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                `;

                    if (pagination.current_page > 1) {
                        tableHtml += '<li class="page-item"><a class="page-link pagination-link" href="#" data-page="' + (pagination.current_page - 1) + '">‹</a></li>';
                    }

                    for (let i = 1; i <= pagination.last_page; i++) {
                        tableHtml += '<li class="page-item ' + (pagination.current_page == i ? 'active' : '') + '"><a class="page-link pagination-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                    }

                    if (pagination.current_page < pagination.last_page) {
                        tableHtml += '<li class="page-item"><a class="page-link pagination-link" href="#" data-page="' + (pagination.current_page + 1) + '">›</a></li>';
                    }

                    tableHtml += `
                                </ul>
                            </nav>
                        </div>
                    </div>
                `;
                }
            } else {
                tableHtml = `
                <div class="text-center py-4">
                    <i class="bi bi-inbox display-4 text-muted mb-3 d-block"></i>
                    <h5 class="text-muted">Tidak ada data pembayaran</h5>
                    <p class="text-muted">Tidak ada pembayaran yang sesuai dengan kriteria pencarian</p>
                    <button type="button" id="clear-search" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-clockwise"></i> Reset Pencarian
                    </button>
                </div>
            `;
            }

            document.getElementById('payments-table-container').innerHTML = tableHtml;
        }

        // Update statistics
        function updateStatistics(stats) {
            document.getElementById('total-amount').textContent = 'Rp ' + parseInt(stats.total_amount).toLocaleString('id-ID');
            document.getElementById('total-count').textContent = stats.total_count.toLocaleString('id-ID');
            document.getElementById('thismonth-amount').textContent = 'Rp ' + parseInt(stats.this_month).toLocaleString('id-ID');
            document.getElementById('pending-count').textContent = stats.pending.toLocaleString('id-ID');
        }

        // Search input with debouncing
        document.getElementById('search-input').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                performSearch(1);
            }, 500); // 500ms delay
        });

        // Filter changes
        document.getElementById('zakat-type-filter').addEventListener('change', function() {
            performSearch(1);
        });

        document.getElementById('payment-method-filter').addEventListener('change', function() {
            performSearch(1);
        });

        document.getElementById('status-filter').addEventListener('change', function() {
            performSearch(1);
        });

        document.getElementById('date-from').addEventListener('change', function() {
            performSearch(1);
        });

        document.getElementById('date-to').addEventListener('change', function() {
            performSearch(1);
        });

        // Reset filters
        document.getElementById('reset-filters').addEventListener('click', function() {
            document.getElementById('search-input').value = '';
            document.getElementById('zakat-type-filter').value = '';
            document.getElementById('payment-method-filter').value = '';
            document.getElementById('status-filter').value = '';
            document.getElementById('date-from').value = '';
            document.getElementById('date-to').value = '';
            performSearch(1);
        });

        // Pagination click handler (using event delegation)
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('pagination-link')) {
                e.preventDefault();
                const page = e.target.dataset.page;
                performSearch(page);
            }

            // Clear search button (using event delegation)
            if (e.target.id === 'clear-search' || e.target.closest('#clear-search')) {
                document.getElementById('search-input').value = '';
                document.getElementById('zakat-type-filter').value = '';
                document.getElementById('payment-method-filter').value = '';
                document.getElementById('status-filter').value = '';
                document.getElementById('date-from').value = '';
                document.getElementById('date-to').value = '';
                performSearch(1);
            }
        });
    });
</script>
@endpush