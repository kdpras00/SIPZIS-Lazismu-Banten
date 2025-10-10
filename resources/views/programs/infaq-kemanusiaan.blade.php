@extends('layouts.main')

@section('title', 'Infaq Kemanusiaan - SIPZIS')

@section('navbar')
@include('partials.navbarHome')
@endsection

@section('content')
<div class="relative bg-gradient-to-br from-red-50 via-pink-50 to-rose-100 min-h-screen overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-red-600/40 via-pink-600/30 to-rose-600/40"></div>
        <div class="absolute top-10 left-10 w-72 h-72 bg-red-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-bounce animation-delay-1000"></div>
        <div class="absolute top-20 right-10 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-bounce animation-delay-3000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-rose-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-bounce animation-delay-5000"></div>
    </div>

    <div class="relative z-10 py-20">
        <div class="container mx-auto px-4 py-16">
            <!-- Back Button -->
            <div class="mb-8">
                <a href="{{ route('program') }}" class="inline-flex items-center text-red-700 hover:text-red-900 font-semibold transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                    </svg>
                    Kembali ke Program
                </a>
            </div>

            <!-- Page Header -->
            <div class="text-center mb-12 relative">
                <h1 class="text-4xl md:text-6xl font-black mb-6 relative">
                    <span class="bg-gradient-to-r from-white via-red-100 to-pink-200 bg-clip-text text-transparent drop-shadow-2xl">
                        Infaq Kemanusiaan
                    </span>
                    <div class="absolute -top-2 -right-2 w-4 h-4 bg-red-400 rounded-full animate-pulse"></div>
                </h1>
                <p class="text-xl text-red-800 max-w-2xl mx-auto">
                    Bantuan untuk korban bencana, musibah, dan kelompok masyarakat yang membutuhkan
                </p>
            </div>

            <!-- Program Content -->
            <div class="relative bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 mb-12 border border-white/20">
                <div class="absolute inset-0 bg-gradient-to-r from-red-50/50 via-pink-50/50 to-rose-50/50 rounded-3xl"></div>
                <div class="relative z-10">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Program Image -->
                        <div class="lg:col-span-1">
                            <div class="rounded-2xl overflow-hidden shadow-lg">
                                <img src="{{ asset('img/program/infaq-kemanusiaan.jpg') }}" alt="Infaq Kemanusiaan" class="w-full h-64 object-cover">
                            </div>

                            <!-- Collected Amount Card -->
                            <div class="mt-6 bg-gradient-to-br from-red-100 to-pink-100 rounded-2xl p-6 border border-red-200">
                                <h3 class="text-xl font-bold text-red-800 mb-3">Dana Terkumpul</h3>
                                <div class="flex items-center justify-center">
                                    <span class="text-3xl font-bold text-red-700">Rp {{ number_format($collectedAmount, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-center text-red-600 mt-2">dari semua campaign infaq kemanusiaan</p>
                                <!-- Progress Bar for Program -->
                                <div class="mt-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        @php
                                        $progressPercentage = $totalTarget > 0 ? min(100, ($collectedAmount / $totalTarget) * 100) : 0;
                                        @endphp
                                        <div class="bg-gradient-to-r from-red-500 to-pink-600 h-2.5 rounded-full progress-bar"
                                            data-width="{{ $progressPercentage }}"></div>
                                    </div>
                                    <div class="flex justify-between text-xs mt-1 text-red-700">
                                        <span>{{ number_format($collectedAmount, 0, ',', '.') }}</span>
                                        <span>{{ number_format($totalTarget, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <!-- Button to view campaigns -->
                                <div class="mt-4 text-center">
                                    <a href="{{ route('campaigns.index', $category) }}"
                                        class="inline-block bg-gradient-to-r from-red-600 to-pink-600 text-white px-4 py-2 rounded-lg hover:from-red-700 hover:to-pink-700 transition-all duration-300 font-semibold text-sm shadow-lg">
                                        Lihat Campaign
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Program Description -->
                        <div class="lg:col-span-2">
                            <h2 class="text-3xl font-bold text-red-800 mb-4">Tentang Infaq Kemanusiaan</h2>
                            <p class="text-gray-700 mb-6 text-lg leading-relaxed">
                                Infaq Kemanusiaan adalah bentuk sedekah yang diberikan untuk membantu sesama yang tertimpa musibah, bencana alam, konflik, atau kesulitan hidup lainnya. Infaq ini merupakan manifestasi dari nilai-nilai kemanusiaan dan kepedulian sosial terhadap sesama tanpa memandang latar belakang.
                            </p>

                            <h3 class="text-2xl font-bold text-red-700 mb-3">Cakupan Infaq Kemanusiaan</h3>
                            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                                <li>Bantuan darurat untuk korban bencana alam</li>
                                <li>Bantuan untuk korban konflik dan pengungsi</li>
                                <li>Bantuan kemanusiaan untuk kelompok rentan</li>
                                <li>Bantuan kesehatan dan medis</li>
                                <li>Bantuan pangan dan kebutuhan dasar</li>
                            </ul>

                            <div class="bg-red-50 rounded-xl p-4 mb-6">
                                <h3 class="text-lg font-bold text-red-800 mb-2">Dana akan digunakan untuk:</h3>
                                <ul class="space-y-1 text-red-700">
                                    <li class="flex items-start">
                                        <span class="text-red-500 mr-2">•</span>
                                        <span>Bantuan darurat untuk korban bencana</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-red-500 mr-2">•</span>
                                        <span>Bantuan kemanusiaan untuk kelompok rentan</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-red-500 mr-2">•</span>
                                        <span>Bantuan pangan dan kebutuhan dasar</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Call to Action -->
                            <div class="text-center mt-8">
                                <a href="{{ route('guest.payment.create', ['category' => 'infaq-kemanusiaan', 'amount' => 40000]) }}"
                                    class="inline-flex items-center bg-gradient-to-r from-red-600 to-pink-600 text-white px-8 py-4 rounded-xl hover:from-red-700 hover:to-pink-700 transition-all duration-300 font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" />
                                    </svg>
                                    Donasi Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Donations Section -->
            <div class="relative bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-white/20">
                <div class="absolute inset-0 bg-gradient-to-r from-red-50/50 via-pink-50/50 to-rose-50/50 rounded-3xl"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-red-800 mb-6 text-center">Donasi Terbaru</h2>

                    @php
                    // Get recent donations for this program category
                    $recentDonations = \App\Models\ZakatPayment::where('program_category', $category)
                    ->where('status', 'completed')
                    ->latest('payment_date')
                    ->limit(10)
                    ->get();
                    @endphp

                    @if($recentDonations->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentDonations as $donation)
                        <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl p-6 border border-red-200 shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-center mb-3 sm:mb-0">
                                    <div class="bg-red-100 rounded-full p-3 mr-4">
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-red-800">{{ $donation->muzakki->name ?? 'Hamba Allah' }}</h3>
                                        <p class="text-red-600 text-sm">{{ $donation->payment_date->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:items-end">
                                    <p class="text-2xl font-bold text-red-700">Rp {{ number_format($donation->paid_amount, 0, ',', '.') }}</p>
                                    <p class="text-red-600 text-sm">{{ $donation->payment_date->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                        </svg>
                        <h3 class="mt-4 text-xl font-medium text-red-800">Belum Ada Donasi</h3>
                        <p class="mt-2 text-red-600">Jadilah yang pertama berdonasi untuk program ini.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set the width of progress bars
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(function(bar) {
            const width = bar.getAttribute('data-width');
            bar.style.width = width + '%';
        });
    });
</script>

<style>
    @keyframes blob {
        0% {
            transform: translate(0px, 0px) scale(1);
        }

        33% {
            transform: translate(30px, -50px) scale(1.1);
        }

        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }

        100% {
            transform: translate(0px, 0px) scale(1);
        }
    }

    .animate-bounce {
        animation: blob 7s infinite;
    }

    .animation-delay-1000 {
        animation-delay: 1s;
    }

    .animation-delay-3000 {
        animation-delay: 3s;
    }

    .animation-delay-5000 {
        animation-delay: 5s;
    }
</style>
@endsection