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

                        <!-- Country Dropdown -->
                        <div class="mb-3">
                            <label for="country" class="form-label">Negara <span class="text-danger">*</span></label>
                            <select class="form-select @error('country') is-invalid @enderror"
                                id="country"
                                name="country"
                                required>
                                <option value="">Pilih Negara</option>
                                <!-- Will be populated dynamically -->
                            </select>
                            @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Province Dropdown -->
                        <div class="mb-3" id="province-container" style="display: none;">
                            <label for="province" class="form-label">Provinsi <span class="text-danger">*</span></label>
                            <select class="form-select @error('province') is-invalid @enderror"
                                id="province"
                                name="province">
                                <option value="">Pilih Provinsi</option>
                            </select>
                            @error('province')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- City Dropdown -->
                        <div class="mb-3" id="city-container" style="display: none;">
                            <label for="city" class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                            <select class="form-select @error('city') is-invalid @enderror"
                                id="city"
                                name="city">
                                <option value="">Pilih Kota/Kabupaten</option>
                            </select>
                            @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- District Dropdown -->
                        <div class="mb-3" id="district-container" style="display: none;">
                            <label for="district" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                            <select class="form-select @error('district') is-invalid @enderror"
                                id="district"
                                name="district">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                            @error('district')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Village Dropdown -->
                        <div class="mb-3" id="village-container" style="display: none;">
                            <label for="village" class="form-label">Kelurahan <span class="text-danger">*</span></label>
                            <select class="form-select @error('village') is-invalid @enderror"
                                id="village"
                                name="village">
                                <option value="">Pilih Kelurahan</option>
                            </select>
                            @error('village')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Postal Code -->
                        <div class="mb-3" id="postal-code-container" style="display: none;">
                            <label for="postal_code" class="form-label">Kode Pos <span class="text-danger">*</span></label>
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
                                    <option value="programmer" {{ old('occupation') == 'programmer' ? 'selected' : '' }}>Programmer</option>
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
                    <li><i class="bi bi-check text-success"></i> Negara</li>
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

        // Region dropdown elements
        const countrySelect = document.getElementById('country');
        const provinceContainer = document.getElementById('province-container');
        const cityContainer = document.getElementById('city-container');
        const districtContainer = document.getElementById('district-container');
        const villageContainer = document.getElementById('village-container');
        const postalCodeContainer = document.getElementById('postal-code-container');
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const districtSelect = document.getElementById('district');
        const villageSelect = document.getElementById('village');
        const postalCodeInput = document.getElementById('postal_code');
        const form = document.getElementById('muzakkiForm');

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

        // Region dropdown functions
        function resetDropdown(select, placeholder) {
            select.innerHTML = `<option value="">${placeholder}</option>`;
        }

        function fetchCountries() {
            fetch('/regions/countries')
                .then(res => res.json())
                .then(data => {
                    resetDropdown(countrySelect, 'Pilih Negara');
                    data.forEach(country => {
                        const option = document.createElement('option');
                        option.value = country.name;
                        option.textContent = country.name;
                        countrySelect.appendChild(option);
                    });
                })
                .catch(err => console.error('Gagal memuat negara:', err));
        }

        function fetchProvinces() {
            fetch('/regions/provinces/indonesia')
                .then(res => res.json())
                .then(data => {
                    resetDropdown(provinceSelect, 'Pilih Provinsi');
                    data.forEach(prov => {
                        const option = document.createElement('option');
                        option.value = prov.id;
                        option.textContent = prov.name;
                        provinceSelect.appendChild(option);
                    });
                })
                .catch(err => console.error('Gagal memuat provinsi:', err));
        }

        function fetchCities(provinceId) {
            if (!provinceId) return;

            fetch(`/regions/cities/${provinceId}`)
                .then(res => res.json())
                .then(data => {
                    resetDropdown(citySelect, 'Pilih Kota/Kabupaten');
                    data.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                })
                .catch(err => console.error('Gagal memuat kota:', err));
        }

        function fetchDistricts(cityId) {
            if (!cityId) return;

            fetch(`/regions/districts/${cityId}`)
                .then(res => res.json())
                .then(data => {
                    resetDropdown(districtSelect, 'Pilih Kecamatan');
                    data.forEach(dist => {
                        const option = document.createElement('option');
                        option.value = dist.id;
                        option.textContent = dist.name;
                        districtSelect.appendChild(option);
                    });
                })
                .catch(err => console.error('Gagal memuat kecamatan:', err));
        }

        function fetchVillages(districtId) {
            if (!districtId) return;

            fetch(`/regions/villages/${districtId}`)
                .then(res => res.json())
                .then(data => {
                    resetDropdown(villageSelect, 'Pilih Kelurahan');
                    data.forEach(village => {
                        const option = document.createElement('option');
                        option.value = village.id;
                        option.textContent = village.name;
                        villageSelect.appendChild(option);
                    });
                })
                .catch(err => console.error('Gagal memuat kelurahan:', err));
        }

        // Event listeners for cascading dropdowns
        // When country is changed
        countrySelect.addEventListener('change', function() {
            const val = this.value.toLowerCase();
            if (val === 'indonesia') {
                // Show the province, city, district, village, and postal code dropdowns
                provinceContainer.style.display = 'block';
                cityContainer.style.display = 'block';
                districtContainer.style.display = 'block';
                villageContainer.style.display = 'block';
                postalCodeContainer.style.display = 'block';
                fetchProvinces();
            } else {
                // Hide the province, city, district, village, and postal code dropdowns
                provinceContainer.style.display = 'none';
                cityContainer.style.display = 'none';
                districtContainer.style.display = 'none';
                villageContainer.style.display = 'none';
                postalCodeContainer.style.display = 'none';

                // Reset dropdowns
                resetDropdown(provinceSelect, 'Pilih Provinsi');
                resetDropdown(citySelect, 'Pilih Kota/Kabupaten');
                resetDropdown(districtSelect, 'Pilih Kecamatan');
                resetDropdown(villageSelect, 'Pilih Kelurahan');
            }
        });

        // When province is changed
        provinceSelect.addEventListener('change', function() {
            if (this.value) {
                // Save the province name in a hidden field
                const provinceName = this.options[this.selectedIndex].textContent;
                let provinceNameInput = document.getElementById('province_name');
                if (!provinceNameInput) {
                    provinceNameInput = document.createElement('input');
                    provinceNameInput.type = 'hidden';
                    provinceNameInput.id = 'province_name';
                    provinceNameInput.name = 'province_name';
                    form.appendChild(provinceNameInput);
                }
                provinceNameInput.value = provinceName;

                fetchCities(this.value);
            } else {
                resetDropdown(citySelect, 'Pilih Kota/Kabupaten');
                resetDropdown(districtSelect, 'Pilih Kecamatan');
                resetDropdown(villageSelect, 'Pilih Kelurahan');
            }
        });

        // When city is changed
        citySelect.addEventListener('change', function() {
            if (this.value) {
                // Save the city name in a hidden field
                const cityName = this.options[this.selectedIndex].textContent;
                let cityNameInput = document.getElementById('city_name');
                if (!cityNameInput) {
                    cityNameInput = document.createElement('input');
                    cityNameInput.type = 'hidden';
                    cityNameInput.id = 'city_name';
                    cityNameInput.name = 'city_name';
                    form.appendChild(cityNameInput);
                }
                cityNameInput.value = cityName;

                fetchDistricts(this.value);
            } else {
                resetDropdown(districtSelect, 'Pilih Kecamatan');
                resetDropdown(villageSelect, 'Pilih Kelurahan');
            }
        });

        // When district is changed
        districtSelect.addEventListener('change', function() {
            if (this.value) {
                // Save the district name in a hidden field
                const districtName = this.options[this.selectedIndex].textContent;
                let districtNameInput = document.getElementById('district_name');
                if (!districtNameInput) {
                    districtNameInput = document.createElement('input');
                    districtNameInput.type = 'hidden';
                    districtNameInput.id = 'district_name';
                    districtNameInput.name = 'district_name';
                    form.appendChild(districtNameInput);
                }
                districtNameInput.value = districtName;

                fetchVillages(this.value);
            } else {
                resetDropdown(villageSelect, 'Pilih Kelurahan');
            }
        });

        // When village is changed
        villageSelect.addEventListener('change', function() {
            if (this.value) {
                // Save the village name in a hidden field
                const villageName = this.options[this.selectedIndex].textContent;
                let villageNameInput = document.getElementById('village_name');
                if (!villageNameInput) {
                    villageNameInput = document.createElement('input');
                    villageNameInput.type = 'hidden';
                    villageNameInput.id = 'village_name';
                    villageNameInput.name = 'village_name';
                    form.appendChild(villageNameInput);
                }
                villageNameInput.value = villageName;
            }
        });

        // Initialize country dropdown
        fetchCountries();
    });
</script>
@endpush