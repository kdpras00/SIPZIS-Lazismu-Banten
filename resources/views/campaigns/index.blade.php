@extends('layouts.main')

@section('title', 'Campaigns - SIPZIS')

@section('navbar')
@include('partials.navbarHome')
@endsection

@section('content')
<div class="relative bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 min-h-screen overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/40 via-indigo-600/30 to-purple-600/40"></div>
        <div class="absolute top-10 left-10 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-bounce animation-delay-1000"></div>
        <div class="absolute top-20 right-10 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-bounce animation-delay-3000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-bounce animation-delay-5000"></div>
    </div>

    <div class="relative z-10 py-20">
        <div class="container mx-auto px-4 py-16">
            <!-- Back Button -->
            <div class="mb-8">
                <a href="{{ route('program') }}" class="inline-flex items-center text-blue-700 hover:text-blue-900 font-semibold transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                    </svg>
                    Kembali ke Program
                </a>
            </div>

            <!-- Page Header -->
            <div class="text-center mb-12 relative">
                <h1 class="text-4xl md:text-6xl font-black mb-6 relative">
                    <span class="bg-gradient-to-r from-white via-blue-100 to-indigo-200 bg-clip-text text-transparent drop-shadow-2xl">
                        Campaign {{ $categoryDetails['title'] }}
                    </span>
                    <div class="absolute -top-2 -right-2 w-4 h-4 bg-blue-400 rounded-full animate-pulse"></div>
                </h1>
                <p class="text-xl text-blue-800 max-w-2xl mx-auto">
                    {{ $categoryDetails['subtitle'] }}
                </p>
            </div>

            <!-- Campaigns List -->
            <div class="relative">
                @if($campaigns->isEmpty())
                <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 mb-12 border border-white/20 text-center">
                    <div class="text-5xl mb-4">😢</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak Ada Campaign</h3>
                    <p class="text-gray-600">Belum ada campaign yang tersedia untuk kategori ini.</p>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($campaigns as $campaign)
                    <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden border border-white/20 transition-all duration-300 hover:shadow-3xl hover:-translate-y-1">
                        <!-- Campaign Image -->
                        <div class="h-48 overflow-hidden">
                            <img src="{{ $campaign->photo ? asset('storage/' . $campaign->photo) : $categoryDetails['image'] }}"
                                alt="{{ $campaign->title }}"
                                class="w-full h-full object-cover">
                        </div>

                        <!-- Campaign Content -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold {{ $categoryDetails['text_color'] }} mb-3 line-clamp-2">
                                {{ $campaign->title }}
                            </h3>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ Str::limit($campaign->description, 100) }}
                            </p>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-semibold {{ $categoryDetails['text_color'] }}">
                                        {{ number_format($campaign->progress_percentage, 1) }}%
                                    </span>
                                    <span class="text-gray-500">
                                        {{ $campaign->formatted_collected_amount }} / {{ $campaign->formatted_target_amount }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2.5 rounded-full"
                                        style="width: {{ $campaign->progress_percentage }}%"></div>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="text-center">
                                <a href="{{ route('campaigns.show', [$category, $campaign]) }}"
                                    class="inline-block w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-2 px-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-semibold text-sm shadow-lg hover:shadow-xl">
                                    Donasi Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

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

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection