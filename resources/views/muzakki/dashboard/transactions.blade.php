@extends('layouts.app')

@section('page-title', 'Transaksi Saya - Dashboard Muzakki')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Transaksi Saya</h2>
            <a href="{{ route('program') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Bayar Zakat Baru
            </a>
        </div>
    </div>
</div>

@if($payments->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode Pembayaran</th>
                                <th>Tanggal</th>
                                <th>Jenis Zakat</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_code }}</td>
                                <td>{{ $payment->payment_date->format('d M Y') }}</td>
                                <td>{{ $payment->programType ? $payment->programType->name : 'Donasi Umum' }}</td>
                                <td>Rp {{ number_format($payment->paid_amount, 0, ',', '.') }}</td>
                                <td>
                                    @if($payment->status === 'completed')
                                    <span class="badge bg-success">Selesai</span>
                                    @elseif($payment->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                    @else
                                    <span class="badge bg-secondary">{{ ucfirst($payment->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-credit-card display-4 text-muted mb-3"></i>
                <h4>Belum Ada Transaksi</h4>
                <p class="text-muted">Anda belum melakukan pembayaran zakat.</p>
                <a href="{{ route('payments.create') }}" class="btn btn-primary">
                    <i class="bi bi-credit-card"></i> Bayar Zakat Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection