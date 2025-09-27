@extends('layouts.main')

@section('title', 'Kwitansi Pembayaran')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Print Button -->
            <div class="mb-6 text-center no-print">
                <button onclick="window.print()" class="bg-emerald-600 text-white px-6 py-3 rounded-lg hover:bg-emerald-700 transition-colors">
                    <i class="fas fa-print mr-2"></i>
                    Cetak Kwitansi
                </button>
                <a href="{{ route('guest.payment.success', $payment->payment_code) }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors ml-3">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>

            <!-- Receipt -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-emerald-700 mb-2">SIPZ</h1>
                    <p class="text-gray-600">Sistem Informasi Pengelolaan Zakat, Fitrah, Shodaqoh</p>
                    <hr class="my-4 border-emerald-200">
                    <h2 class="text-2xl font-bold text-gray-800">KWITANSI PEMBAYARAN ZAKAT</h2>
                    <p class="text-sm text-gray-600 mt-2">No. {{ $payment->receipt_number }}</p>
                </div>

                <!-- Payment Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Left Column -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-300 pb-2">Informasi Pembayaran</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kode Pembayaran:</span>
                                <span class="font-semibold">{{ $payment->payment_code }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal:</span>
                                <span class="font-semibold">{{ $payment->payment_date->format('d F Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jenis Zakat:</span>
                                <span class="font-semibold">{{ $payment->zakatType->name ?? 'Donasi Umum' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Metode Pembayaran:</span>
                                <span class="font-semibold">{{ ucfirst($payment->payment_method) }}</span>
                            </div>
                            @if($payment->payment_reference)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Referensi:</span>
                                <span class="font-semibold">{{ $payment->payment_reference }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-300 pb-2">Informasi Muzakki</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama:</span>
                                <span class="font-semibold">{{ $payment->muzakki->name }}</span>
                            </div>
                            @if($payment->muzakki->email && !str_contains($payment->muzakki->email, 'guest_'))
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-semibold">{{ $payment->muzakki->email }}</span>
                            </div>
                            @endif
                            @if($payment->muzakki->phone)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Telepon:</span>
                                <span class="font-semibold">{{ $payment->muzakki->phone }}</span>
                            </div>
                            @endif
                            @if($payment->muzakki->address)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Alamat:</span>
                                <span class="font-semibold">{{ $payment->muzakki->address }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Amount Details -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Rincian Jumlah</h3>
                    <div class="space-y-3">
                        @if($payment->wealth_amount)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nilai Harta:</span>
                            <span class="font-semibold">Rp {{ number_format($payment->wealth_amount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah Zakat:</span>
                            <span class="font-semibold">Rp {{ number_format($payment->zakat_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-emerald-700 border-t border-gray-300 pt-3">
                            <span>Total Dibayar:</span>
                            <span>Rp {{ number_format($payment->paid_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                @if($payment->notes)
                <!-- Notes -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Catatan:</h3>
                    <p class="text-gray-600 bg-gray-50 p-4 rounded-lg">{{ $payment->notes }}</p>
                </div>
                @endif

                <!-- Footer -->
                <div class="text-center mt-8 pt-6 border-t border-gray-300">
                    <p class="text-sm text-gray-600 mb-2">Terima kasih atas kepercayaan Anda</p>
                    <p class="text-xs text-gray-500">
                        Kwitansi ini dicetak pada {{ now()->format('d F Y H:i') }} WIB<br>
                        SIPZ - Sistem Informasi Pengelolaan Zakat, Fitrah, Shodaqoh
                    </p>
                </div>

                <!-- Islamic Quote -->
                <div class="mt-6 text-center bg-emerald-50 p-4 rounded-lg">
                    <p class="text-emerald-700 font-semibold text-sm">
                        "خُذْ مِنْ أَمْوَالِهِمْ صَدَقَةً تُطَهِّرُهُمْ وَتُزَكِّيهِم بِهَا"
                    </p>
                    <p class="text-xs text-gray-600 mt-1 italic">
                        "Ambillah zakat dari sebagian harta mereka, dengan zakat itu kamu membersihkan dan mensucikan mereka"
                    </p>
                    <p class="text-xs text-gray-500">QS. At-Taubah: 103</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .container {
        margin: 0 !important;
        padding: 0 !important;
        max-width: 100% !important;
    }
    
    .shadow-lg {
        box-shadow: none !important;
    }
}
</style>
@endsection