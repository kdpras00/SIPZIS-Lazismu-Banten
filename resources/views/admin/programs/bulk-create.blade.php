@extends('layouts.app')

@section('page-title', 'Tambah Program Massal')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Tambah Program Secara Massal</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.programs.store.bulk') }}" method="POST">
                        @csrf

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Tambahkan beberapa program sekaligus dengan mengisi formulir di bawah ini.
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" id="add-program">
                                    <i class="fas fa-plus"></i> Tambah Program
                                </button>
                            </div>
                        </div>

                        <div id="programs-container">
                            <!-- Program forms will be added here dynamically -->
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan Semua Program
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
        const container = document.getElementById('programs-container');
        const addButton = document.getElementById('add-program');
        let programIndex = 0;

        // Function to create a new program form
        function createProgramForm() {
            const programDiv = document.createElement('div');
            programDiv.className = 'program-form card mb-3';
            programDiv.innerHTML = `
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Program #${programIndex + 1}</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-program">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="programs[${programIndex}][name]" class="form-control-label">Nama Program</label>
                                <input class="form-control" type="text" name="programs[${programIndex}][name]" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="programs[${programIndex}][category]" class="form-control-label">Kategori Utama</label>
                                <select class="form-control program-category" name="programs[${programIndex}][category]" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="zakat">Zakat</option>
                                    <option value="infaq">Infaq</option>
                                    <option value="shadaqah">Shadaqah</option>
                                    <option value="pilar">Program Pilar</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="programs[${programIndex}][target_amount]" class="form-control-label">Target Dana (Rp)</label>
                                <input class="form-control" type="number" name="programs[${programIndex}][target_amount]" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="programs[${programIndex}][status]" class="form-control-label">Status</label>
                                <select class="form-control" name="programs[${programIndex}][status]" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="programs[${programIndex}][description]" class="form-control-label">Deskripsi</label>
                        <textarea class="form-control" name="programs[${programIndex}][description]" rows="2"></textarea>
                    </div>

                    <!-- Sub-category Selection (Dynamic) -->
                    <div class="subcategory-section" id="zakat-subcategory-${programIndex}" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="programs[${programIndex}][zakat_type]" class="form-control-label">Jenis Zakat</label>
                            <select class="form-control" name="programs[${programIndex}][zakat_type]">
                                <option value="umum">Tidak Ada Jenis Khusus</option>
                                <option value="fitrah">Zakat Fitrah</option>
                                <option value="mal">Zakat Mal</option>
                                <option value="profesi">Zakat Profesi</option>
                                <option value="pertanian">Zakat Pertanian</option>
                                <option value="perdagangan">Zakat Perdagangan</option>
                            </select>
                        </div>
                    </div>

                    <div class="subcategory-section" id="infaq-subcategory-${programIndex}" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="programs[${programIndex}][infaq_type]" class="form-control-label">Jenis Infaq</label>
                            <select class="form-control" name="programs[${programIndex}][infaq_type]">
                                <option value="umum">Tidak Ada Jenis Khusus</option>
                                <option value="masjid">Infaq Masjid</option>
                                <option value="pendidikan">Infaq Pendidikan</option>
                                <option value="kemanusiaan">Infaq Kemanusiaan</option>
                                <option value="bencana">Infaq Bencana</option>
                                <option value="sosial">Infaq Sosial</option>
                            </select>
                        </div>
                    </div>

                    <div class="subcategory-section" id="shadaqah-subcategory-${programIndex}" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="programs[${programIndex}][shadaqah_type]" class="form-control-label">Jenis Shadaqah</label>
                            <select class="form-control" name="programs[${programIndex}][shadaqah_type]">
                                <option value="umum">Tidak Ada Jenis Khusus</option>
                                <option value="rutin">Shadaqah Rutin</option>
                                <option value="jariyah">Shadaqah Jariyah</option>
                                <option value="tetangga">Shadaqah Tetangga</option>
                                <option value="pakaian">Shadaqah Pakaian</option>
                                <option value="fidyah">Fidyah</option>
                            </select>
                        </div>
                    </div>

                    <div class="subcategory-section" id="pilar-subcategory-${programIndex}" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="programs[${programIndex}][pilar_category]" class="form-control-label">Kategori Program Pilar</label>
                            <select class="form-control" name="programs[${programIndex}][pilar_category]">
                                <option value="umum">Tidak Ada Jenis Khusus</option>
                                <option value="pendidikan">Pendidikan</option>
                                <option value="kesehatan">Kesehatan</option>
                                <option value="ekonomi">Ekonomi</option>
                                <option value="sosial-dakwah">Sosial & Dakwah</option>
                                <option value="kemanusiaan">Kemanusiaan</option>
                                <option value="lingkungan">Lingkungan</option>
                            </select>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(programDiv);
            programIndex++;

            // Add event listener for remove button
            const removeButton = programDiv.querySelector('.remove-program');
            removeButton.addEventListener('click', function() {
                programDiv.remove();
                updateProgramNumbers();
            });

            // Add event listener for category change
            const categorySelect = programDiv.querySelector('.program-category');
            categorySelect.addEventListener('change', function() {
                // Hide all subcategory sections for this program
                programDiv.querySelectorAll('.subcategory-section').forEach(section => {
                    section.style.display = 'none';
                });

                // Show selected subcategory section
                const selectedCategory = this.value;
                if (selectedCategory) {
                    const subcategorySection = programDiv.querySelector(`#${selectedCategory}-subcategory-${programDiv.dataset.index || (programIndex - 1)}`);
                    if (subcategorySection) {
                        subcategorySection.style.display = 'block';
                    }
                }
            });
        }

        // Function to update program numbers
        function updateProgramNumbers() {
            const programForms = document.querySelectorAll('.program-form');
            programForms.forEach((form, index) => {
                const header = form.querySelector('.card-header h6');
                header.textContent = `Program #${index + 1}`;
            });
        }

        // Add initial program form
        createProgramForm();

        // Add event listener for add button
        addButton.addEventListener('click', createProgramForm);
    });
</script>
@endpush