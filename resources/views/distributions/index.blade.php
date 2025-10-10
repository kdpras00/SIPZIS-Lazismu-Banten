@extends('layouts.app')

@section('page-title', 'Manajemen Distribusi Zakat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Manajemen Distribusi Zakat</h2>
        <p class="text-muted">Kelola dan pantau distribusi zakat kepada mustahik</p>
    </div>
    <div>
        <a href="{{ route('distributions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Distribusi
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <input type="text" id="search-input" class="form-control" placeholder="Cari kode distribusi, program, nama mustahik..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select id="category-filter" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $category)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select id="distribution-type-filter" class="form-select">
                    <option value="">Semua Jenis</option>
                    <option value="cash" {{ request('distribution_type') == 'cash' ? 'selected' : '' }}>Tunai</option>
                    <option value="goods" {{ request('distribution_type') == 'goods' ? 'selected' : '' }}>Barang</option>
                    <option value="voucher" {{ request('distribution_type') == 'voucher' ? 'selected' : '' }}>Voucher</option>
                    <option value="service" {{ request('distribution_type') == 'service' ? 'selected' : '' }}>Layanan</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" id="program-filter" class="form-control" placeholder="Program" value="{{ request('program') }}">
            </div>
            <div class="col-md-2">
                <select id="received-status-filter" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="received" {{ request('received_status') == 'received' ? 'selected' : '' }}>Sudah Diterima</option>
                    <option value="pending" {{ request('received_status') == 'pending' ? 'selected' : '' }}>Belum Diterima</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="button" id="reset-filters" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <input type="date" id="date-from" class="form-control" placeholder="Dari Tanggal" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <input type="date" id="date-to" class="form-control" placeholder="Sampai Tanggal" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-6">
                <div id="search-loading" class="d-none">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="ms-2">Mencari...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-cash-stack display-4 text-primary mb-2"></i>
                <h5 class="mb-0" id="total-amount">Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}</h5>
                <small class="text-muted">Total Distribusi</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-people display-4 text-success mb-2"></i>
                <h5 class="mb-0" id="total-count">{{ number_format($stats['total_count']) }}</h5>
                <small class="text-muted">Total Penerima</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-calendar-month display-4 text-info mb-2"></i>
                <h5 class="mb-0" id="thismonth-amount">Rp {{ number_format($stats['this_month'], 0, ',', '.') }}</h5>
                <small class="text-muted">Bulan Ini</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-clock display-4 text-warning mb-2"></i>
                <h5 class="mb-0" id="pending-count">{{ $stats['pending_receipt'] }}</h5>
                <small class="text-muted">Belum Diterima</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-wallet2 display-4 text-{{ $stats['available_balance'] > 0 ? 'success' : 'danger' }} mb-2"></i>
                <h5 class="mb-0" id="available-balance">Rp {{ number_format($stats['available_balance'], 0, ',', '.') }}</h5>
                <small class="text-muted">Saldo Tersedia</small>
            </div>
        </div>
    </div>
</div>

<!-- Distributions Table -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Daftar Distribusi Zakat</h5>
    </div>
    <div class="card-body p-0" id="distributions-table-container">
        @include('distributions.partials.table')
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
            apiRoute: "{{ route('api.distributions.search') }}",
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        // Get CSRF token
        const csrfToken = config.csrfToken;

        // Debounced search function
        function performSearch(page = 1) {
            const searchData = {
                search: document.getElementById('search-input').value,
                category: document.getElementById('category-filter').value,
                distribution_type: document.getElementById('distribution-type-filter').value,
                program: document.getElementById('program-filter').value,
                received_status: document.getElementById('received-status-filter').value,
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
                        updateTable(response.data.distributions, response.data.pagination);
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
        function updateTable(distributions, pagination) {
            let tableHtml = '';

            if (distributions.length > 0) {
                tableHtml = `
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Kode Distribusi</th>
                                <th>Mustahik</th>
                                <th>Program</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

                distributions.forEach(function(distribution) {
                    const distributionDate = new Date(distribution.distribution_date).toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });

                    // Distribution type display names
                    const distributionTypes = {
                        'cash': 'Tunai',
                        'goods': 'Barang',
                        'voucher': 'Voucher',
                        'service': 'Layanan'
                    };

                    // Distribution type colors
                    const typeColors = {
                        'cash': 'success',
                        'goods': 'info',
                        'voucher': 'warning',
                        'service': 'primary'
                    };

                    // Category display names
                    const categoryMap = {
                        'fakir': 'Fakir',
                        'miskin': 'Miskin',
                        'amil': 'Amil',
                        'muallaf': 'Muallaf',
                        'riqab': 'Riqab',
                        'gharim': 'Gharim',
                        'fisabilillah': 'Fi Sabilillah',
                        'ibnu_sabil': 'Ibnu Sabil'
                    };

                    tableHtml += `
                    <tr>
                        <td>
                            <div class="fw-semibold">${distribution.distribution_code}</div>
                            ${distribution.location ? '<small class="text-muted">' + distribution.location + '</small>' : ''}
                        </td>
                        <td>
                            <div class="fw-semibold">${distribution.mustahik.name}</div>
                            <small class="text-muted">${categoryMap[distribution.mustahik.category] || distribution.mustahik.category}</small>
                        </td>
                        <td>
                            ${distribution.program_name ? '<span class="badge bg-info">' + distribution.program_name + '</span>' : '<span class="text-muted">-</span>'}
                        </td>
                        <td>
                            <span class="badge bg-${typeColors[distribution.distribution_type]}">${distributionTypes[distribution.distribution_type]}</span>
                        </td>
                        <td>
                            <div class="fw-bold">Rp ${parseInt(distribution.amount).toLocaleString('id-ID')}</div>
                            ${distribution.goods_description ? '<small class="text-muted">' + distribution.goods_description + '</small>' : ''}
                        </td>
                        <td>
                            ${distribution.is_received ? 
                                '<span class="badge bg-success">Sudah Diterima</span>' : 
                                '<span class="badge bg-warning">Belum Diterima</span>'
                            }
                        </td>
                        <td>${distributionDate}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="/distributions/${distribution.id}" class="btn btn-outline-info btn-sm" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="/distributions/${distribution.id}/receipt" class="btn btn-outline-success btn-sm" title="Kwitansi" target="_blank">
                                    <i class="bi bi-receipt"></i>
                                </a>
                                <a href="/distributions/${distribution.id}/edit" class="btn btn-outline-primary btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                ${!distribution.is_received ? `
                                <button type="button" class="btn btn-outline-warning btn-sm" title="Tandai Diterima" onclick="markAsReceived(${distribution.id}, '${distribution.mustahik.name}')">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                                <form action="/distributions/${distribution.id}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus distribusi ini?')">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
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
                    <h5 class="text-muted">Tidak ada data distribusi</h5>
                    <p class="text-muted">Tidak ada distribusi yang sesuai dengan kriteria pencarian</p>
                    <button type="button" id="clear-search" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-clockwise"></i> Reset Pencarian
                    </button>
                </div>
            `;
            }

            document.getElementById('distributions-table-container').innerHTML = tableHtml;
        }

        // Update statistics
        function updateStatistics(stats) {
            document.getElementById('total-amount').textContent = 'Rp ' + parseInt(stats.total_amount).toLocaleString('id-ID');
            document.getElementById('total-count').textContent = stats.total_count.toLocaleString('id-ID');
            document.getElementById('thismonth-amount').textContent = 'Rp ' + parseInt(stats.this_month).toLocaleString('id-ID');
            document.getElementById('pending-count').textContent = stats.pending_receipt.toLocaleString('id-ID');
            document.getElementById('available-balance').textContent = 'Rp ' + parseInt(stats.available_balance).toLocaleString('id-ID');

            // Update available balance color
            const balanceElement = document.getElementById('available-balance').previousElementSibling;
            if (stats.available_balance > 0) {
                balanceElement.className = balanceElement.className.replace('text-danger', 'text-success');
            } else {
                balanceElement.className = balanceElement.className.replace('text-success', 'text-danger');
            }
        }

        // Search input with debouncing
        document.getElementById('search-input').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                performSearch(1);
            }, 500); // 500ms delay
        });

        // Filter changes
        document.getElementById('category-filter').addEventListener('change', function() {
            performSearch(1);
        });

        document.getElementById('distribution-type-filter').addEventListener('change', function() {
            performSearch(1);
        });

        document.getElementById('program-filter').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                performSearch(1);
            }, 500);
        });

        document.getElementById('received-status-filter').addEventListener('change', function() {
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
            document.getElementById('category-filter').value = '';
            document.getElementById('distribution-type-filter').value = '';
            document.getElementById('program-filter').value = '';
            document.getElementById('received-status-filter').value = '';
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
                document.getElementById('category-filter').value = '';
                document.getElementById('distribution-type-filter').value = '';
                document.getElementById('program-filter').value = '';
                document.getElementById('received-status-filter').value = '';
                document.getElementById('date-from').value = '';
                document.getElementById('date-to').value = '';
                performSearch(1);
            }
        });
    });

    // Mark as received function
    function markAsReceived(distributionId, mustahikName) {
        if (confirm(`Tandai distribusi untuk ${mustahikName} sebagai sudah diterima?`)) {
            // Create a form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/distributions/${distributionId}/mark-received`;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="_method" value="PATCH">
        `;

            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush