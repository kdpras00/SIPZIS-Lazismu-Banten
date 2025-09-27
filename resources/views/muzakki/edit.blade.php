@extends('layouts.app')

@section('page-title', 'Edit Muzakki - ' . $muzakki->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">{{ request()->route()->hasParameter('muzakki') ? 'Edit Muzakki' : 'Edit Profil' }}</h2>
        <p class="text-muted">{{ request()->route()->hasParameter('muzakki') ? 'Mengubah data muzakki' : 'Perbarui informasi profil Anda' }}</p>
    </div>
    <div>
        @if(request()->route()->hasParameter('muzakki'))
            <a href="{{ route('muzakki.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        @else
            <a href="{{ route('muzakki.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-pencil-square"></i> 
                    {{ request()->route()->hasParameter('muzakki') ? 'Form Edit Muzakki' : 'Form Edit Profil' }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ request()->route()->hasParameter('muzakki') ? route('muzakki.update', $muzakki) : route('muzakki.profile.update') }}" 
                      method="POST" 
                      id="muzakkiEditForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Personal Information Section -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-person-circle"></i> Informasi Personal
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $muzakki->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $muzakki->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $muzakki->phone) }}"
                                       placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" 
                                       class="form-control @error('nik') is-invalid @enderror" 
                                       id="nik" 
                                       name="nik" 
                                       value="{{ old('nik', $muzakki->nik) }}"
                                       maxlength="16"
                                       placeholder="1234567890123456">
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select @error('gender') is-invalid @enderror" 
                                        id="gender" 
                                        name="gender" 
                                        required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender', $muzakki->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender', $muzakki->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                                <input type="date" 
                                       class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       id="date_of_birth" 
                                       name="date_of_birth" 
                                       value="{{ old('date_of_birth', $muzakki->date_of_birth ? $muzakki->date_of_birth->format('Y-m-d') : '') }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Address Information Section -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-geo-alt"></i> Informasi Alamat
                        </h6>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" 
                                      name="address" 
                                      rows="3"
                                      placeholder="Jalan, RT/RW, Kelurahan, Kecamatan">{{ old('address', $muzakki->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">Kota/Kabupaten</label>
                                <input type="text" 
                                       class="form-control @error('city') is-invalid @enderror" 
                                       id="city" 
                                       name="city" 
                                       value="{{ old('city', $muzakki->city) }}"
                                       placeholder="Jakarta">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="province" class="form-label">Provinsi</label>
                                <input type="text" 
                                       class="form-control @error('province') is-invalid @enderror" 
                                       id="province" 
                                       name="province" 
                                       value="{{ old('province', $muzakki->province) }}"
                                       placeholder="DKI Jakarta">
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="postal_code" class="form-label">Kode Pos</label>
                            <input type="text" 
                                   class="form-control @error('postal_code') is-invalid @enderror" 
                                   id="postal_code" 
                                   name="postal_code" 
                                   value="{{ old('postal_code', $muzakki->postal_code) }}"
                                   maxlength="5"
                                   placeholder="12345">
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Professional Information Section -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-briefcase"></i> Informasi Pekerjaan
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="occupation" class="form-label">Pekerjaan</label>
                                <select class="form-select @error('occupation') is-invalid @enderror" 
                                        id="occupation" 
                                        name="occupation">
                                    <option value="">Pilih Pekerjaan</option>
                                    <option value="employee" {{ old('occupation', $muzakki->occupation) == 'employee' ? 'selected' : '' }}>Karyawan</option>
                                    <option value="entrepreneur" {{ old('occupation', $muzakki->occupation) == 'entrepreneur' ? 'selected' : '' }}>Wiraswasta</option>
                                    <option value="civil_servant" {{ old('occupation', $muzakki->occupation) == 'civil_servant' ? 'selected' : '' }}>PNS</option>
                                    <option value="teacher" {{ old('occupation', $muzakki->occupation) == 'teacher' ? 'selected' : '' }}>Guru</option>
                                    <option value="doctor" {{ old('occupation', $muzakki->occupation) == 'doctor' ? 'selected' : '' }}>Dokter</option>
                                    <option value="farmer" {{ old('occupation', $muzakki->occupation) == 'farmer' ? 'selected' : '' }}>Petani</option>
                                    <option value="trader" {{ old('occupation', $muzakki->occupation) == 'trader' ? 'selected' : '' }}>Pedagang</option>
                                    <option value="other" {{ old('occupation', $muzakki->occupation) == 'other' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="monthly_income" class="form-label">Pendapatan Bulanan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control @error('monthly_income') is-invalid @enderror" 
                                           id="monthly_income" 
                                           name="monthly_income" 
                                           value="{{ old('monthly_income', $muzakki->monthly_income) }}"
                                           min="0"
                                           step="1000"
                                           placeholder="5000000">
                                </div>
                                @error('monthly_income')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status Section (only for admin) -->
                    @if(request()->route()->hasParameter('muzakki') && in_array(auth()->user()->role, ['admin', 'staff']))
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-toggle-on"></i> Status Akun
                        </h6>
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input @error('is_active') is-invalid @enderror" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', $muzakki->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Status Aktif
                            </label>
                            <div class="form-text">
                                @if($muzakki->user)
                                Status akun pengguna akan ikut berubah
                                @else
                                Muzakki ini belum memiliki akun pengguna
                                @endif
                            </div>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    @endif
                    
                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-between">
                        <div>
                            @if(request()->route()->hasParameter('muzakki'))
                                <a href="{{ route('muzakki.show', $muzakki) }}" class="btn btn-outline-info">
                                    <i class="bi bi-eye"></i> Lihat Detail
                                </a>
                            @endif
                        </div>
                        <div>
                            @if(request()->route()->hasParameter('muzakki'))
                                <a href="{{ route('muzakki.index') }}" class="btn btn-outline-secondary me-2">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            @else
                                <a href="{{ route('muzakki.dashboard') }}" class="btn btn-outline-secondary me-2">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            @endif
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Side Information -->
    <div class="col-lg-4">
        <!-- Current Data Summary -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle"></i> Informasi Saat Ini
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless small">
                    <tr>
                        <td class="text-muted" width="100">Status</td>
                        <td>
                            <span class="badge bg-{{ $muzakki->is_active ? 'success' : 'danger' }}">
                                {{ $muzakki->is_active ? 'Aktif' : 'Non-aktif' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Terdaftar</td>
                        <td>{{ $muzakki->created_at->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Terakhir Diupdate</td>
                        <td>{{ $muzakki->updated_at->format('d F Y') }}</td>
                    </tr>
                    @if($muzakki->user)
                    <tr>
                        <td class="text-muted">Akun Pengguna</td>
                        <td>
                            <span class="badge bg-{{ $muzakki->user->is_active ? 'success' : 'secondary' }}">
                                {{ $muzakki->user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Payment Statistics (if has payments) -->
        @if($muzakki->zakatPayments()->completed()->count() > 0)
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">
                    <i class="bi bi-wallet2"></i> Statistik Zakat
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <h4 class="text-success mb-0">Rp {{ number_format($muzakki->zakatPayments()->completed()->sum('paid_amount'), 0, ',', '.') }}</h4>
                    <small class="text-muted">Total Zakat</small>
                </div>
                <hr>
                <table class="table table-borderless small">
                    <tr>
                        <td class="text-muted">Total Transaksi</td>
                        <td class="text-end">{{ $muzakki->zakatPayments()->completed()->count() }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Pembayaran Terakhir</td>
                        <td class="text-end">
                            @php
                                $lastPayment = $muzakki->zakatPayments()->completed()->latest('payment_date')->first();
                            @endphp
                            {{ $lastPayment ? $lastPayment->payment_date->format('d M Y') : '-' }}
                        </td>
                    </tr>
                </table>
                <div class="alert alert-warning small mb-0">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Berhati-hati saat mengubah data muzakki yang sudah memiliki riwayat pembayaran.
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('muzakkiEditForm');
    
    form.addEventListener('submit', function(e) {
        // Basic validation
        const name = document.getElementById('name').value.trim();
        const gender = document.getElementById('gender').value;
        
        if (!name) {
            e.preventDefault();
            alert('Nama lengkap harus diisi');
            document.getElementById('name').focus();
            return;
        }
        
        if (!gender) {
            e.preventDefault();
            alert('Jenis kelamin harus dipilih');
            document.getElementById('gender').focus();
            return;
        }
    });
    
    // NIK formatting
    const nikInput = document.getElementById('nik');
    nikInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length > 16) {
            this.value = this.value.slice(0, 16);
        }
    });
    
    // Phone formatting
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });
    
    // Postal code formatting
    const postalInput = document.getElementById('postal_code');
    postalInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length > 5) {
            this.value = this.value.slice(0, 5);
        }
    });
    
    // Income formatting
    const incomeInput = document.getElementById('monthly_income');
    incomeInput.addEventListener('input', function() {
        // Remove any non-digit characters except decimal point
        this.value = this.value.replace(/[^\d]/g, '');
    });
});
</script>
@endpush