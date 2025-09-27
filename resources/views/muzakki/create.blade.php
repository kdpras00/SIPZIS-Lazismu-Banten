@extends('layouts.app')

@section('page-title', 'Tambah Muzakki')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Tambah Muzakki Baru</h2>
        <p class="text-muted">Menambahkan data muzakki baru ke dalam sistem</p>
    </div>
    <div>
        <a href="{{ route('muzakki.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-person-plus"></i> Form Data Muzakki</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('muzakki.store') }}" method="POST" id="muzakkiForm">
                    @csrf
                    
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
                                       value="{{ old('name') }}" 
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
                                       value="{{ old('email') }}">
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
                                       value="{{ old('phone') }}"
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
                                       value="{{ old('nik') }}"
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
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
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
                                       value="{{ old('date_of_birth') }}">
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
                                      placeholder="Jalan, RT/RW, Kelurahan, Kecamatan">{{ old('address') }}</textarea>
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
                                       value="{{ old('city') }}"
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
                                       value="{{ old('province') }}"
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
                                   value="{{ old('postal_code') }}"
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
                                    <option value="employee" {{ old('occupation') == 'employee' ? 'selected' : '' }}>Karyawan</option>
                                    <option value="entrepreneur" {{ old('occupation') == 'entrepreneur' ? 'selected' : '' }}>Wiraswasta</option>
                                    <option value="civil_servant" {{ old('occupation') == 'civil_servant' ? 'selected' : '' }}>PNS</option>
                                    <option value="teacher" {{ old('occupation') == 'teacher' ? 'selected' : '' }}>Guru</option>
                                    <option value="doctor" {{ old('occupation') == 'doctor' ? 'selected' : '' }}>Dokter</option>
                                    <option value="farmer" {{ old('occupation') == 'farmer' ? 'selected' : '' }}>Petani</option>
                                    <option value="trader" {{ old('occupation') == 'trader' ? 'selected' : '' }}>Pedagang</option>
                                    <option value="other" {{ old('occupation') == 'other' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="monthly_income" class="form-label">Penghasilan Bulanan</label>
                                <input type="number" 
                                       class="form-control @error('monthly_income') is-invalid @enderror" 
                                       id="monthly_income" 
                                       name="monthly_income" 
                                       value="{{ old('monthly_income') }}"
                                       min="0"
                                       placeholder="0">
                                @error('monthly_income')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Account Section -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-key"></i> Akun Pengguna
                        </h6>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="create_user_account" 
                                       name="create_user_account" 
                                       value="1"
                                       {{ old('create_user_account') ? 'checked' : '' }}>
                                <label class="form-check-label" for="create_user_account">
                                    Buat akun pengguna untuk muzakki ini
                                    <small class="text-muted d-block">Muzakki dapat login dan mengakses sistem</small>
                                </label>
                            </div>
                        </div>
                        
                        <div id="user-account-fields" class="d-none">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                <strong>Email wajib diisi</strong> jika ingin membuat akun pengguna.
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       minlength="8">
                                <div class="form-text">Minimal 8 karakter</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('muzakki.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Simpan Muzakki
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Panduan</h6>
            </div>
            <div class="card-body">
                <h6>Informasi Wajib:</h6>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check text-success"></i> Nama Lengkap</li>
                    <li><i class="bi bi-check text-success"></i> Jenis Kelamin</li>
                </ul>
                
                <h6 class="mt-3">Tips:</h6>
                <ul class="small text-muted">
                    <li>NIK harus terdiri dari 16 digit angka</li>
                    <li>Email diperlukan jika ingin membuat akun pengguna</li>
                    <li>Nomor telepon dalam format Indonesia (08xxx)</li>
                    <li>Penghasilan bulanan untuk perhitungan zakat profesi</li>
                </ul>
                
                <div class="alert alert-warning small mt-3">
                    <i class="bi bi-exclamation-triangle"></i>
                    Pastikan data yang diinput sudah benar sebelum menyimpan.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const createUserCheckbox = document.getElementById('create_user_account');
    const userAccountFields = document.getElementById('user-account-fields');
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    const passwordConfirmField = document.getElementById('password_confirmation');
    
    // Toggle user account fields
    createUserCheckbox.addEventListener('change', function() {
        if (this.checked) {
            userAccountFields.classList.remove('d-none');
            emailField.required = true;
            passwordField.required = true;
            passwordConfirmField.required = true;
        } else {
            userAccountFields.classList.add('d-none');
            emailField.required = false;
            passwordField.required = false;
            passwordConfirmField.required = false;
        }
    });
    
    // Check on page load if checkbox was checked (for validation errors)
    if (createUserCheckbox.checked) {
        userAccountFields.classList.remove('d-none');
        emailField.required = true;
        passwordField.required = true;
        passwordConfirmField.required = true;
    }
    
    // NIK validation (numeric only, max 16 digits)
    document.getElementById('nik').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 16);
    });
    
    // Phone validation (numeric only)
    document.getElementById('phone').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    // Postal code validation (numeric only, max 5 digits)
    document.getElementById('postal_code').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 5);
    });
    
    // Format monthly income with thousands separator
    document.getElementById('monthly_income').addEventListener('input', function() {
        let value = this.value.replace(/[^0-9]/g, '');
        this.value = value;
    });
    
    // Password confirmation validation
    passwordConfirmField.addEventListener('input', function() {
        if (passwordField.value !== this.value) {
            this.setCustomValidity('Password tidak cocok');
        } else {
            this.setCustomValidity('');
        }
    });
    
    // Form submission validation
    document.getElementById('muzakkiForm').addEventListener('submit', function(e) {
        if (createUserCheckbox.checked) {
            if (!emailField.value) {
                e.preventDefault();
                alert('Email wajib diisi jika ingin membuat akun pengguna');
                emailField.focus();
                return;
            }
            
            if (passwordField.value !== passwordConfirmField.value) {
                e.preventDefault();
                alert('Konfirmasi password tidak cocok');
                passwordConfirmField.focus();
                return;
            }
        }
    });
});
</script>
@endpush