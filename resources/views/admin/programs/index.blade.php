@extends('layouts.app')

@section('page-title', 'Kelola Program')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Kelola Program</h6>
                        <div>
                            <a href="{{ route('admin.programs.bulk-create') }}" class="btn btn-success me-2">
                                <i class="fas fa-plus-circle me-1"></i> Tambah Massal
                            </a>
                            <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Program
                            </a>
                        </div>
                    </div>
                    <p class="text-sm text-muted mb-0">Daftar semua program yang tersedia di sistem</p>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-4 mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Category Tabs -->
                    <div class="px-4 mb-3 border-bottom">
                        <ul class="nav nav-tabs" id="programTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="zakat-tab" data-bs-toggle="tab" data-bs-target="#zakat" type="button" role="tab">Zakat</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="infaq-tab" data-bs-toggle="tab" data-bs-target="#infaq" type="button" role="tab">Infaq</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="shadaqah-tab" data-bs-toggle="tab" data-bs-target="#shadaqah" type="button" role="tab">Shadaqah</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pilar-tab" data-bs-toggle="tab" data-bs-target="#pilar" type="button" role="tab">Program Pilar</button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Contents -->
                    <div class="tab-content px-4" id="programTabsContent">
                        <!-- Zakat Tab -->
                        <div class="tab-pane fade show active" id="zakat" role="tabpanel">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Program</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Target</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Terkumpul</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progress</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $zakatPrograms = $groupedPrograms->filter(function($programs) {
                                        return $programs->first()->category === 'zakat';
                                        })->flatten();
                                        @endphp

                                        @forelse($zakatPrograms as $program)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center px-2 py-1">
                                                    <img src="{{ $program->image_url }}"
                                                        class="avatar avatar-lg me-3" alt="{{ $program->name }}"
                                                        onerror="this.src='{{ asset('img/masjid.webp') }}';"
                                                        style="width:80px; height:80px; object-fit:cover;">
                                                    <div>
                                                        <h6 class="mb-0 text-sm">{{ $program->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ Str::limit($program->description, 50) }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="align-middle">
                                                <p class="text-xs font-weight-bold mb-0">Zakat</p>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $program->formatted_total_target }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $program->formatted_total_collected }}</span>
                                            </td>

                                            <td class="align-middle text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <span class="text-xs font-weight-bold">{{ number_format($program->progress_percentage,1) }}%</span>
                                                    <div class="progress w-100" style="max-width:120px; height:6px;">
                                                        <div class="progress-bar bg-gradient-success"
                                                            role="progressbar"
                                                            style="width: {{ $program->progress_percentage }}%"
                                                            aria-valuenow="{{ $program->progress_percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                @if($program->status == 'active')
                                                <span class="badge bg-success text-white px-3 py-2">Active</span>
                                                @else
                                                <span class="badge bg-secondary text-white px-3 py-2">Inactive</span>
                                                @endif
                                            </td>

                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash me-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Belum ada program zakat yang tersedia</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Infaq Tab -->
                        <div class="tab-pane fade" id="infaq" role="tabpanel">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Program</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Target</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Terkumpul</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progress</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $infaqPrograms = $groupedPrograms->filter(function($programs) {
                                        return $programs->first()->category === 'infaq';
                                        })->flatten();
                                        @endphp

                                        @forelse($infaqPrograms as $program)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center px-2 py-1">
                                                    <img src="{{ $program->image_url }}"
                                                        class="avatar avatar-lg me-3" alt="{{ $program->name }}"
                                                        onerror="this.src='{{ asset('img/masjid.webp') }}';"
                                                        style="width:80px; height:80px; object-fit:cover;">
                                                    <div>
                                                        <h6 class="mb-0 text-sm">{{ $program->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ Str::limit($program->description, 50) }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="align-middle">
                                                <p class="text-xs font-weight-bold mb-0">Infaq</p>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $program->formatted_total_target }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $program->formatted_total_collected }}</span>
                                            </td>

                                            <td class="align-middle text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <span class="text-xs font-weight-bold">{{ number_format($program->progress_percentage,1) }}%</span>
                                                    <div class="progress w-100" style="max-width:120px; height:6px;">
                                                        <div class="progress-bar bg-gradient-success"
                                                            role="progressbar"
                                                            style="width: {{ $program->progress_percentage }}%"
                                                            aria-valuenow="{{ $program->progress_percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                @if($program->status == 'active')
                                                <span class="badge bg-success text-white px-3 py-2">Active</span>
                                                @else
                                                <span class="badge bg-secondary text-white px-3 py-2">Inactive</span>
                                                @endif
                                            </td>

                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash me-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Belum ada program infaq yang tersedia</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Shadaqah Tab -->
                        <div class="tab-pane fade" id="shadaqah" role="tabpanel">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Program</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Target</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Terkumpul</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progress</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $shadaqahPrograms = $groupedPrograms->filter(function($programs) {
                                        return $programs->first()->category === 'shadaqah';
                                        })->flatten();
                                        @endphp

                                        @forelse($shadaqahPrograms as $program)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center px-2 py-1">
                                                    <img src="{{ $program->image_url }}"
                                                        class="avatar avatar-lg me-3" alt="{{ $program->name }}"
                                                        onerror="this.src='{{ asset('img/masjid.webp') }}';"
                                                        style="width:80px; height:80px; object-fit:cover;">
                                                    <div>
                                                        <h6 class="mb-0 text-sm">{{ $program->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ Str::limit($program->description, 50) }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="align-middle">
                                                <p class="text-xs font-weight-bold mb-0">Shadaqah</p>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $program->formatted_total_target }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $program->formatted_total_collected }}</span>
                                            </td>

                                            <td class="align-middle text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <span class="text-xs font-weight-bold">{{ number_format($program->progress_percentage,1) }}%</span>
                                                    <div class="progress w-100" style="max-width:120px; height:6px;">
                                                        <div class="progress-bar bg-gradient-success"
                                                            role="progressbar"
                                                            style="width: {{ $program->progress_percentage }}%"
                                                            aria-valuenow="{{ $program->progress_percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                @if($program->status == 'active')
                                                <span class="badge bg-success text-white px-3 py-2">Active</span>
                                                @else
                                                <span class="badge bg-secondary text-white px-3 py-2">Inactive</span>
                                                @endif
                                            </td>

                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash me-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Belum ada program shadaqah yang tersedia</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Program Pilar Tab -->
                        <div class="tab-pane fade" id="pilar" role="tabpanel">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Program</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Target</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Terkumpul</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progress</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $pilarCategories = ['pendidikan', 'kesehatan', 'ekonomi', 'sosial-dakwah', 'kemanusiaan', 'lingkungan'];
                                        $pilarPrograms = $groupedPrograms->filter(function($programs) use ($pilarCategories) {
                                        return in_array($programs->first()->category, $pilarCategories);
                                        })->flatten();
                                        @endphp

                                        @forelse($pilarPrograms as $program)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center px-2 py-1">
                                                    <img src="{{ $program->image_url }}"
                                                        class="avatar avatar-lg me-3" alt="{{ $program->name }}"
                                                        onerror="this.src='{{ asset('img/masjid.webp') }}';"
                                                        style="width:80px; height:80px; object-fit:cover;">
                                                    <div>
                                                        <h6 class="mb-0 text-sm">{{ $program->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ Str::limit($program->description, 50) }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="align-middle">
                                                @php
                                                $categoryNames = [
                                                'pendidikan' => 'Pendidikan',
                                                'kesehatan' => 'Kesehatan',
                                                'ekonomi' => 'Ekonomi',
                                                'sosial-dakwah' => 'Sosial & Dakwah',
                                                'kemanusiaan' => 'Kemanusiaan',
                                                'lingkungan' => 'Lingkungan'
                                                ];
                                                $displayName = $categoryNames[$program->category] ?? ucfirst($program->category);
                                                @endphp
                                                <p class="text-xs font-weight-bold mb-0">{{ $displayName }}</p>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $program->formatted_total_target }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $program->formatted_total_collected }}</span>
                                            </td>

                                            <td class="align-middle text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <span class="text-xs font-weight-bold">{{ number_format($program->progress_percentage,1) }}%</span>
                                                    <div class="progress w-100" style="max-width:120px; height:6px;">
                                                        <div class="progress-bar bg-gradient-success"
                                                            role="progressbar"
                                                            style="width: {{ $program->progress_percentage }}%"
                                                            aria-valuenow="{{ $program->progress_percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                @if($program->status == 'active')
                                                <span class="badge bg-success text-white px-3 py-2">Active</span>
                                                @else
                                                <span class="badge bg-secondary text-white px-3 py-2">Inactive</span>
                                                @endif
                                            </td>

                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash me-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Belum ada program pilar yang tersedia</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash;
        if (hash) {
            const tabTrigger = document.querySelector(`[data-bs-target="${hash}"]`);
            if (tabTrigger) new bootstrap.Tab(tabTrigger).show();
        }
        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(trigger => {
            trigger.addEventListener('shown.bs.tab', e => {
                window.location.hash = e.target.getAttribute('data-bs-target');
            });
        });
    });
</script>
@endpush