@extends('layouts.main')

@section('title', 'Program Ekonomi - SIPZIS')

@section('navbar')
@include('partials.navbarHome')
@endsection

@section('content')
<div class="relative bg-gradient-to-br from-amber-50 via-orange-50 to-red-100 min-h-screen overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-amber-600/40 via-orange-600/30 to-red-600/40"></div>
        <div class="absolute top-10 left-10 w-72 h-72 bg-amber-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-bounce animation-delay-1000"></div>
        <div class="absolute top-20 right-10 w-72 h-72 bg-orange-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-bounce animation-delay-3000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-red-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-bounce animation-delay-5000"></div>
    </div>

    <div class="relative z-10 py-20">
        <div class="container mx-auto px-4 py-16">
            <!-- Back Button -->
            <div class="mb-8">
                <a href="{{ route('program') }}" class="inline-flex items-center text-amber-700 hover:text-amber-900 font-semibold transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                    </svg>
                    Kembali ke Program
                </a>
            </div>

            <!-- Page Header -->
            <div class="text-center mb-12 relative">
                <h1 class="text-4xl md:text-6xl font-black mb-6 relative">
                    <span class="bg-gradient-to-r from-white via-amber-100 to-orange-200 bg-clip-text text-transparent drop-shadow-2xl">
                        Program Ekonomi
                    </span>
                    <div class="absolute -top-2 -right-2 w-4 h-4 bg-amber-400 rounded-full animate-pulse"></div>
                </h1>

            </div>

            <!-- Program Content -->
            <div class="relative bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 mb-12 border border-white/20">
                <div class="absolute inset-0 bg-gradient-to-r from-amber-50/50 via-orange-50/50 to-red-50/50 rounded-3xl"></div>
                <div class="relative z-10">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Program Image -->
                        <div class="lg:col-span-1">
                            <div class="rounded-2xl overflow-hidden shadow-lg">
                                <img src="{{ asset('img/program/ekonomi.jpg') }}" alt="Program Ekonomi" class="w-full h-64 object-cover">
                            </div>

                            <!-- Collected Amount Card -->
                            <div class="mt-6 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl p-6 border border-amber-200">
                                <h3 class="text-xl font-bold text-amber-800 mb-3">Dana Terkumpul</h3>
                                <div class="flex items-center justify-center">
                                    <span class="text-3xl font-bold text-amber-700">Rp {{ number_format($collectedAmount, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-center text-amber-600 mt-2">dari semua donasi program ekonomi</p>
                                <!-- Progress Bar for Program -->
                                <div class="mt-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        @php
                                        $progressPercentage = $totalTarget > 0 ? min(100, ($collectedAmount / $totalTarget) * 100) : 0;
                                        @endphp
                                        <div class="bg-gradient-to-r from-amber-500 to-orange-600 h-2.5 rounded-full progress-bar"
                                            data-width="{{ $progressPercentage }}"></div>
                                    </div>
                                    <div class="flex justify-between text-xs mt-1 text-amber-700">
                                        <span>Rp {{ number_format($collectedAmount, 0, ',', '.') }}</span>
                                        <span>Rp {{ number_format($totalTarget, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-xs mt-1 text-amber-600">
                                        <span>Dana Terkumpul</span>
                                        <span>Target Dana</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Program Description -->
                        <div class="lg:col-span-2">
                            <h2 class="text-3xl font-bold text-amber-800 mb-4">Tentang Program Ekonomi</h2>
                            <p class="text-gray-700 mb-6 text-lg leading-relaxed">
                                Program Ekonomi SIPZIS bertujuan untuk memberdayakan masyarakat secara ekonomi melalui berbagai inisiatif yang mencakup pengembangan UMKM, pelatihan keterampilan, dan penyediaan modal usaha. Kami percaya bahwa kemandirian ekonomi adalah kunci untuk mengentaskan kemiskinan.
                            </p>

                            <h3 class="text-2xl font-bold text-amber-700 mb-3">Fokus Program</h3>
                            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                                <li>Penyediaan modal usaha bagi pelaku UMKM</li>
                                <li>Pelatihan keterampilan dan pengembangan kapasitas</li>
                                <li>Pengembangan pasar dan jaringan distribusi</li>
                                <li>Pendampingan teknis pengelolaan usaha</li>
                                <li>Fasilitasi akses permodalan dan teknologi</li>
                            </ul>


                        </div>
                    </div>

                    <!-- Call to Action -->
                    <div class="mt-12 text-center">

                        <a href="{{ route('program.ekonomi.donasi') }}"
                            class="inline-flex items-center bg-gradient-to-r from-amber-600 to-orange-600 text-white px-8 py-4 rounded-xl hover:from-amber-700 hover:to-orange-700 transition-all duration-300 font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" />
                            </svg>
                            Donasi Pilar Ekonomi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Donations Section -->
            <div class="relative bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-white/20 mt-8">
                <div class="absolute inset-0 bg-gradient-to-r from-amber-50/50 via-orange-50/50 to-yellow-50/50 rounded-3xl"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-amber-800 mb-6 text-center">Donasi Terbaru</h2>

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
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 border border-amber-200 shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-center mb-3 sm:mb-0">
                                    <div class="bg-amber-100 rounded-full p-3 mr-4">
                                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-amber-800">{{ $donation->muzakki->name ?? 'Hamba Allah' }}</h3>
                                        <p class="text-amber-600 text-sm">{{ $donation->payment_date->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:items-end">
                                    <p class="text-2xl font-bold text-amber-700">Rp {{ number_format($donation->paid_amount, 0, ',', '.') }}</p>
                                    <p class="text-amber-600 text-sm">{{ $donation->payment_date->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                        </svg>
                        <h3 class="mt-4 text-xl font-medium text-amber-800">Belum Ada Donasi</h3>
                        <p class="mt-2 text-amber-600">Jadilah yang pertama berdonasi untuk program ini.</p>
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