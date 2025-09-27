@extends('layouts.app')

@section('page-title', 'Manajemen Muzakki')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Manajemen Muzakki</h2>
        <p class="text-muted">Kelola data muzakki yang terdaftar dalam sistem</p>
    </div>
    <div>
        <a href="{{ route('muzakki.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Muzakki
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <input type="text" id="search-input" class="form-control" placeholder="Cari nama, email, NIK..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select id="occupation-filter" class="form-select">
                    <option value="">Semua Pekerjaan</option>
                    @foreach($occupations as $occupation)
                    <option value="{{ $occupation }}" {{ request('occupation') == $occupation ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_', ' ', $occupation)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" id="city-filter" class="form-control" placeholder="Kota" value="{{ request('city') }}">
            </div>
            <div class="col-md-2">
                <select id="status-filter" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-3">
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
                <i class="bi bi-people display-4 text-primary mb-2"></i>
                <h4 class="mb-0" id="total-count">{{ $muzakki->total() }}</h4>
                <small class="text-muted">Total Muzakki</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-person-check display-4 text-success mb-2"></i>
                <h4 class="mb-0" id="active-count">{{ $muzakki->where('is_active', true)->count() }}</h4>
                <small class="text-muted">Muzakki Aktif</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-person-dash display-4 text-warning mb-2"></i>
                <h4 class="mb-0" id="inactive-count">{{ $muzakki->where('is_active', false)->count() }}</h4>
                <small class="text-muted">Muzakki Tidak Aktif</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-person-plus display-4 text-info mb-2"></i>
                <h4 class="mb-0" id="thismonth-count">{{ $muzakki->where('created_at', '>=', now()->startOfMonth())->count() }}</h4>
                <small class="text-muted">Baru Bulan Ini</small>
            </div>
        </div>
    </div>
</div>

<!-- Muzakki Table -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Daftar Muzakki</h5>
    </div>
    <div class="card-body p-0" id="muzakki-table-container">
        @include('muzakki.partials.table')
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let searchTimeout;
    let currentPage = 1;

    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Debounced search function
    function performSearch(page = 1) {
        const searchData = {
            search: document.getElementById('search-input').value,
            occupation: document.getElementById('occupation-filter').value,
            city: document.getElementById('city-filter').value,
            status: document.getElementById('status-filter').value,
            page: page
        };

        // Show loading indicator
        document.getElementById('search-loading').classList.remove('d-none');
        
        // Create query string
        const params = new URLSearchParams(searchData);
        
        fetch('{{ route('api.muzakki.search') }}?' + params.toString(), {
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
                updateTable(response.data.muzakki, response.data.pagination);
                // Update statistics
                updateStatistics(response.data.statistics);
                // Update current page
                currentPage = response.data.pagination.current_page;
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            // You can add user-friendly error handling here
        })
        .finally(() => {
            // Hide loading indicator
            document.getElementById('search-loading').classList.add('d-none');
        });
    }

    // Update table with new data
    function updateTable(muzakki, pagination) {
        let tableHtml = '';
        
        if (muzakki.length > 0) {
            tableHtml = `
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Kota</th>
                                <th>Pekerjaan</th>
                                <th>Status</th>
                                <th>Terdaftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            muzakki.forEach(function(item) {
                const createdAt = new Date(item.created_at).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
                
                tableHtml += `
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                    <i class="bi bi-person text-primary"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">${item.name}</div>
                                    ${item.nik ? '<small class="text-muted">NIK: ' + item.nik + '</small>' : ''}
                                </div>
                            </div>
                        </td>
                        <td>
                            ${item.email ? 
                                '<span>' + item.email + '</span>' + (item.user ? '<span class="badge bg-success ms-1">User</span>' : '') : 
                                '<span class="text-muted">-</span>'
                            }
                        </td>
                        <td>${item.phone || '-'}</td>
                        <td>${item.city || '-'}</td>
                        <td>
                            ${item.occupation ? 
                                '<span class="badge bg-info">' + item.occupation.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) + '</span>' : 
                                '<span class="text-muted">-</span>'
                            }
                        </td>
                        <td>
                            <span class="badge ${item.is_active ? 'bg-success' : 'bg-secondary'}">
                                ${item.is_active ? 'Aktif' : 'Tidak Aktif'}
                            </span>
                        </td>
                        <td>${createdAt}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="/muzakki/${item.id}" class="btn btn-outline-info btn-sm" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="/muzakki/${item.id}/edit" class="btn btn-outline-primary btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="/muzakki/${item.id}/toggle-status" method="POST" class="d-inline">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="PATCH">
                                    <button type="submit" class="btn btn-outline-warning btn-sm" title="Toggle Status">
                                        <i class="bi bi-toggle-${item.is_active ? 'on' : 'off'}"></i>
                                    </button>
                                </form>
                                <form action="/muzakki/${item.id}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
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
                    <h5 class="text-muted">Tidak ada data muzakki</h5>
                    <p class="text-muted">Tidak ada muzakki yang sesuai dengan kriteria pencarian</p>
                    <button type="button" id="clear-search" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-clockwise"></i> Reset Pencarian
                    </button>
                </div>
            `;
        }
        
        document.getElementById('muzakki-table-container').innerHTML = tableHtml;
    }

    // Update statistics
    function updateStatistics(stats) {
        document.getElementById('total-count').textContent = stats.total.toLocaleString();
        document.getElementById('active-count').textContent = stats.active.toLocaleString();
        document.getElementById('inactive-count').textContent = stats.inactive.toLocaleString();
        document.getElementById('thismonth-count').textContent = stats.this_month.toLocaleString();
    }

    // Search input with debouncing
    document.getElementById('search-input').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            performSearch(1);
        }, 500); // 500ms delay
    });

    // Filter changes
    document.getElementById('occupation-filter').addEventListener('change', function() {
        performSearch(1);
    });

    document.getElementById('status-filter').addEventListener('change', function() {
        performSearch(1);
    });

    document.getElementById('city-filter').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            performSearch(1);
        }, 500);
    });

    // Reset filters
    document.getElementById('reset-filters').addEventListener('click', function() {
        document.getElementById('search-input').value = '';
        document.getElementById('occupation-filter').value = '';
        document.getElementById('city-filter').value = '';
        document.getElementById('status-filter').value = '';
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
            document.getElementById('occupation-filter').value = '';
            document.getElementById('city-filter').value = '';
            document.getElementById('status-filter').value = '';
            performSearch(1);
        }
    });
});
</script>
@endpush
