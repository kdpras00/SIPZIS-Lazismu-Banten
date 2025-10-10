@extends('layouts.app')

@section('title', 'Pembayaran Gagal')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-danger text-white text-center">
                    <h4 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Pembayaran Gagal
                    </h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle text-danger" style="font-size: 4rem;"></i>
                    </div>

                    <h5 class="card-title mb-3">Transaksi Tidak Berhasil</h5>

                    <p class="card-text mb-4">
                        Terjadi kesalahan saat memproses pembayaran Anda. Silakan coba kembali atau gunakan metode pembayaran lain.
                    </p>

                    @if(isset($order_id))
                    <div class="alert alert-info">
                        <strong>ID Transaksi:</strong> {{ $order_id }}
                    </div>
                    @endif

                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-home me-2"></i>
                            Kembali ke Beranda
                        </a>
                        <a href="{{ route('guest.payment.summary', $order_id) }}" class="btn btn-outline-danger btn-lg">
                            <i class="fas fa-redo me-2"></i>
                            Coba Lagi
                        </a>
                    </div>
                </div>
                <div class="card-footer text-muted text-center">
                    <small>
                        Butuh bantuan? <a href="mailto:admin@yayasan.com">Hubungi Kami</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection