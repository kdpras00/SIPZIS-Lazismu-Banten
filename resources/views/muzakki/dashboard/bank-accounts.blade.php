@extends('layouts.app')

@section('page-title', 'Akun Bank Saya - Dashboard Muzakki')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Akun Bank Saya</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBankAccountModal">
                <i class="bi bi-plus-circle"></i> Tambah Akun Bank
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Fitur manajemen akun bank akan segera tersedia. Anda dapat menyimpan informasi rekening bank untuk memudahkan pembayaran.
                </div>

                <div class="text-center py-5">
                    <i class="bi bi-bank display-4 text-muted mb-3"></i>
                    <h4>Akun Bank</h4>
                    <p class="text-muted">Simpan informasi rekening bank Anda untuk memudahkan pembayaran zakat.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Bank Account Modal -->
<div class="modal fade" id="addBankAccountModal" tabindex="-1" aria-labelledby="addBankAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBankAccountModalLabel">Tambah Akun Bank</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i> Fitur ini sedang dalam pengembangan.
                </div>
                <p>Dengan menyimpan akun bank, Anda dapat:</p>
                <ul>
                    <li>Menggunakan rekening yang sama untuk pembayaran berikutnya</li>
                    <li>Melihat riwayat transaksi berdasarkan rekening</li>
                    <li>Mengatur rekening utama untuk pembayaran otomatis</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection