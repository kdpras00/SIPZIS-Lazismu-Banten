@extends('layouts.app')

@section('page-title', 'Edit Distribusi - ' . $distribution->distribution_code)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Edit Distribusi Zakat</h2>
        <p class="text-muted">{{ $distribution->distribution_code }} - {{ $distribution->mustahik->name }}</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('distributions.show', $distribution) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('distributions.index') }}" class="btn btn-outline-info">
            <i class="bi bi-list"></i> Daftar Distribusi
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Form Distribusi</h5>
                    @if($distribution->is_received)
                        <span class="badge bg-success fs-6">Sudah Diterima</span>
                    @else
                        <span class="badge bg-warning fs-6">Belum Diterima</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if($distribution->is_received)
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Perhatian:</strong> Distribusi ini sudah ditandai sebagai diterima pada {{ $distribution->received_date?->format('d F Y H:i') }}. 
                    Perubahan data harus dilakukan dengan hati-hati.
                </div>
                @endif
                
                <form action="{{ route('distributions.update', $distribution) }}" method="POST" id="distributionEditForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Mustahik Selection Section -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-person-heart"></i> Informasi Mustahik
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="mustahik_id" class="form-label">Pilih Mustahik <span class="text-danger">*</span></label>
                                <select class="form-select @error('mustahik_id') is-invalid @enderror" 
                                        id="mustahik_id" 
                                        name="mustahik_id" 
                                        required>
                                    <option value="">Pilih Mustahik</option>
                                    @foreach($allMustahik as $m)
                                    <option value="{{ $m->id }}" 
                                            data-category="{{ $m->category }}"
                                            data-address="{{ $m->address }}"
                                            data-phone="{{ $m->phone }}"
                                            {{ old('mustahik_id', $distribution->mustahik_id) == $m->id ? 'selected' : '' }}>
                                        {{ $m->name }} - {{ ucfirst(str_replace('_', ' ', $m->category)) }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('mustahik_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="category_filter" class="form-label">Filter Kategori</label>
                                <select class="form-select" id="category_filter">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category }}">{{ ucfirst(str_replace('_', ' ', $category)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- Mustahik Details Display -->
                        <div id="mustahik-details" class="d-none">
                            <div class="alert alert-info">
                                <h6 class="mb-2"><i class="bi bi-info-circle"></i> Detail Mustahik</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">Kategori:</small>
                                        <div id="mustahik-category" class="fw-semibold"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Telepon:</small>
                                        <div id="mustahik-phone" class="fw-semibold"></div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <small class="text-muted">Alamat:</small>
                                        <div id="mustahik-address" class="fw-semibold"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Distribution Details Section -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-gift"></i> Detail Distribusi
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="distribution_type" class="form-label">Jenis Distribusi <span class="text-danger">*</span></label>
                                <select class="form-select @error('distribution_type') is-invalid @enderror" 
                                        id="distribution_type" 
                                        name="distribution_type" 
                                        required>
                                    <option value="">Pilih Jenis Distribusi</option>
                                    <option value="cash" {{ old('distribution_type', $distribution->distribution_type) == 'cash' ? 'selected' : '' }}>Tunai</option>
                                    <option value="goods" {{ old('distribution_type', $distribution->distribution_type) == 'goods' ? 'selected' : '' }}>Barang</option>
                                    <option value="voucher" {{ old('distribution_type', $distribution->distribution_type) == 'voucher' ? 'selected' : '' }}>Voucher</option>
                                    <option value="service" {{ old('distribution_type', $distribution->distribution_type) == 'service' ? 'selected' : '' }}>Layanan</option>
                                </select>
                                @error('distribution_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="amount" class="form-label">Jumlah <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control @error('amount') is-invalid @enderror" 
                                           id="amount" 
                                           name="amount" 
                                           value="{{ old('amount', $distribution->amount) }}" 
                                           min="0"
                                           step="1000"
                                           required>
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="amount-warning" class="d-none">
                                    <small class="text-danger">
                                        <i class="bi bi-exclamation-triangle"></i>
                                        Jumlah melebihi saldo tersedia!
                                    </small>
                                </div>
                                <div id="amount-change-warning" class="d-none">
                                    <small class="text-info">
                                        <i class="bi bi-info-circle"></i>
                                        Jumlah asli: Rp {{ number_format($distribution->amount, 0, ',', '.') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Goods Description (conditional) -->
                        <div class="mb-3 {{ in_array($distribution->distribution_type, ['goods', 'service']) ? '' : 'd-none' }}" id="goods-description-field">
                            <label for="goods_description" class="form-label">Deskripsi Barang/Layanan</label>
                            <textarea class="form-control @error('goods_description') is-invalid @enderror" 
                                      id="goods_description" 
                                      name="goods_description" 
                                      rows="3"
                                      placeholder="Contoh: Beras 10kg, Minyak goreng 2L, dll.">{{ old('goods_description', $distribution->goods_description) }}</textarea>
                            @error('goods_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="distribution_date" class="form-label">Tanggal Distribusi <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('distribution_date') is-invalid @enderror" 
                                       id="distribution_date" 
                                       name="distribution_date" 
                                       value="{{ old('distribution_date', $distribution->distribution_date->format('Y-m-d')) }}"
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('distribution_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Lokasi Distribusi</label>
                                <input type="text" 
                                       class="form-control @error('location') is-invalid @enderror" 
                                       id="location" 
                                       name="location" 
                                       value="{{ old('location', $distribution->location) }}"
                                       placeholder="Contoh: Masjid Al-Ikhlas, Kantor Amil, dll.">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Program Information Section -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-bookmark"></i> Program & Catatan
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="program_name" class="form-label">Nama Program</label>
                                <input type="text" 
                                       class="form-control @error('program_name') is-invalid @enderror" 
                                       id="program_name" 
                                       name="program_name" 
                                       value="{{ old('program_name', $distribution->program_name) }}"
                                       placeholder="Contoh: Bantuan Ramadan, Program Pendidikan, dll.">
                                @error('program_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" 
                                      name="notes" 
                                      rows="3"
                                      placeholder="Catatan tambahan mengenai distribusi ini...">{{ old('notes', $distribution->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Receipt Status Section (if already received) -->
                    @if($distribution->is_received)
                    <div class="mb-4">
                        <h6 class="text-success mb-3">
                            <i class="bi bi-check-circle"></i> Status Penerimaan
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="received_by_name" class="form-label">Diterima Oleh</label>
                                <input type="text" 
                                       class="form-control @error('received_by_name') is-invalid @enderror" 
                                       id="received_by_name" 
                                       name="received_by_name" 
                                       value="{{ old('received_by_name', $distribution->received_by_name) }}"
                                       placeholder="Nama penerima">
                                @error('received_by_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="received_date" class="form-label">Tanggal Diterima</label>
                                <input type="datetime-local" 
                                       class="form-control @error('received_date') is-invalid @enderror" 
                                       id="received_date" 
                                       name="received_date" 
                                       value="{{ old('received_date', $distribution->received_date?->format('Y-m-d\TH:i')) }}"
                                       max="{{ date('Y-m-d\TH:i') }}">
                                @error('received_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="received_notes" class="form-label">Catatan Penerimaan</label>
                            <textarea class="form-control @error('received_notes') is-invalid @enderror" 
                                      id="received_notes" 
                                      name="received_notes" 
                                      rows="3"
                                      placeholder="Catatan penerimaan distribusi...">{{ old('received_notes', $distribution->received_notes) }}</textarea>
                            @error('received_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="mark_as_not_received" name="mark_as_not_received" value="1">
                            <label class="form-check-label text-warning" for="mark_as_not_received">
                                <i class="bi bi-exclamation-triangle"></i> Batalkan status diterima (tandai sebagai belum diterima)
                            </label>
                        </div>
                    </div>
                    @endif
                    
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('distributions.show', $distribution) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Batal
                            </a>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Simpan Perubahan
                            </button>
                            <button type="submit" name="save_and_continue" value="1" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Simpan & Lihat
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Available Balance Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-{{ $availableBalance > 0 ? 'success' : 'danger' }} text-white">
                <h6 class="mb-0"><i class="bi bi-wallet2"></i> Saldo Tersedia</h6>
            </div>
            <div class="card-body text-center">
                <h3 class="text-{{ $availableBalance > 0 ? 'success' : 'danger' }}" id="available-balance">
                    Rp {{ number_format($availableBalance, 0, ',', '.') }}
                </h3>
                <small class="text-muted">
                    {{ $availableBalance > 0 ? 'Dapat didistribusikan' : 'Saldo tidak mencukupi' }}
                </small>
                <hr>
                <div class="text-start">
                    <small class="text-muted">
                        <strong>Catatan:</strong> Saldo dihitung dari total pembayaran dikurangi distribusi yang sudah ada. 
                        Jumlah distribusi saat ini (Rp {{ number_format($distribution->amount, 0, ',', '.') }}) sudah dikurangi dari perhitungan.
                    </small>
                </div>
            </div>
        </div>
        
        <!-- Original Data Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-archive"></i> Data Asli</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="text-muted">Kode:</td>
                        <td class="fw-semibold">{{ $distribution->distribution_code }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Mustahik:</td>
                        <td class="fw-semibold">{{ $distribution->mustahik->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jenis:</td>
                        <td>
                            @switch($distribution->distribution_type)
                                @case('cash')
                                    <span class="badge bg-success">Tunai</span>
                                    @break
                                @case('goods')
                                    <span class="badge bg-info">Barang</span>
                                    @break
                                @case('voucher')
                                    <span class="badge bg-warning">Voucher</span>
                                    @break
                                @case('service')
                                    <span class="badge bg-primary">Layanan</span>
                                    @break
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jumlah:</td>
                        <td class="fw-bold">Rp {{ number_format($distribution->amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal:</td>
                        <td class="fw-semibold">{{ $distribution->distribution_date->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Dicatat:</td>
                        <td class="fw-semibold">{{ $distribution->created_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Guidelines Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Perhatian</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled small">
                    <li><i class="bi bi-check-circle text-success"></i> Pastikan data yang diubah sudah benar</li>
                    <li><i class="bi bi-check-circle text-success"></i> Perubahan jumlah akan mempengaruhi saldo</li>
                    <li><i class="bi bi-check-circle text-success"></i> Jika distribusi sudah diterima, berhati-hatilah mengubah data</li>
                    <li><i class="bi bi-check-circle text-success"></i> Backup data penting sebelum perubahan besar</li>
                </ul>
                
                @if($distribution->is_received)
                <div class="alert alert-info small mt-3">
                    <i class="bi bi-info-circle"></i>
                    Distribusi ini sudah diterima. Pastikan mustahik mengetahui perubahan yang dilakukan.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mustahikSelect = document.getElementById('mustahik_id');
    const categoryFilter = document.getElementById('category_filter');
    const distributionType = document.getElementById('distribution_type');
    const amountInput = document.getElementById('amount');
    const goodsDescriptionField = document.getElementById('goods-description-field');
    const mustahikDetails = document.getElementById('mustahik-details');
    const amountWarning = document.getElementById('amount-warning');
    const amountChangeWarning = document.getElementById('amount-change-warning');
    const originalAmount = {{ $distribution->amount }};
    const availableBalance = {{ $availableBalance }};
    
    // Store original options for filtering
    const originalOptions = Array.from(mustahikSelect.options).slice(1); // Exclude empty option
    
    // Initialize mustahik details on load
    if (mustahikSelect.value) {
        mustahikSelect.dispatchEvent(new Event('change'));
    }
    
    // Mustahik selection handler
    mustahikSelect.addEventListener('change', function() {
        if (this.value) {
            const selectedOption = this.options[this.selectedIndex];
            const category = selectedOption.dataset.category;
            const address = selectedOption.dataset.address || '-';
            const phone = selectedOption.dataset.phone || '-';
            
            // Show mustahik details
            document.getElementById('mustahik-category').textContent = category.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
            document.getElementById('mustahik-address').textContent = address;
            document.getElementById('mustahik-phone').textContent = phone;
            mustahikDetails.classList.remove('d-none');
        } else {
            mustahikDetails.classList.add('d-none');
        }
    });
    
    // Category filter handler
    categoryFilter.addEventListener('change', function() {
        const selectedCategory = this.value;
        const currentValue = mustahikSelect.value;
        
        // Clear current options (except empty option)
        mustahikSelect.innerHTML = '<option value="">Pilih Mustahik</option>';
        
        // Filter and add options
        originalOptions.forEach(option => {
            if (!selectedCategory || option.dataset.category === selectedCategory) {
                mustahikSelect.appendChild(option.cloneNode(true));
            }
        });
        
        // Restore selection if still valid
        if (currentValue) {
            mustahikSelect.value = currentValue;
            if (mustahikSelect.value) {
                mustahikSelect.dispatchEvent(new Event('change'));
            }
        }
    });
    
    // Distribution type handler
    distributionType.addEventListener('change', function() {
        const goodsDescField = document.getElementById('goods_description');
        
        if (this.value === 'goods' || this.value === 'service') {
            goodsDescriptionField.classList.remove('d-none');
            goodsDescField.setAttribute('required', 'required');
        } else {
            goodsDescriptionField.classList.add('d-none');
            goodsDescField.removeAttribute('required');
        }
        
        validateAmount();
    });
    
    // Amount validation
    function validateAmount() {
        const amount = parseFloat(amountInput.value) || 0;
        const isCash = distributionType.value === 'cash';
        const adjustedBalance = availableBalance + originalAmount; // Add back original amount for comparison
        
        // Show amount change warning if different from original
        if (amount !== originalAmount) {
            amountChangeWarning.classList.remove('d-none');
        } else {
            amountChangeWarning.classList.add('d-none');
        }
        
        // Validate cash amount against available balance
        if (isCash && amount > adjustedBalance) {
            amountWarning.classList.remove('d-none');
            amountInput.classList.add('is-invalid');
        } else {
            amountWarning.classList.add('d-none');
            amountInput.classList.remove('is-invalid');
        }
    }
    
    amountInput.addEventListener('input', validateAmount);
    distributionType.addEventListener('change', validateAmount);
    
    // Format amount input
    amountInput.addEventListener('blur', function() {
        if (this.value) {
            const value = parseInt(this.value.replace(/[^0-9]/g, ''));
            if (!isNaN(value)) {
                this.value = value;
            }
        }
    });
    
    // Form submission validation
    document.getElementById('distributionEditForm').addEventListener('submit', function(e) {
        const amount = parseFloat(amountInput.value) || 0;
        const isCash = distributionType.value === 'cash';
        const adjustedBalance = availableBalance + originalAmount;
        
        if (isCash && amount > adjustedBalance) {
            e.preventDefault();
            alert('Jumlah distribusi tunai melebihi saldo tersedia!');
            amountInput.focus();
            return;
        }
        
        if ((distributionType.value === 'goods' || distributionType.value === 'service') && !document.getElementById('goods_description').value) {
            e.preventDefault();
            alert('Deskripsi barang/layanan wajib diisi!');
            document.getElementById('goods_description').focus();
            return;
        }
        
        // Confirm if significant changes are made
        const significantChanges = [];
        if (amount !== originalAmount) {
            significantChanges.push('Jumlah distribusi');
        }
        if (mustahikSelect.value != {{ $distribution->mustahik_id }}) {
            significantChanges.push('Penerima (Mustahik)');
        }
        if (distributionType.value !== '{{ $distribution->distribution_type }}') {
            significantChanges.push('Jenis distribusi');
        }
        
        if (significantChanges.length > 0) {
            const changes = significantChanges.join(', ');
            if (!confirm(`Anda akan mengubah: ${changes}. Lanjutkan?`)) {
                e.preventDefault();
                return;
            }
        }
    });
    
    // Initialize form state
    validateAmount();
});
</script>
@endpush