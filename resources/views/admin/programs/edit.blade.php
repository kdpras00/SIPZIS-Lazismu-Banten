@extends('layouts.app')

@section('page-title', 'Edit Program')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Edit Program</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.programs.update', $program) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-control-label">Nama Program</label>
                                    <input class="form-control @error('name') is-invalid @enderror"
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name', $program->name) }}"
                                        required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description" class="form-control-label">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                        id="description"
                                        name="description"
                                        rows="3">{{ old('description', $program->description) }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Category Selection -->
                                <div class="form-group mb-3">
                                    <label for="category" class="form-control-label">Kategori Utama</label>
                                    <select class="form-control @error('category') is-invalid @enderror"
                                        id="category"
                                        name="category"
                                        required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="zakat" {{ (old('category', $categoryType) == 'zakat') ? 'selected' : '' }}>
                                            Zakat
                                        </option>
                                        <option value="infaq" {{ (old('category', $categoryType) == 'infaq') ? 'selected' : '' }}>
                                            Infaq
                                        </option>
                                        <option value="shadaqah" {{ (old('category', $categoryType) == 'shadaqah') ? 'selected' : '' }}>
                                            Shadaqah
                                        </option>
                                        <option value="pilar" {{ (old('category', $categoryType) == 'pilar') ? 'selected' : '' }}>
                                            Program Pilar
                                        </option>
                                    </select>
                                    @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Sub-category Selection (Dynamic) -->
                                <div class="subcategory-section" id="zakat-subcategory" style="display: none;">
                                    <div class="form-group mb-3">
                                        <label for="zakat_type" class="form-control-label">Jenis Zakat</label>
                                        <select class="form-control"
                                            id="zakat_type"
                                            name="zakat_type">
                                            <option value="umum" {{ (old('zakat_type', $categorySubtype) == 'umum') ? 'selected' : '' }}>
                                                Tidak Ada Jenis Khusus
                                            </option>
                                            <option value="fitrah" {{ (old('zakat_type', $categorySubtype) == 'fitrah') ? 'selected' : '' }}>
                                                Zakat Fitrah
                                            </option>
                                            <option value="mal" {{ (old('zakat_type', $categorySubtype) == 'mal') ? 'selected' : '' }}>
                                                Zakat Mal
                                            </option>
                                            <option value="profesi" {{ (old('zakat_type', $categorySubtype) == 'profesi') ? 'selected' : '' }}>
                                                Zakat Profesi
                                            </option>
                                            <option value="pertanian" {{ (old('zakat_type', $categorySubtype) == 'pertanian') ? 'selected' : '' }}>
                                                Zakat Pertanian
                                            </option>
                                            <option value="perdagangan" {{ (old('zakat_type', $categorySubtype) == 'perdagangan') ? 'selected' : '' }}>
                                                Zakat Perdagangan
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="subcategory-section" id="infaq-subcategory" style="display: none;">
                                    <div class="form-group mb-3">
                                        <label for="infaq_type" class="form-control-label">Jenis Infaq</label>
                                        <select class="form-control"
                                            id="infaq_type"
                                            name="infaq_type">
                                            <option value="umum" {{ (old('infaq_type', $categorySubtype) == 'umum') ? 'selected' : '' }}>
                                                Tidak Ada Jenis Khusus
                                            </option>
                                            <option value="masjid" {{ (old('infaq_type', $categorySubtype) == 'masjid') ? 'selected' : '' }}>
                                                Infaq Masjid
                                            </option>
                                            <option value="pendidikan" {{ (old('infaq_type', $categorySubtype) == 'pendidikan') ? 'selected' : '' }}>
                                                Infaq Pendidikan
                                            </option>
                                            <option value="kemanusiaan" {{ (old('infaq_type', $categorySubtype) == 'kemanusiaan') ? 'selected' : '' }}>
                                                Infaq Kemanusiaan
                                            </option>
                                            <option value="bencana" {{ (old('infaq_type', $categorySubtype) == 'bencana') ? 'selected' : '' }}>
                                                Infaq Bencana
                                            </option>
                                            <option value="sosial" {{ (old('infaq_type', $categorySubtype) == 'sosial') ? 'selected' : '' }}>
                                                Infaq Sosial
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="subcategory-section" id="shadaqah-subcategory" style="display: none;">
                                    <div class="form-group mb-3">
                                        <label for="shadaqah_type" class="form-control-label">Jenis Shadaqah</label>
                                        <select class="form-control"
                                            id="shadaqah_type"
                                            name="shadaqah_type">
                                            <option value="umum" {{ (old('shadaqah_type', $categorySubtype) == 'umum') ? 'selected' : '' }}>
                                                Tidak Ada Jenis Khusus
                                            </option>
                                            <option value="rutin" {{ (old('shadaqah_type', $categorySubtype) == 'rutin') ? 'selected' : '' }}>
                                                Shadaqah Rutin
                                            </option>
                                            <option value="jariyah" {{ (old('shadaqah_type', $categorySubtype) == 'jariyah') ? 'selected' : '' }}>
                                                Shadaqah Jariyah
                                            </option>
                                            <option value="tetangga" {{ (old('shadaqah_type', $categorySubtype) == 'tetangga') ? 'selected' : '' }}>
                                                Shadaqah Tetangga
                                            </option>
                                            <option value="pakaian" {{ (old('shadaqah_type', $categorySubtype) == 'pakaian') ? 'selected' : '' }}>
                                                Shadaqah Pakaian
                                            </option>
                                            <option value="fidyah" {{ (old('shadaqah_type', $categorySubtype) == 'fidyah') ? 'selected' : '' }}>
                                                Fidyah
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="subcategory-section" id="pilar-subcategory" style="display: none;">
                                    <div class="form-group mb-3">
                                        <label for="pilar_category" class="form-control-label">Kategori Program Pilar</label>
                                        <select class="form-control"
                                            id="pilar_category"
                                            name="pilar_category">
                                            <option value="umum" {{ (old('pilar_category', $categorySubtype) == 'umum') ? 'selected' : '' }}>
                                                Tidak Ada Jenis Khusus
                                            </option>
                                            <option value="pendidikan" {{ (old('pilar_category', $categorySubtype) == 'pendidikan') ? 'selected' : '' }}>
                                                Pendidikan
                                            </option>
                                            <option value="kesehatan" {{ (old('pilar_category', $categorySubtype) == 'kesehatan') ? 'selected' : '' }}>
                                                Kesehatan
                                            </option>
                                            <option value="ekonomi" {{ (old('pilar_category', $categorySubtype) == 'ekonomi') ? 'selected' : '' }}>
                                                Ekonomi
                                            </option>
                                            <option value="sosial-dakwah" {{ (old('pilar_category', $categorySubtype) == 'sosial-dakwah') ? 'selected' : '' }}>
                                                Sosial & Dakwah
                                            </option>
                                            <option value="kemanusiaan" {{ (old('pilar_category', $categorySubtype) == 'kemanusiaan') ? 'selected' : '' }}>
                                                Kemanusiaan
                                            </option>
                                            <option value="lingkungan" {{ (old('pilar_category', $categorySubtype) == 'lingkungan') ? 'selected' : '' }}>
                                                Lingkungan
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="target_amount" class="form-control-label">Target Dana (Rp)</label>
                                            <input class="form-control @error('target_amount') is-invalid @enderror"
                                                type="number"
                                                id="target_amount"
                                                name="target_amount"
                                                value="{{ old('target_amount', $program->target_amount) }}"
                                                min="0"
                                                step="0.01">
                                            @error('target_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="status" class="form-control-label">Status</label>
                                            <select class="form-control @error('status') is-invalid @enderror"
                                                id="status"
                                                name="status"
                                                required>
                                                <option value="active" {{ (old('status', $program->status) == 'active') ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="inactive" {{ (old('status', $program->status) == 'inactive') ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="photo" class="form-control-label">Foto Program</label>
                                    <div class="card bg-gradient-dark mb-3">
                                        <div class="card-body text-center p-3">
                                            <img id="preview" src="{{ $program->photo ? (filter_var($program->photo, FILTER_VALIDATE_URL) ? $program->photo : asset('storage/' . $program->photo)) : asset('img/masjid.webp') }}"
                                                class="img-fluid rounded mb-3"
                                                alt="Preview Foto"
                                                style="height: 250px; object-fit: cover; width: 100%;">
                                            <div>
                                                <input type="file"
                                                    class="form-control @error('photo') is-invalid @enderror"
                                                    id="photo"
                                                    name="photo"
                                                    accept="image/*">
                                                <small class="text-white">Format: JPG, PNG, GIF (Max: 2MB)</small>
                                                @error('photo')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Program
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category');
        const subcategorySections = document.querySelectorAll('.subcategory-section');

        // Function to show/hide subcategory sections
        function toggleSubcategory() {
            // Hide all subcategory sections
            subcategorySections.forEach(section => {
                section.style.display = 'none';
            });

            // Show selected subcategory section
            const selectedCategory = categorySelect.value;
            if (selectedCategory) {
                document.getElementById(selectedCategory + '-subcategory').style.display = 'block';
            }
        }

        // Initialize the display based on the current category
        const currentCategory = "<?php echo old('category', $categoryType); ?>";
        if (currentCategory) {
            categorySelect.value = currentCategory;
            toggleSubcategory();
        }

        // Add event listener
        categorySelect.addEventListener('change', toggleSubcategory);

        // Image preview functionality
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush