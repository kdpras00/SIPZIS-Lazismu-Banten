@if($payments->count() > 0)
<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead class="bg-light">
            <tr>
                <th>Kode Pembayaran</th>
                @if(auth()->user()->role !== 'muzakki')
                <th>Muzakki</th>
                @endif
                <th>Jenis Zakat</th>
                <th>Jumlah Bayar</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Tanggal</th>
                <!-- Add new columns for additional information -->
                @if(auth()->user()->role !== 'muzakki')
                <th>Referensi</th>
                <th>Midtrans</th>
                @endif
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                            <i class="bi bi-credit-card text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $payment->payment_code }}</div>
                            <small class="text-muted">{{ $payment->receipt_number }}</small>
                        </div>
                    </div>
                </td>
                @if(auth()->user()->role !== 'muzakki')
                <td>
                    <div class="fw-semibold">{{ $payment->muzakki->name }}</div>
                    @if($payment->muzakki->phone)
                    <small class="text-muted">{{ $payment->muzakki->phone }}</small>
                    @endif
                </td>
                @endif
                <td>
                    <span class="badge bg-info">{{ $payment->programType ? $payment->programType->name : 'Donasi Umum' }}</span>
                </td>
                <td>
                    <div class="fw-bold">Rp {{ number_format($payment->paid_amount, 0, ',', '.') }}</div>
                    @if($payment->zakat_amount)
                    <small class="text-muted">Zakat: Rp {{ number_format($payment->zakat_amount, 0, ',', '.') }}</small>
                    @endif
                </td>
                <td>
                    @switch($payment->payment_method)
                    @case('cash')
                    <span class="badge bg-secondary">Tunai</span>
                    @break
                    @case('transfer')
                    <span class="badge bg-secondary">Transfer</span>
                    @break
                    @case('check')
                    <span class="badge bg-secondary">Cek</span>
                    @break
                    @case('online')
                    <span class="badge bg-secondary">Online</span>
                    @break
                    @case('midtrans')
                    <span class="badge bg-secondary">Midtrans</span>
                    @break
                    @default
                    <span class="badge bg-secondary">{{ ucwords($payment->payment_method) }}</span>
                    @endswitch
                </td>
                <td>
                    @switch($payment->status)
                    @case('pending')
                    <span class="badge bg-warning">Menunggu</span>
                    @break
                    @case('completed')
                    <span class="badge bg-success">Selesai</span>
                    @break
                    @case('cancelled')
                    <span class="badge bg-danger">Dibatalkan</span>
                    @break
                    @default
                    <span class="badge bg-secondary">{{ ucwords($payment->status) }}</span>
                    @endswitch
                </td>
                <td>{{ $payment->payment_date->format('d M Y') }}</td>

                <!-- Add new columns for additional information -->
                @if(auth()->user()->role !== 'muzakki')
                <td>
                    @if($payment->payment_reference)
                    <small class="font-monospace">{{ Str::limit($payment->payment_reference, 10) }}</small>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    @if($payment->midtrans_payment_method)
                    <span class="badge bg-info-subtle text-info-emphasis">
                        {{ Str::limit($payment->midtrans_payment_method, 10) }}
                    </span>
                    @elseif($payment->midtrans_order_id)
                    <span class="badge bg-primary-subtle text-primary-emphasis">Ya</span>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                @endif

                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-outline-info btn-sm" title="Lihat Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('payments.receipt', $payment) }}" class="btn btn-outline-success btn-sm" title="Kwitansi" target="_blank">
                            <i class="bi bi-receipt"></i>
                        </a>
                        @if(auth()->user()->role !== 'muzakki')
                        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($payment->status !== 'completed')
                        <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pembayaran ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($payments->hasPages())
<div class="card-footer bg-white">
    {{ $payments->withQueryString()->links() }}
</div>
@endif

@else
<div class="text-center py-4">
    <i class="bi bi-inbox display-4 text-muted mb-3 d-block"></i>
    <h5 class="text-muted">Tidak ada data pembayaran</h5>
    <p class="text-muted">
        @if(auth()->user()->role === 'muzakki')
        Belum ada pembayaran zakat yang tercatat
        @else
        Tidak ada pembayaran zakat yang sesuai dengan kriteria pencarian
        @endif
    </p>
    @if(auth()->user()->role === 'muzakki')
    <a href="{{ route('muzakki.payments.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Bayar Zakat Sekarang
    </a>
    @else
    <a href="{{ route('payments.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Pembayaran
    </a>
    @endif
</div>
@endif