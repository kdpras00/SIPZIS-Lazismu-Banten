@extends('layouts.app')

@section('page-title', 'Kelola Campaign')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Kelola Campaign</h6>
                        <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Campaign
                        </a>
                    </div>
                    <p class="text-sm mb-0">
                        Daftar semua campaign yang tersedia di sistem
                    </p>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Campaign</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Target</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Terkumpul</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progress</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sisa Hari</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($campaigns as $campaign)
                                <tr>
                                    <td class="align-middle">
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center me-3">
                                                <img src="{{ $campaign->image_url }}"
                                                    class="avatar avatar-lg me-3" alt="{{ $campaign->title }}"
                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $campaign->title }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ Str::limit($campaign->description, 40) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <p class="text-xs font-weight-bold mb-0">{{ ucfirst(str_replace('-', ' ', $campaign->program_category)) }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <span class="text-xs font-weight-bold mr-2">
                                                {{ number_format($campaign->progress_percentage, 1) }}%
                                            </span>
                                            <div style="min-width: 100px;">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-success"
                                                        role="progressbar"
                                                        aria-valuenow="{{ $campaign->progress_percentage }}"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        style="width: <?php echo $campaign->progress_percentage; ?>%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if($campaign->end_date)
                                        @if($campaign->remaining_days > 0)
                                        <span class="badge bg-info">{{ $campaign->remaining_days }} hari</span>
                                        @elseif($campaign->remaining_days == 0)
                                        <span class="badge bg-warning text-dark">Hari terakhir</span>
                                        @elseif($campaign->remaining_days == -1)
                                        @if($campaign->status == 'completed')
                                        <span class="badge bg-success">Selesai</span>
                                        @else
                                        <span class="badge bg-danger">Waktu Habis</span>
                                        @endif
                                        @endif
                                        @else
                                        <span class="badge bg-light text-dark">Tidak ada batas waktu</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if($campaign->status == 'published')
                                        <span class="badge bg-secondary">Published</span>
                                        @elseif($campaign->status == 'draft')
                                        <span class="badge bg-warning text-dark">Draft</span>
                                        @elseif($campaign->status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                        @elseif($campaign->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>

                                    <td class="align-middle text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.campaigns.edit', $campaign) }}"
                                                class="btn btn-sm btn-outline-secondary d-flex align-items-center"
                                                data-toggle="tooltip"
                                                data-original-title="Edit">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.campaigns.destroy', $campaign) }}"
                                                method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                    data-toggle="tooltip"
                                                    data-original-title="Delete"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus campaign ini?')">
                                                    <i class="fas fa-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="py-5">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada campaign yang tersedia</p>
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
@endsection