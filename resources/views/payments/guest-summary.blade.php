@extends('layouts.main')

@section('title', 'Ringkasan Pembayaran - SIPZIS')

@section('content')
<div class="bg-gray-100 min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">

        {{-- Logo (opsional) --}}
        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="mx-auto h-12 mb-6">

        <h2 class="text-gray-500 text-lg font-medium">No Pembayaran</h2>
        <p class="text-2xl font-bold text-gray-800 my-2">{{ $payment->payment_code }}</p>

        <h2 class="text-gray-500 text-lg font-medium mt-6">Total Pembayaran Donasi</h2>
        <p class="text-4xl font-extrabold text-emerald-600 my-2">Rp {{ number_format($payment->paid_amount, 0, ',', '.') }}</p>
        
        {{-- Tombol Salin Nominal (opsional, jika diperlukan) --}}
        <button class="text-sm text-yellow-600 bg-yellow-100 px-3 py-1 rounded-full mt-2 hover:bg-yellow-200 transition">
            <i class="far fa-copy mr-1"></i> Salin nominal
        </button>

        <div class="mt-8">
            <button id="pay-button" class="w-full bg-orange-500 text-white font-bold py-3 px-4 rounded-lg hover:bg-orange-600 transition text-lg">
                Bayar Sekarang
            </button>
        </div>

        <div class="mt-4 text-center">
            @php
                // Menambahkan 24 jam ke waktu pembuatan pembayaran
                $expiryTime = $payment->created_at->addHours(24);
            @endphp
            <p class="text-sm text-gray-500">
                <i class="far fa-clock mr-1"></i>
                Selesaikan pembayaran sebelum {{ $expiryTime->isoFormat('dddd, D MMMM YYYY [jam] HH:mm') }}
            </p>
        </div>
        
        <div class="mt-8 border-t pt-6 space-y-3">
             <p class="text-sm text-gray-600">Bantu program **{{ $payment->zakatType->name ?? 'Donasi Umum' }}** mencapai target</p>
            <a href="#" class="block w-full bg-blue-800 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-900 transition">
                <i class="fab fa-facebook-f mr-2"></i> Share ke Facebook
            </a>
            <a href="#" class="block w-full bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 transition">
                <i class="fab fa-whatsapp mr-2"></i> Share ke WhatsApp
            </a>
            <a href="#" class="block w-full bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-400 transition">
                Konfirmasi Pembayaran (Manual)
            </a>
             <a href="{{ route('home') }}" class="block w-full bg-orange-100 text-orange-600 font-semibold py-2 px-4 rounded-lg hover:bg-orange-200 transition mt-6">
                Lihat Program Lainnya
            </a>
        </div>

    </div>
</div>

{{-- Load Midtrans Snap JS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
document.getElementById('pay-button').addEventListener('click', function () {
    const payButton = this;
    const originalButtonText = payButton.innerHTML;

    // Tampilkan status loading
    payButton.disabled = true;
    payButton.innerHTML = 'Memuat...';

    // Ambil Snap Token dari server
    fetch('{{ route("guest.payment.getToken", $payment->payment_code) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.snap_token) {
            snap.pay(data.snap_token, {
                onSuccess: function(result){
                    window.location.href = '{{ route("guest.payment.success", $payment->payment_code) }}';
                },
                onPending: function(result){
                    window.location.href = '{{ route("guest.payment.success", $payment->payment_code) }}';
                },
                onError: function(result){
                    alert('Pembayaran gagal!');
                    payButton.disabled = false;
                    payButton.innerHTML = originalButtonText;
                },
                onClose: function(){
                    // Kembalikan tombol ke keadaan semula jika pop-up ditutup
                    payButton.disabled = false;
                    payButton.innerHTML = originalButtonText;
                }
            });
        } else {
            alert('Gagal mendapatkan token pembayaran. ' + (data.message || 'Silakan coba lagi.'));
            payButton.disabled = false;
            payButton.innerHTML = originalButtonText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Tidak dapat terhubung ke server.');
        payButton.disabled = false;
        payButton.innerHTML = originalButtonText;
    });
});
</script>
@endsection