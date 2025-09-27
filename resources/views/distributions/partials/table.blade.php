@if($distributions->count() > 0)
<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead class="bg-light">
            <tr>
                <th>Kode Distribusi</th>
                <th>Mustahik</th>
                <th>Program</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($distributions as $distribution)
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                            <i class="bi bi-hand-thumbs-up text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $distribution->distribution_code }}</div>
                            @if($distribution->location)
                            <small class="text-muted">{{ $distribution->location }}</small>
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    <div class="fw-semibold">{{ $distribution->mustahik->name }}</div>
                    <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $distribution->mustahik->category)) }}</small>
                </td>
                <td>
                    @if($distribution->program_name)
                    <span class="badge bg-info">{{ $distribution->program_name }}</span>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    @switch($distribution->distribution_type)
                        @case('cash')
                            <span class="badge bg-success">Tunai</span>
                            @break
                        @case('goods')
                            <span class="badge bg-info">Barang</span>
                            @break
                        @case('voucher')
                            <span class="badge bg-warning">Voucher</span>
                            @break
                        @case('service')
                            <span class="badge bg-primary">Layanan</span>
                            @break
                        @default
                            <span class="badge bg-secondary">{{ ucwords($distribution->distribution_type) }}</span>
                    @endswitch
                </td>
                <td>
                    <div class="fw-bold">Rp {{ number_format($distribution->amount, 0, ',', '.') }}</div>
                    @if($distribution->goods_description)
                    <small class="text-muted">{{ Str::limit($distribution->goods_description, 30) }}</small>
                    @endif
                </td>
                <td>
                    @if($distribution->is_received)
                        <span class="badge bg-success">Sudah Diterima</span>
                        @if($distribution->received_date)
                        <br><small class="text-muted">{{ $distribution->received_date->format('d M Y') }}</small>
                        @endif
                    @else
                        <span class="badge bg-warning">Belum Diterima</span>
                    @endif
                </td>
                <td>{{ $distribution->distribution_date->format('d M Y') }}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('distributions.show', $distribution) }}" class="btn btn-outline-info btn-sm" title="Lihat Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('distributions.receipt', $distribution) }}" class="btn btn-outline-success btn-sm" title="Kwitansi" target="_blank">
                            <i class="bi bi-receipt"></i>
                        </a>
                        <a href="{{ route('distributions.edit', $distribution) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if(!$distribution->is_received)
                        <button type="button" class="btn btn-outline-warning btn-sm" title="Tandai Diterima" onclick="showMarkReceivedModal({{ $distribution->id }}, '{{ $distribution->mustahik->name }}')">
                            <i class="bi bi-check-circle"></i>
                        </button>
                        <form action="{{ route('distributions.destroy', $distribution) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus distribusi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($distributions->hasPages())
<div class="card-footer bg-white">
    {{ $distributions->withQueryString()->links() }}
</div>
@endif

@else
<div class="text-center py-4">
    <i class="bi bi-inbox display-4 text-muted mb-3 d-block"></i>
    <h5 class="text-muted">Tidak ada data distribusi</h5>
    <p class="text-muted">Belum ada distribusi zakat yang tercatat dalam sistem atau sesuai kriteria pencarian</p>
    <a href="{{ route('distributions.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Distribusi Pertama
    </a>
</div>
@endif

<!-- Mark as Received Modal -->
<div class="modal fade" id="markReceivedModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tandai Sebagai Diterima</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="markReceivedForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p>Konfirmasi bahwa distribusi untuk <strong id="mustahikNameModal"></strong> telah diterima?</p>
                    
                    <div class="mb-3">
                        <label for="received_by_name" class="form-label">Diterima Oleh</label>
                        <input type="text" class="form-control" id="received_by_name" name="received_by_name" placeholder="Nama penerima (opsional)">
                    </div>
                    
                    <div class="mb-3">
                        <label for="received_notes" class="form-label">Catatan Penerimaan</label>
                        <textarea class="form-control" id="received_notes" name="received_notes" rows="3" placeholder="Catatan tambahan (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Tandai Diterima</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Show mark received modal function
function showMarkReceivedModal(distributionId, mustahikName) {
    document.getElementById('mustahikNameModal').textContent = mustahikName;
    document.getElementById('markReceivedForm').action = `/distributions/${distributionId}/mark-received`;
    
    // Clear form fields
    document.getElementById('received_by_name').value = '';
    document.getElementById('received_notes').value = '';
    
    // Show modal
    new bootstrap.Modal(document.getElementById('markReceivedModal')).show();
}
</script>