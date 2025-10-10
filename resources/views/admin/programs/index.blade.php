@extends('layouts.app')

@section('page-title', 'Kelola Program')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Kelola Program</h6>
                        <div>
                            <a href="{{ route('admin.programs.bulk-create') }}" class="btn btn-success me-2">
                                <i class="fas fa-plus-circle"></i> Tambah Massal
                            </a>
                            <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Program
                            </a>
                        </div>
                    </div>
                    <p class="text-sm mb-0">
                        Daftar semua program yang tersedia di sistem
                    </p>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-4 mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Category Tabs -->
                    <div class="px-4 mb-3">
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

                    <!-- Tab Content -->
                    <div class="tab-content px-4" id="programTabsContent">
                        <!-- Zakat Programs -->
                        <div class="tab-pane fade show active" id="zakat" role="tabpanel">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
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
                                        @forelse($groupedPrograms->filter(function($programs) { return $programs->first()->category && strpos($programs->first()->category, 'zakat-') === 0; }) as $category => $programs)
                                        @foreach($programs as $program)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center me-3">
                                                        <img src="{{ $program->photo ? asset('storage/' . $program->photo) : asset('img/masjid.webp') }}"
                                                            class="avatar avatar-lg me-3" alt="{{ $program->name }}"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $program->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ Str::limit($program->description, 40) }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                @php
                                                $subtype = substr($program->category, 6);
                                                $displayName = ($subtype === 'umum') ? 'Tidak Ada Jenis Khusus' : ucfirst(str_replace(['zakat-', '-'], ['Zakat ', ' '], $program->category));
                                                @endphp
                                                <p class="text-xs font-weight-bold mb-0">{{ $displayName }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $program->formatted_total_target }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $program->formatted_total_collected }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <span class="text-xs font-weight-bold mr-2">
                                                        {{ number_format($program->progress_percentage, 1) }}%
                                                    </span>
                                                    <div style="min-width: 100px;">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-gradient-success"
                                                                role="progressbar"
                                                                aria-valuenow="<?php echo $program->progress_percentage; ?>"
                                                                aria-valuemin="0"
                                                                aria-valuemax="100"
                                                                style="width: <?php echo $program->progress_percentage; ?>%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if($program->status == 'active')
                                                <span class="badge badge-sm bg-gradient-success">Active</span>
                                                @else
                                                <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('admin.programs.edit', $program) }}"
                                                        class="btn btn-sm btn-outline-secondary d-flex align-items-center"
                                                        data-toggle="tooltip"
                                                        data-original-title="Edit">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.programs.destroy', $program) }}"
                                                        method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                            data-toggle="tooltip"
                                                            data-original-title="Delete"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                                                            <i class="fas fa-trash me-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="py-5">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">Belum ada program zakat yang tersedia</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Infaq Programs -->
                        <div class="tab-pane fade" id="infaq" role="tabpanel">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
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
                                        @forelse($groupedPrograms->filter(function($programs) { return $programs->first()->category && strpos($programs->first()->category, 'infaq-') === 0; }) as $category => $programs)
                                        @foreach($programs as $program)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center me-3">
                                                        <img src="{{ $program->photo ? asset('storage/' . $program->photo) : asset('img/masjid.webp') }}"
                                                            class="avatar avatar-lg me-3" alt="{{ $program->name }}"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $program->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ Str::limit($program->description, 40) }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                @php
                                                $subtype = substr($program->category, 6);
                                                $displayName = ($subtype === 'umum') ? 'Tidak Ada Jenis Khusus' : ucfirst(str_replace(['infaq-', '-'], ['Infaq ', ' '], $program->category));
                                                @endphp
                                                <p class="text-xs font-weight-bold mb-0">{{ $displayName }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $program->formatted_total_target }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $program->formatted_total_collected }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <span class="text-xs font-weight-bold mr-2">
                                                        {{ number_format($program->progress_percentage, 1) }}%
                                                    </span>
                                                    <div style="min-width: 100px;">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-gradient-success"
                                                                role="progressbar"
                                                                aria-valuenow="<?php echo $program->progress_percentage; ?>"
                                                                aria-valuemin="0"
                                                                aria-valuemax="100"
                                                                style="width: <?php echo $program->progress_percentage; ?>%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if($program->status == 'active')
                                                <span class="badge badge-sm bg-gradient-success">Active</span>
                                                @else
                                                <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('admin.programs.edit', $program) }}"
                                                        class="btn btn-sm btn-outline-secondary d-flex align-items-center"
                                                        data-toggle="tooltip"
                                                        data-original-title="Edit">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.programs.destroy', $program) }}"
                                                        method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                            data-toggle="tooltip"
                                                            data-original-title="Delete"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                                                            <i class="fas fa-trash me-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="py-5">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">Belum ada program infaq yang tersedia</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Shadaqah Programs -->
                        <div class="tab-pane fade" id="shadaqah" role="tabpanel">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
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
                                        @forelse($groupedPrograms->filter(function($programs) { return $programs->first()->category && strpos($programs->first()->category, 'shadaqah-') === 0; }) as $category => $programs)
                                        @foreach($programs as $program)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center me-3">
                                                        <img src="{{ $program->photo ? asset('storage/' . $program->photo) : asset('img/masjid.webp') }}"
                                                            class="avatar avatar-lg me-3" alt="{{ $program->name }}"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $program->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ Str::limit($program->description, 40) }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                @php
                                                $subtype = substr($program->category, 9);
                                                $displayName = ($subtype === 'umum') ? 'Tidak Ada Jenis Khusus' : ucfirst(str_replace(['shadaqah-', '-'], ['Shadaqah ', ' '], $program->category));
                                                @endphp
                                                <p class="text-xs font-weight-bold mb-0">{{ $displayName }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $program->formatted_total_target }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $program->formatted_total_collected }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <span class="text-xs font-weight-bold mr-2">
                                                        {{ number_format($program->progress_percentage, 1) }}%
                                                    </span>
                                                    <div style="min-width: 100px;">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-gradient-success"
                                                                role="progressbar"
                                                                aria-valuenow="<?php echo $program->progress_percentage; ?>"
                                                                aria-valuemin="0"
                                                                aria-valuemax="100"
                                                                style="width: <?php echo $program->progress_percentage; ?>%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if($program->status == 'active')
                                                <span class="badge badge-sm bg-gradient-success">Active</span>
                                                @else
                                                <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('admin.programs.edit', $program) }}"
                                                        class="btn btn-sm btn-outline-secondary d-flex align-items-center"
                                                        data-toggle="tooltip"
                                                        data-original-title="Edit">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.programs.destroy', $program) }}"
                                                        method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                            data-toggle="tooltip"
                                                            data-original-title="Delete"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                                                            <i class="fas fa-trash me-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="py-5">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">Belum ada program shadaqah yang tersedia</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pilar Programs -->
                        <div class="tab-pane fade" id="pilar" role="tabpanel">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
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
                                        @forelse($groupedPrograms->filter(function($programs) { return $programs->first()->category && !in_array(substr($programs->first()->category, 0, strpos($programs->first()->category, '-') ?: strlen($programs->first()->category)), ['zakat', 'infaq', 'shadaqah']); }) as $category => $programs)
                                        @foreach($programs as $program)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center me-3">
                                                        <img src="{{ $program->photo ? asset('storage/' . $program->photo) : asset('img/masjid.webp') }}"
                                                            class="avatar avatar-lg me-3" alt="{{ $program->name }}"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $program->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ Str::limit($program->description, 40) }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                @php
                                                $displayName = ($program->category === 'umum') ? 'Tidak Ada Jenis Khusus' : ucfirst(str_replace('-', ' ', $program->category));
                                                @endphp
                                                <p class="text-xs font-weight-bold mb-0">{{ $displayName }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $program->formatted_total_target }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $program->formatted_total_collected }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <span class="text-xs font-weight-bold mr-2">
                                                        {{ number_format($program->progress_percentage, 1) }}%
                                                    </span>
                                                    <div style="min-width: 100px;">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-gradient-success"
                                                                role="progressbar"
                                                                aria-valuenow="<?php echo $program->progress_percentage; ?>"
                                                                aria-valuemin="0"
                                                                aria-valuemax="100"
                                                                style="width: <?php echo $program->progress_percentage; ?>%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if($program->status == 'active')
                                                <span class="badge badge-sm bg-gradient-success">Active</span>
                                                @else
                                                <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('admin.programs.edit', $program) }}"
                                                        class="btn btn-sm btn-outline-secondary d-flex align-items-center"
                                                        data-toggle="tooltip"
                                                        data-original-title="Edit">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.programs.destroy', $program) }}"
                                                        method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                            data-toggle="tooltip"
                                                            data-original-title="Delete"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                                                            <i class="fas fa-trash me-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="py-5">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">Belum ada program pilar yang tersedia</p>
                                                </div>
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
    // Initialize tabs
    document.addEventListener('DOMContentLoaded', function() {
        // Set active tab from URL hash if exists
        const hash = window.location.hash;
        if (hash) {
            const tabTrigger = document.querySelector(`[data-bs-target="${hash}"]`);
            if (tabTrigger) {
                const tab = new bootstrap.Tab(tabTrigger);
                tab.show();
            }
        }

        // Update URL hash when tab changes
        const tabTriggers = document.querySelectorAll('[data-bs-toggle="tab"]');
        tabTriggers.forEach(trigger => {
            trigger.addEventListener('shown.bs.tab', function(event) {
                window.location.hash = event.target.getAttribute('data-bs-target');
            });
        });
    });
</script>
@endpush