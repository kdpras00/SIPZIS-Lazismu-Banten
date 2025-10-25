@extends('layouts.app')

@section('page-title', 'Riwayat Transaksi - Dashboard Muzakki')

@section('content')
<div class="container py-3">

    <!-- Header -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ url()->previous() }}" class="text-dark me-3">
            <i class="bi bi-arrow-left fs-5"></i>
        </a>
        <h5 class="fw-semibold mb-0">Riwayat Transaksi</h5>
    </div>

    @if($payments->count() > 0)
    <div class="bg-white rounded-3 p-3 shadow-sm">

        <!-- Bulan -->
        <h6 class="fw-semibold text-purple mb-3">
            {{ now()->translatedFormat('F Y') }}
        </h6>

        <!-- Daftar Transaksi -->
        @foreach($payments as $payment)
        <div class="transaction-item p-3 mb-2 rounded-3 {{ $loop->odd ? 'bg-light' : 'bg-white' }}">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <small class="text-muted d-block">
                        Donasi • {{ $payment->payment_date->translatedFormat('d F Y') }}
                    </small>
                    <p class="fw-semibold text-dark mb-1 mt-1" style="font-size: 15px;">
                        {{ $payment->programType ? $payment->programType->name : 'Donasi Umum' }}
                    </p>
                </div>
                <div class="text-end">
                    @if($payment->status === 'completed')
                    <span class="badge rounded-pill status-success">Selesai</span>
                    @elseif($payment->status === 'pending')
                    <span class="badge rounded-pill status-pending">Menunggu Pembayaran</span>
                    @else
                    <span class="badge rounded-pill status-secondary">{{ ucfirst($payment->status) }}</span>
                    @endif
                    <p class="fw-semibold mt-2 mb-0" style="font-size: 15px;">
                        Rp {{ number_format($payment->paid_amount, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $payments->links() }}
        </div>
    </div>
    @else
    <div class="text-center py-5" style="background: transparent;">
        <i class="bi bi-credit-card display-4 text-muted mb-3"></i>
        <h4>Belum Ada Transaksi</h4>
        <p class="text-muted">Anda belum melakukan pembayaran zakat.</p>
        <a href="{{ route('program') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Bayar Zakat Sekarang
        </a>
    </div>
    @endif
</div>

<!-- Style -->
<style>
    .text-purple {
        color: #7b3fa1 !important;
    }

    .transaction-item {
        border: 1px solid #f1f1f1;
        transition: all 0.2s ease;
    }

    .transaction-item:hover {
        background-color: #faf6ff;
        border-color: #d0b3ff;
    }

    .status-pending {
        background-color: #fff3e0;
        color: #f59e0b;
        font-weight: 600;
        padding: 4px 10px;
        font-size: 12px;
    }

    .status-success {
        background-color: #e7f9ed;
        color: #22c55e;
        font-weight: 600;
        padding: 4px 10px;
        font-size: 12px;
    }

    .status-secondary {
        background-color: #e5e7eb;
        color: #6b7280;
        font-weight: 600;
        padding: 4px 10px;
        font-size: 12px;
    }
</style>
@endsection