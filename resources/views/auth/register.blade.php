@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus display-4 text-primary"></i>
                        <h2 class="mt-3 mb-0">Daftar Muzakki</h2>
                        <p class="text-muted">Bergabung dengan Sistem Zakat</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required>
                                @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">No. Telepon</label>
                                <input id="phone" type="text"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nik" class="form-label">NIK/KTP</label>
                                <input id="nik" type="text"
                                    class="form-control @error('nik') is-invalid @enderror"
                                    name="nik" value="{{ old('nik') }}" required>
                                @error('nik')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select id="gender" class="form-select @error('gender') is-invalid @enderror" name="gender" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="occupation" class="form-label">Pekerjaan</label>
                                <select id="occupation" class="form-select @error('occupation') is-invalid @enderror" name="occupation" required>
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
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea id="address" class="form-control @error('address') is-invalid @enderror"
                                name="address" rows="2" required>{{ old('address') }}</textarea>
                            @error('address')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">Kota</label>
                                <input id="city" type="text"
                                    class="form-control @error('city') is-invalid @enderror"
                                    name="city" value="{{ old('city') }}" required>
                                @error('city')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="province" class="form-label">Provinsi</label>
                                <input id="province" type="text"
                                    class="form-control @error('province') is-invalid @enderror"
                                    name="province" value="{{ old('province') }}" required>
                                @error('province')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="monthly_income" class="form-label">Penghasilan Bulanan (Opsional)</label>
                                <input id="monthly_income" type="text"
                                    class="form-control currency-input @error('monthly_income') is-invalid @enderror"
                                    name="monthly_income" value="{{ old('monthly_income') }}">
                                @error('monthly_income')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Tanggal Lahir (Opsional)</label>
                                <input id="date_of_birth" type="date"
                                    class="form-control @error('date_of_birth') is-invalid @enderror"
                                    name="date_of_birth" value="{{ old('date_of_birth') }}">
                                @error('date_of_birth')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" required>
                                @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input id="password_confirmation" type="password"
                                    class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-person-plus"></i> Daftar
                            </button>
                        </div>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="mb-0">Sudah punya akun?</p>
                            <a class="btn btn-outline-primary" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection