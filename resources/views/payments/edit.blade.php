@extends('layouts.app')

@section('page-title', 'Edit Pembayaran')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Edit Pembayaran</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('payments.update', $payment) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="muzakki_id" class="form-control-label">Muzakki</label>
                                    <select class="form-control @error('muzakki_id') is-invalid @enderror"
                                        id="muzakki_id"
                                        name="muzakki_id"
                                        required>
                                        <option value="">Pilih Muzakki</option>
                                        @foreach($allMuzakki as $muzakki)
                                        <option value="{{ $muzakki->id }}" {{ old('muzakki_id', $payment->muzakki_id) == $muzakki->id ? 'selected' : '' }}>
                                            {{ $muzakki->name }} ({{ $muzakki->email }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('muzakki_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="payment_date" class="form-control-label">Tanggal Pembayaran</label>
                                    <input class="form-control @error('payment_date') is-invalid @enderror"
                                        type="date"
                                        id="payment_date"
                                        name="payment_date"
                                        value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}"
                                        required>
                                    @error('payment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="paid_amount" class="form-control-label">Jumlah Pembayaran (Rp)</label>
                                    <input class="form-control @error('paid_amount') is-invalid @enderror"
                                        type="number"
                                        id="paid_amount"
                                        name="paid_amount"
                                        value="{{ old('paid_amount', $payment->paid_amount) }}"
                                        min="0"
                                        step="0.01"
                                        required>
                                    @error('paid_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="payment_method" class="form-control-label">Metode Pembayaran</label>
                                    <select class="form-control @error('payment_method') is-invalid @enderror"
                                        id="payment_method"
                                        name="payment_method"
                                        required>
                                        <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>
                                            Tunai
                                        </option>
                                        <option value="transfer" {{ old('payment_method', $payment->payment_method) == 'transfer' ? 'selected' : '' }}>
                                            Transfer Bank
                                        </option>
                                        <option value="check" {{ old('payment_method', $payment->payment_method) == 'check' ? 'selected' : '' }}>
                                            Cek
                                        </option>
                                        <option value="online" {{ old('payment_method', $payment->payment_method) == 'online' ? 'selected' : '' }}>
                                            Online
                                        </option>
                                        <option value="bca_va" {{ old('payment_method', $payment->payment_method) == 'bca_va' ? 'selected' : '' }}>
                                            BCA VA
                                        </option>
                                        <option value="bri_va" {{ old('payment_method', $payment->payment_method) == 'bri_va' ? 'selected' : '' }}>
                                            BRI VA
                                        </option>
                                        <option value="bni_va" {{ old('payment_method', $payment->payment_method) == 'bni_va' ? 'selected' : '' }}>
                                            BNI VA
                                        </option>
                                        <option value="mandiri_va" {{ old('payment_method', $payment->payment_method) == 'mandiri_va' ? 'selected' : '' }}>
                                            Mandiri VA
                                        </option>
                                        <option value="permata_va" {{ old('payment_method', $payment->payment_method) == 'permata_va' ? 'selected' : '' }}>
                                            Permata VA
                                        </option>
                                        <option value="gopay" {{ old('payment_method', $payment->payment_method) == 'gopay' ? 'selected' : '' }}>
                                            GoPay
                                        </option>
                                        <option value="dana" {{ old('payment_method', $payment->payment_method) == 'dana' ? 'selected' : '' }}>
                                            DANA
                                        </option>
                                        <option value="shopeepay" {{ old('payment_method', $payment->payment_method) == 'shopeepay' ? 'selected' : '' }}>
                                            ShopeePay
                                        </option>
                                        <option value="qris" {{ old('payment_method', $payment->payment_method) == 'qris' ? 'selected' : '' }}>
                                            QRIS
                                        </option>
                                    </select>
                                    @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="payment_reference" class="form-control-label">Referensi Pembayaran</label>
                            <input class="form-control @error('payment_reference') is-invalid @enderror"
                                type="text"
                                id="payment_reference"
                                name="payment_reference"
                                value="{{ old('payment_reference', $payment->payment_reference) }}"
                                placeholder="Nomor referensi, rekening, dll.">
                            @error('payment_reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="notes" class="form-control-label">Catatan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                id="notes"
                                name="notes"
                                rows="3">{{ old('notes', $payment->notes) }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="status" class="form-control-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror"
                                id="status"
                                name="status"
                                required>
                                <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="completed" {{ old('status', $payment->status) == 'completed' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                                <option value="cancelled" {{ old('status', $payment->status) == 'cancelled' ? 'selected' : '' }}>
                                    Dibatalkan
                                </option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection