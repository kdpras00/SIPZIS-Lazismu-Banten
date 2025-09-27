@extends('layouts.main')

@section('title', 'Pembayaran Berhasil')

@section('navbar')
    @include('partials.navbarHome')
@endsection

@section('content')
<!-- Success Section -->
<div class="relative bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 overflow-hidden min-h-screen">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-40 h-40 bg-emerald-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
        <div class="absolute top-0 right-0 w-40 h-40 bg-teal-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-40 h-40 bg-cyan-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse animation-delay-4000"></div>
    </div>

    <div class="relative container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto">
            <!-- Success Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full mb-6 shadow-lg animate-bounce">
                    <i class="fas fa-check text-white text-4xl"></i>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-6">
                    Pembayaran Berhasil!
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Jazakallahu khairan. Zakat Anda telah berhasil diproses dan akan segera disalurkan kepada yang berhak.
                </p>
            </div>

            <!-- Payment Details Card -->
            <div class="bg-white/70 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/50 p-8 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Detail Pembayaran</h2>
                    <div class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                        <i class="fas fa-check-circle mr-1"></i>
                        {{ ucfirst($payment->status) }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Kode Pembayaran:</span>
                            <span class="font-semibold text-emerald-700">{{ $payment->payment_code }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">No. Kwitansi:</span>
                            <span class="font-semibold">{{ $payment->receipt_number }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Nama Donatur:</span>
                            <span class="font-semibold">{{ $payment->muzakki->name }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Jenis Zakat:</span>
                            <span class="font-semibold">{{ $payment->zakatType->name ?? 'Donasi Umum' }}</span>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Jumlah Zakat:</span>
                            <span class="font-semibold">Rp {{ number_format($payment->zakat_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Jumlah Dibayar:</span>
                            <span class="font-semibold text-emerald-700">Rp {{ number_format($payment->paid_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Metode Pembayaran:</span>
                            <span class="font-semibold">{{ ucfirst($payment->payment_method) }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Tanggal:</span>
                            <span class="font-semibold">{{ $payment->payment_date->format('d F Y') }}</span>
                        </div>
                    </div>
                </div>

                @if($payment->notes)
                <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                    <h4 class="font-semibold text-gray-700 mb-2">Catatan:</h4>
                    <p class="text-gray-600">{{ $payment->notes }}</p>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('guest.payment.receipt', $payment) }}" 
                   class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-8 py-4 rounded-2xl hover:from-emerald-700 hover:to-teal-700 transition-all duration-300 font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center">
                    <i class="fas fa-download mr-2"></i>
                    Unduh Kwitansi
                </a>
                
                <a href="{{ route('guest.payment.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-4 rounded-2xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Bayar Lagi
                </a>
                
                <a href="{{ route('home') }}" 
                   class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-8 py-4 rounded-2xl hover:from-gray-600 hover:to-gray-700 transition-all duration-300 font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center">
                    <i class="fas fa-home mr-2"></i>
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Islamic Quote -->
            <div class="mt-12 text-center">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl p-8 shadow-lg">
                    <div class="text-emerald-700 text-lg font-semibold mb-2">
                        "وَمَن يُؤْتَ الْحِكْمَةَ فَقَدْ أُوتِيَ خَيْرًا كَثِيرًا"
                    </div>
                    <p class="text-gray-600 italic">
                        "Dan barangsiapa yang dianugerahi hikmah, maka sungguh, dia telah dianugerahi kebaikan yang banyak"
                    </p>
                    <p class="text-sm text-gray-500 mt-2">QS. Al-Baqarah: 269</p>
                </div>
            </div>

            <!-- Guest Info -->
            <div class="mt-8 text-center">
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Informasi Penting</h3>
                    <div class="text-sm text-blue-700 space-y-1">
                        <p>• Simpan kode pembayaran <strong>{{ $payment->payment_code }}</strong> untuk referensi</p>
                        <p>• Kwitansi dapat diunduh kapan saja menggunakan link di atas</p>
                        <p>• Untuk riwayat pembayaran lengkap, silakan daftar akun di sistem</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
@endsection