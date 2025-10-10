@extends('layouts.main')

@section('title', $campaign->title . ' - SIPZIS')

@section('navbar')
@include('partials.navbarHome')
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-6 max-w-2xl">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('campaigns.index', $category) }}" class="inline-flex items-center text-gray-600 hover:text-gray-800 text-sm font-medium transition-colors">
                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                </svg>
                Kembali
            </a>
        </div>

        <!-- Campaign Card -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-4">
            <!-- Campaign Image -->
            <div class="relative">
                <img src="{{ $campaign->photo ? asset('storage/' . $campaign->photo) : $categoryDetails['image'] }}"
                    alt="{{ $campaign->title }}"
                    class="w-full h-64 object-cover">

                <!-- Organization Badge -->
                <!-- <div class="absolute top-4 left-4 bg-white rounded-full px-4 py-2 shadow-md flex items-center gap-2">
                    <div class="w-6 h-6 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z" />
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700">SIPZIS</span>
                </div> -->
            </div>

            <!-- Campaign Content -->
            <div class="p-5">
                <!-- Verification Badge -->
                @if($campaign->status === 'published')
                <!-- <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-green-800" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" />
                    </svg>
                    <span class="text-sm font-medium text-green-800">Campaign ini sudah terverifikasi</span>
                </div> -->
                @endif

                <!-- Title -->
                <h1 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                    {{ $campaign->title }}
                </h1>

                <!-- Subtitle/Category -->
                <p class="text-sm text-green-800 font-medium mb-4">
                    {{ $categoryDetails['title'] }}
                </p>

                <!-- Stats -->
                <div class="flex items-center gap-4 mb-4 text-sm text-gray-600">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                        <span>{{ $campaign->zakatPayments->count() }} Donatur</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                        </svg>
                        <span>{{ $campaign->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-purple-500 to-green-800 h-2 rounded-full progress-bar"
                            data-width="{{ $campaign->progress_percentage }}"></div>
                    </div>
                </div>

                <!-- Amount Info -->
                <div class="flex items-end justify-between mb-5">
                    <div>
                        <div class="text-xl font-bold text-gray-900">
                            {{ $campaign->formatted_collected_amount }}
                        </div>
                        <div class="text-sm text-gray-500">
                            terkumpul dari {{ $campaign->formatted_target_amount }}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-semibold text-gray-700">
                            {{ number_format($campaign->progress_percentage, 1) }}%
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-5">
                    <h2 class="text-base font-semibold text-gray-900 mb-2">Deskripsi Campaign</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $campaign->description }}
                    </p>
                </div>

                <!-- Donation Button -->
                <button
                    onclick="window.location.href='{{ route('guest.payment.create') }}?campaign={{ $campaign->id }}&category={{ $category }}'"
                    class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-3.5 rounded-xl font-semibold text-base shadow-md hover:shadow-lg transition-colors duration-300 hover:from-green-700 hover:to-green-800">
                    Donasikan
                </button>

            </div>
        </div>

        <!-- Recent Donations -->
        @if($campaign->zakatPayments->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h2 class="text-base font-semibold text-gray-900 mb-4">
                Donasi ({{ $campaign->zakatPayments->count() }})
            </h2>

            <div class="space-y-3">
                @foreach($campaign->zakatPayments->take(10) as $payment)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center">
                            <span class="text-green-800 font-semibold text-sm">
                                {{ substr($payment->muzakki->name, 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900 text-sm">
                                {{ $payment->muzakki->name }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $payment->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <div class="text-sm font-semibold text-gray-900">
                        Rp {{ number_format($payment->paid_amount, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set progress bar widths with animation
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            const width = bar.getAttribute('data-width');
            setTimeout(() => {
                bar.style.width = width + '%';
                bar.style.transition = 'width 1s ease-out';
            }, 100);
        });
    });
</script>
@endsection