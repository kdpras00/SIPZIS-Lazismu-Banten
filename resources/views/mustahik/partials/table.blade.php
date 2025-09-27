@if($mustahik->count() > 0)
<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead class="bg-light">
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Telepon</th>
                <th>Kota</th>
                <th>Status Verifikasi</th>
                <th>Terdaftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mustahik as $item)
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                            <i class="bi bi-person-heart text-success"></i>
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
                    <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $item->category)) }}</span>
                </td>
                <td>{{ $item->phone ?: '-' }}</td>
                <td>{{ $item->city ?: '-' }}</td>
                <td>
                    @switch($item->verification_status)
                        @case('pending')
                            <span class="badge bg-warning">Menunggu</span>
                            @break
                        @case('verified')
                            <span class="badge bg-success">Terverifikasi</span>
                            @break
                        @case('rejected')
                            <span class="badge bg-danger">Ditolak</span>
                            @break
                        @default
                            <span class="badge bg-secondary">{{ $item->verification_status }}</span>
                    @endswitch
                </td>
                <td>{{ $item->created_at->format('d M Y') }}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('mustahik.show', $item) }}" class="btn btn-outline-info btn-sm" title="Lihat Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('mustahik.edit', $item) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($item->verification_status === 'pending')
                        <button type="button" class="btn btn-outline-success btn-sm" title="Verifikasi" onclick="showVerifyModal({{ $item->id }}, '{{ $item->name }}')">
                            <i class="bi bi-check-circle"></i>
                        </button>
                        @endif
                        <form action="{{ route('mustahik.toggle-status', $item) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-warning btn-sm" title="Toggle Status">
                                <i class="bi bi-toggle-{{ $item->is_active ? 'on' : 'off' }}"></i>
                            </button>
                        </form>
                        <form action="{{ route('mustahik.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
            Menampilkan {{ $pagination['from'] ?? 1 }} sampai {{ $pagination['to'] ?? count($mustahik) }} dari {{ $pagination['total'] ?? count($mustahik) }} data
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
@elseif($mustahik->hasPages())
<div class="card-footer bg-white">
    {{ $mustahik->withQueryString()->links() }}
</div>
@endif

@else
<div class="text-center py-4">
    <i class="bi bi-inbox display-4 text-muted mb-3 d-block"></i>
    <h5 class="text-muted">Tidak ada data mustahik</h5>
    <p class="text-muted">Belum ada mustahik yang terdaftar dalam sistem atau sesuai kriteria pencarian</p>
    <a href="{{ route('mustahik.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Mustahik Pertama
    </a>
</div>
@endif

<script>
// Verify modal function
function showVerifyModal(id, name) {
    if(confirm(`Verifikasi mustahik: ${name}?`)) {
        // Create a form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/mustahik/${id}/verify`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="status" value="verified">
        `;
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>