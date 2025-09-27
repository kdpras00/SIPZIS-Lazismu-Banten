@if($muzakki->count() > 0)
<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead class="bg-light">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Kota</th>
                <th>Pekerjaan</th>
                <th>Status</th>
                <th>Terdaftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($muzakki as $item)
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                            <i class="bi bi-person text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $item->name }}</div>
                            @if($item->nik)
                            <small class="text-muted">NIK: {{ $item->nik }}</small>
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    @if($item->email)
                    <span>{{ $item->email }}</span>
                    @if($item->user)
                    <span class="badge bg-success ms-1">User</span>
                    @endif
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                <td>{{ $item->phone ?: '-' }}</td>
                <td>{{ $item->city ?: '-' }}</td>
                <td>
                    @if($item->occupation)
                    <span class="badge bg-info">{{ ucwords(str_replace('_', ' ', $item->occupation)) }}</span>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    @if($item->is_active)
                    <span class="badge bg-success">Aktif</span>
                    @else
                    <span class="badge bg-secondary">Tidak Aktif</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('muzakki.show', $item->id) }}" class="btn btn-outline-info btn-sm" title="Lihat Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('muzakki.edit', $item->id) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('muzakki.toggle-status', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-warning btn-sm" title="Toggle Status">
                                <i class="bi bi-toggle-{{ $item->is_active ? 'on' : 'off' }}"></i>
                            </button>
                        </form>
                        <form action="{{ route('muzakki.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if(isset($pagination))
<div class="card-footer bg-white">
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-muted">
            Menampilkan {{ $pagination['from'] ?? 1 }} sampai {{ $pagination['to'] ?? count($muzakki) }} dari {{ $pagination['total'] ?? count($muzakki) }} data
        </div>
        @if($pagination['last_page'] > 1)
        <nav>
            <ul class="pagination pagination-sm mb-0">
                @if($pagination['current_page'] > 1)
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="{{ $pagination['current_page'] - 1 }}">‹</a>
                    </li>
                @endif
                
                @for($i = 1; $i <= $pagination['last_page']; $i++)
                    <li class="page-item {{ $pagination['current_page'] == $i ? 'active' : '' }}">
                        <a class="page-link" href="#" data-page="{{ $i }}">{{ $i }}</a>
                    </li>
                @endfor
                
                @if($pagination['current_page'] < $pagination['last_page'])
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="{{ $pagination['current_page'] + 1 }}">›</a>
                    </li>
                @endif
            </ul>
        </nav>
        @endif
    </div>
</div>
@endif

@else
<div class="text-center py-4">
    <i class="bi bi-inbox display-4 text-muted mb-3 d-block"></i>
    <h5 class="text-muted">Tidak ada data muzakki</h5>
    <p class="text-muted">Tidak ada muzakki yang sesuai dengan kriteria pencarian</p>
    <button type="button" id="clear-search" class="btn btn-outline-primary">
        <i class="bi bi-arrow-clockwise"></i> Reset Pencarian
    </button>
</div>
@endif