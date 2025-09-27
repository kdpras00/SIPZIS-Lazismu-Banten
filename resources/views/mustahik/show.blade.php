@extends('layouts.app')

@section('page-title', 'Detail Mustahik - ' . $mustahik->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Detail Mustahik</h2>
        <p class="text-muted">{{ $mustahik->name }}</p>
    </div>
    <div>
        <a href="{{ route('mustahik.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Personal Information Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-person-circle"></i> Informasi Personal</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Nama Lengkap</label>
                        <div class="fw-semibold">{{ $mustahik->name }}</div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">NIK</label>
                        <div class="fw-semibold">{{ $mustahik->nik ?: '-' }}</div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Jenis Kelamin</label>
                        <div class="fw-semibold">
                            @if($mustahik->gender == 'male')
                                <i class="bi bi-gender-male text-primary"></i> Laki-laki
                            @elseif($mustahik->gender == 'female')
                                <i class="bi bi-gender-female text-danger"></i> Perempuan
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Tanggal Lahir</label>
                        <div class="fw-semibold">
                            @if($mustahik->date_of_birth)
                                {{ $mustahik->date_of_birth->format('d M Y') }}
                                @if($mustahik->age)
                                    <span class="badge bg-secondary ms-2">{{ $mustahik->age }} tahun</span>
                                @endif
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Nomor Telepon</label>
                        <div class="fw-semibold">{{ $mustahik->phone ?: '-' }}</div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Status Verifikasi</label>
                        <div class="fw-semibold">
                            @switch($mustahik->verification_status)
                                @case('pending')
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                    @break
                                @case('verified')
                                    <span class="badge bg-success">Terverifikasi</span>
                                    @break
                                @case('rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $mustahik->verification_status }}</span>
                            @endswitch
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Status Aktif</label>
                        <div class="fw-semibold">
                            @if($mustahik->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Address Information Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-geo-alt"></i> Informasi Alamat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="text-muted small mb-1">Alamat Lengkap</label>
                        <div class="fw-semibold">{{ $mustahik->address ?: '-' }}</div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Kota/Kabupaten</label>
                        <div class="fw-semibold">{{ $mustahik->city ?: '-' }}</div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Provinsi</label>
                        <div class="fw-semibold">{{ $mustahik->province ?: '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Category Information Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-tags"></i> Kategori Mustahik (Asnaf)</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Kategori</label>
                        <div class="fw-semibold">
                            <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $mustahik->category)) }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Jumlah Anggota Keluarga</label>
                        <div class="fw-semibold">{{ $mustahik->family_members }} orang</div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Status Keluarga</label>
                        <div class="fw-semibold">
                            @switch($mustahik->family_status)
                                @case('single')
                                    Lajang
                                    @break
                                @case('married')
                                    Menikah
                                    @break
                                @case('divorced')
                                    Cerai
                                    @break
                                @case('widow/widower')
                                    Janda/Duda
                                    @break
                                @default
                                    -
                            @endswitch
                        </div>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="text-muted small mb-1">Deskripsi Kondisi</label>
                        <div class="fw-semibold">{{ $mustahik->category_description ?: '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Economic Information Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-currency-dollar"></i> Informasi Ekonomi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Penghasilan Bulanan</label>
                        <div class="fw-semibold">Rp {{ number_format($mustahik->monthly_income ?? 0, 0, ',', '.') }}</div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Sumber Penghasilan</label>
                        <div class="fw-semibold">{{ $mustahik->income_source ?: '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Verification Information Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-shield-check"></i> Informasi Verifikasi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Tanggal Verifikasi</label>
                        <div class="fw-semibold">
                            @if($mustahik->verified_at)
                                {{ $mustahik->verified_at->format('d M Y H:i') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Diverifikasi Oleh</label>
                        <div class="fw-semibold">
                            @if($mustahik->verifiedBy)
                                {{ $mustahik->verifiedBy->name }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="text-muted small mb-1">Catatan Verifikasi</label>
                        <div class="fw-semibold">{{ $mustahik->verification_notes ?: '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Statistics Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="bi bi-bar-chart"></i> Statistik Penerimaan Zakat</h6>
            </div>
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="bi bi-cash-coin text-primary" style="font-size: 3rem;"></i>
                </div>
                
                <div class="mb-3">
                    <h3 class="display-6 fw-bold text-primary">{{ $stats['distribution_count'] }}</h3>
                    <p class="text-muted">Total Distribusi</p>
                </div>
                
                <div class="mb-3">
                    <h3 class="display-6 fw-bold text-success">Rp {{ number_format($stats['total_received'], 0, ',', '.') }}</h3>
                    <p class="text-muted">Total Zakat Diterima</p>
                </div>
                
                <div class="mb-3">
                    <p class="text-muted mb-1">Terakhir Menerima</p>
                    <p class="fw-semibold">
                        @if($stats['last_distribution'])
                            {{ $stats['last_distribution']->distribution_date->format('d M Y') }}
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Recent Distributions Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="bi bi-list-check"></i> Distribusi Terbaru</h6>
            </div>
            <div class="card-body">
                @if($recentDistributions->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentDistributions as $distribution)
                        <div class="list-group-item px-0 py-2 border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">Rp {{ number_format($distribution->amount, 0, ',', '.') }}</div>
                                    <small class="text-muted">{{ $distribution->distribution_date->format('d M Y') }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="small">{{ $distribution->distributedBy->name ?? 'System' }}</div>
                                    @if($distribution->is_received)
                                        <span class="badge bg-success">Diterima</span>
                                    @else
                                        <span class="badge bg-warning">Belum Diterima</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2 mb-0">Belum ada distribusi</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Action Buttons Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="bi bi-lightning"></i> Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('mustahik.edit', $mustahik) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit Data
                    </a>
                    
                    @if($mustahik->verification_status === 'pending')
                    <button type="button" class="btn btn-success" onclick="showVerifyModal('verified')">
                        <i class="bi bi-check-circle"></i> Verifikasi
                    </button>
                    <button type="button" class="btn btn-danger" onclick="showVerifyModal('rejected')">
                        <i class="bi bi-x-circle"></i> Tolak
                    </button>
                    @endif
                    
                    <form action="{{ route('mustahik.toggle-status', $mustahik) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn {{ $mustahik->is_active ? 'btn-warning' : 'btn-success' }} w-100">
                            <i class="bi bi-toggle-{{ $mustahik->is_active ? 'on' : 'off' }}"></i>
                            {{ $mustahik->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Verification Modal -->
<div class="modal fade" id="verifyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('mustahik.verify', $mustahik) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" id="verifyStatus">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalLabel">Verifikasi Mustahik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="verification_notes" class="form-label">Catatan Verifikasi</label>
                        <textarea class="form-control" id="verification_notes" name="notes" rows="3" placeholder="Tambahkan catatan verifikasi..."></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showVerifyModal(status) {
    const modal = new bootstrap.Modal(document.getElementById('verifyModal'));
    const statusInput = document.getElementById('verifyStatus');
    const modalTitle = document.getElementById('verifyModalLabel');
    
    if (status === 'verified') {
        statusInput.value = 'verified';
        modalTitle.textContent = 'Verifikasi Mustahik';
    } else {
        statusInput.value = 'rejected';
        modalTitle.textContent = 'Tolak Mustahik';
    }
    
    modal.show();
}
</script>
@endpush