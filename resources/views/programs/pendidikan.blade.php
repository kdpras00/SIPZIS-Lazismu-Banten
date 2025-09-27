@extends('layouts.main')

@section('title', 'Program Pendidikan - SIPZIS')

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
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                    </svg>
                    Kembali ke Program
                </a>
            </div>

            <!-- Page Header -->
            <div class="text-center mb-12 relative">
                <h1 class="text-4xl md:text-6xl font-black mb-6 relative">
                    <span class="bg-gradient-to-r from-white via-blue-100 to-indigo-200 bg-clip-text text-transparent drop-shadow-2xl">
                        Program Pendidikan
                    </span>
                    <div class="absolute -top-2 -right-2 w-4 h-4 bg-blue-400 rounded-full animate-pulse"></div>
                </h1>
               
            </div>

            <!-- Program Content -->
            <div class="relative bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 mb-12 border border-white/20">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-50/50 via-indigo-50/50 to-purple-50/50 rounded-3xl"></div>
                <div class="relative z-10">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Program Image -->
                        <div class="lg:col-span-1">
                            <div class="rounded-2xl overflow-hidden shadow-lg">
                                <img src="{{ asset('img/program/pendidikan.jpg') }}" alt="Program Pendidikan" class="w-full h-64 object-cover">
                            </div>
                        </div>
                        
                        <!-- Program Description -->
                        <div class="lg:col-span-2">
                            <h2 class="text-3xl font-bold text-blue-800 mb-4">Tentang Program Pendidikan</h2>
                            <p class="text-gray-700 mb-6 text-lg leading-relaxed">
                                Program Pendidikan SIPZIS bertujuan untuk meningkatkan kualitas pendidikan melalui berbagai inisiatif yang mencakup beasiswa, pembangunan sekolah, dan fasilitas pendidikan lainnya. Kami percaya bahwa pendidikan adalah kunci untuk membangun masa depan yang lebih baik.
                            </p>
                            
                            <h3 class="text-2xl font-bold text-blue-700 mb-3">Fokus Program</h3>
                            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                                <li>Beasiswa bagi pelajar kurang mampu</li>
                                <li>Pembangunan dan renovasi fasilitas sekolah</li>
                                <li>Penyediaan alat peraga dan buku pelajaran</li>
                                <li>Pelatihan guru dan tenaga pendidik</li>
                                <li>Program literasi dan pengembangan keterampilan</li>
                            </ul>
                            
                          
                        </div>
                    </div>
                    
                    <!-- Call to Action -->
                    <div class="mt-12 text-center">
                    
                        <a href="{{ route('program.pendidikan.donasi') }}" 
                           class="inline-flex items-center bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
                            </svg>
                            Donasi Pilar Pendidikan
                        </a>
                    </div>
                </div>
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
</style>
@endsection