@extends('layouts.app')

@section('page-title', 'Kwitansi Pembayaran')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Kwitansi Pembayaran Zakat</h6>
                        <div>
                            <!-- <a href="{{ route('payments.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a> -->
                            <button onclick="window.print()" class="btn btn-primary btn-sm">
                                <i class="fas fa-print"></i> Cetak
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="receipt-content">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <h4 class="fw-bold">KWITANSI PEMBAYARAN ZAKAT</h4>
                            <hr>
                        </div>

                        <!-- Receipt Info -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Nomor Kwitansi:</strong></td>
                                        <td>{{ $payment->receipt_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal:</strong></td>
                                        <td>{{ $payment->payment_date->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            @if($payment->status == 'completed')
                                            <span class="badge bg-success">Selesai</span>
                                            @elseif($payment->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                            @else
                                            <span class="badge bg-danger">Dibatalkan</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Kode Pembayaran:</strong></td>
                                        <td>{{ $payment->payment_code }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Metode Pembayaran:</strong></td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? 'Tunai')) }}</td>
                                    </tr>
                                    @if($payment->payment_reference)
                                    <tr>
                                        <td><strong>Referensi:</strong></td>
                                        <td>{{ $payment->payment_reference }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        <!-- Donor Info -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2">Informasi Donatur</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%"><strong>Nama:</strong></td>
                                    <td>{{ $payment->muzakki->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $payment->muzakki->email }}</td>
                                </tr>
                                @if($payment->muzakki->phone)
                                <tr>
                                    <td><strong>Telepon:</strong></td>
                                    <td>{{ $payment->muzakki->phone }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>

                        <!-- Payment Details -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2">Detail Pembayaran</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%"><strong>Jenis Program:</strong></td>
                                    <td>
                                        @if($payment->programType)
                                        {{ $payment->programType->name }}
                                        @else
                                        {{ ucfirst(str_replace('-', ' ', $payment->program_category ?? 'Umum')) }}
                                        @endif
                                    </td>
                                </tr>
                                @if($payment->zakatType)
                                <tr>
                                    <td><strong>Jenis Zakat:</strong></td>
                                    <td>{{ $payment->zakatType->name }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td><strong>Jumlah Pembayaran:</strong></td>
                                    <td>
                                        <h5 class="fw-bold text-success">
                                            Rp {{ number_format($payment->paid_amount, 0, ',', '.') }}
                                        </h5>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Notes -->
                        @if($payment->notes)
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2">Catatan</h6>
                            <p>{{ $payment->notes }}</p>
                        </div>
                        @endif

                        <!-- Signature -->
                        <div class="row mt-5">
                            <div class="col-md-6 text-center">
                                <p><strong>Penerima</strong></p>
                                <br><br>
                                <p>___________________________</p>
                                @if($payment->receivedBy)
                                <p>{{ $payment->receivedBy->name }}</p>
                                @endif
                            </div>
                            <div class="col-md-6 text-center">
                                <p><strong>Donatur</strong></p>
                                <br><br>
                                <p>___________________________</p>
                                <p>{{ $payment->muzakki->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }

        .receipt-content,
        .receipt-content * {
            visibility: visible;
        }

        .receipt-content {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .btn {
            display: none !important;
        }
    }
</style>
@endsection