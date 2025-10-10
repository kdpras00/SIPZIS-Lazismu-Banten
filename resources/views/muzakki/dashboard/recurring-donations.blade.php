@extends('layouts.app')

@section('page-title', 'Donasi Rutin Saya - Dashboard Muzakki')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Donasi Rutin Saya</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRecurringModal">
                <i class="bi bi-plus-circle"></i> Buat Donasi Rutin
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Fitur donasi rutin akan segera tersedia. Anda dapat mengatur donasi otomatis setiap bulan.
                </div>

                <div class="text-center py-5">
                    <i class="bi bi-arrow-repeat display-4 text-muted mb-3"></i>
                    <h4>Donasi Rutin</h4>
                    <p class="text-muted">Fitur ini memungkinkan Anda untuk membuat donasi otomatis setiap bulan.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Recurring Donation Modal -->
<div class="modal fade" id="createRecurringModal" tabindex="-1" aria-labelledby="createRecurringModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRecurringModalLabel">Buat Donasi Rutin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i> Fitur ini sedang dalam pengembangan.
                </div>
                <p>Fitur donasi rutin akan memungkinkan Anda untuk:</p>
                <ul>
                    <li>Mengatur donasi otomatis setiap bulan</li>
                    <li>Memilih program zakat yang akan didonasikan</li>
                    <li>Mengatur jumlah donasi tetap atau variabel</li>
                    <li>Mengelola jadwal donasi</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection