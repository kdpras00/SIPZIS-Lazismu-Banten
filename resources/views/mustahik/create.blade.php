@extends('layouts.app')

@section('page-title', 'Tambah Mustahik')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Tambah Mustahik Baru</h2>
        <p class="text-muted">Menambahkan data mustahik (penerima zakat) baru ke dalam sistem</p>
    </div>
    <div>
        <a href="{{ route('mustahik.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-person-heart"></i> Form Data Mustahik</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('mustahik.store') }}" method="POST" id="mustahikForm">
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
                    </div>
                    
                    <!-- Category Information Section -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-tags"></i> Kategori Mustahik (Asnaf)
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                        id="category" 
                                        name="category" 
                                        required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $key)) }} - {{ explode(' - ', $label)[1] ?? $label }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="family_members" class="form-label">Jumlah Anggota Keluarga <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('family_members') is-invalid @enderror" 
                                       id="family_members" 
                                       name="family_members" 
                                       value="{{ old('family_members', 1) }}"
                                       min="1" 
                                       required>
                                @error('family_members')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_description" class="form-label">Deskripsi Kondisi</label>
                            <textarea class="form-control @error('category_description') is-invalid @enderror" 
                                      id="category_description" 
                                      name="category_description" 
                                      rows="3"
                                      placeholder="Jelaskan kondisi yang dialami...">{{ old('category_description') }}</textarea>
                            @error('category_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Family & Economic Information Section -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-house-heart"></i> Informasi Keluarga & Ekonomi
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="family_status" class="form-label">Status Keluarga</label>
                                <select class="form-select @error('family_status') is-invalid @enderror" 
                                        id="family_status" 
                                        name="family_status">
                                    <option value="">Pilih Status Keluarga</option>
                                    <option value="single" {{ old('family_status') == 'single' ? 'selected' : '' }}>Lajang</option>
                                    <option value="married" {{ old('family_status') == 'married' ? 'selected' : '' }}>Menikah</option>
                                    <option value="divorced" {{ old('family_status') == 'divorced' ? 'selected' : '' }}>Cerai</option>
                                    <option value="widow/widower" {{ old('family_status') == 'widow/widower' ? 'selected' : '' }}>Janda/Duda</option>
                                </select>
                                @error('family_status')
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
                        
                        <div class="mb-3">
                            <label for="income_source" class="form-label">Sumber Penghasilan</label>
                            <input type="text" 
                                   class="form-control @error('income_source') is-invalid @enderror" 
                                   id="income_source" 
                                   name="income_source" 
                                   value="{{ old('income_source') }}"
                                   placeholder="Buruh harian, pedagang kecil, tidak bekerja, dll">
                            @error('income_source')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Verification Section -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-shield-check"></i> Status Verifikasi
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="verification_status" class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                                <select class="form-select @error('verification_status') is-invalid @enderror" 
                                        id="verification_status" 
                                        name="verification_status" 
                                        required>
                                    <option value="pending" {{ old('verification_status', 'pending') == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="verified" {{ old('verification_status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                                    <option value="rejected" {{ old('verification_status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                @error('verification_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="verification_notes" class="form-label">Catatan Verifikasi</label>
                            <textarea class="form-control @error('verification_notes') is-invalid @enderror" 
                                      id="verification_notes" 
                                      name="verification_notes" 
                                      rows="3"
                                      placeholder="Catatan atau alasan terkait status verifikasi...">{{ old('verification_notes') }}</textarea>
                            @error('verification_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('mustahik.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Simpan Mustahik
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> 8 Asnaf (Kategori Mustahik)</h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <ul class="list-unstyled">
                        <li><strong>Fakir:</strong> Yang tidak memiliki harta/pekerjaan</li>
                        <li><strong>Miskin:</strong> Yang memiliki harta/pekerjaan tapi tidak mencukupi</li>
                        <li><strong>Amil:</strong> Petugas pengumpul dan pembagi zakat</li>
                        <li><strong>Muallaf:</strong> Yang baru masuk Islam</li>
                        <li><strong>Riqab:</strong> Memerdekakan budak/tawanan</li>
                        <li><strong>Gharim:</strong> Yang berutang untuk kebaikan</li>
                        <li><strong>Fi Sabilillah:</strong> Untuk kepentingan umum di jalan Allah</li>
                        <li><strong>Ibnu Sabil:</strong> Musafir yang kehabisan bekal</li>
                    </ul>
                </small>
                
                <div class="alert alert-info small mt-3">
                    <i class="bi bi-exclamation-triangle"></i>
                    Pastikan kategori sesuai dengan kondisi mustahik yang sebenarnya.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // NIK validation (numeric only, max 16 digits)
    document.getElementById('nik').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 16);
    });
    
    // Phone validation (numeric only)
    document.getElementById('phone').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    // Format monthly income
    document.getElementById('monthly_income').addEventListener('input', function() {
        let value = this.value.replace(/[^0-9]/g, '');
        this.value = value;
    });
    
    // Category change handler - show description
    document.getElementById('category').addEventListener('change', function() {
        const descriptions = {
            'fakir': 'Orang yang tidak memiliki harta dan pekerjaan untuk mencukupi kebutuhan dasar',
            'miskin': 'Orang yang memiliki harta atau pekerjaan tetapi tidak mencukupi kebutuhan dasar',
            'amil': 'Petugas yang bertugas mengumpulkan dan membagikan zakat',
            'muallaf': 'Orang yang baru masuk Islam atau yang hatinya perlu diperkuat imannya',
            'riqab': 'Untuk memerdekakan budak atau membebaskan muslim dari tawanan',
            'gharim': 'Orang yang berutang untuk kepentingan yang tidak maksiat dan tidak mampu membayar',
            'fisabilillah': 'Untuk kepentingan umum di jalan Allah seperti pendidikan, dakwah, dll',
            'ibnu_sabil': 'Musafir yang kehabisan bekal dalam perjalanan yang halal'
        };
        
        const descField = document.getElementById('category_description');
        if (this.value && descriptions[this.value]) {
            descField.placeholder = descriptions[this.value];
        }
    });
});
</script>
@endpush