<div class="relative bg-gradient-to-br from-green-50 via-emerald-50 to-teal-100 min-h-screen overflow-hidden" id="program">
    <div class="absolute inset-0" style="background-size: cover; background-position: center; background-attachment: fixed; z-index: -1;" id="masjid-bg"></div>
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-green-600/40 via-emerald-600/30 to-teal-600/40"></div>
        <div class="absolute top-10 left-10 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-bounce animation-delay-1000"></div>
        <div class="absolute top-20 right-10 w-72 h-72 bg-emerald-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-bounce animation-delay-3000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-teal-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-bounce animation-delay-5000"></div>
    </div>
    
    <div class="relative z-10 py-20">
        <div class="container mx-auto px-4 py-16">
            <!-- Enhanced Page Header -->
            <div class="text-center mb-16">
                <h1 class="text-5xl md:text-6xl font-black text-white mb-6 animate-fade-in-down">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-white via-gray-100 to-gray-200">
                        Program Pilar
                    </span>
                </h1>
                <div class="flex justify-center">
                    <div class="w-24 h-1 bg-gradient-to-r from-white via-gray-100 to-gray-200 rounded-full"></div>
                </div>
              
            </div>

            <!-- Enhanced Main Programs -->
            <div class="relative bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-10 mb-12 border border-white/20">
                <div class="absolute inset-0 bg-gradient-to-r from-green-50/50 via-emerald-50/50 to-teal-50/50 rounded-3xl"></div>
                <div class="relative z-10">

                    <!-- Updated Program Categories -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Pendidikan Category -->
                        <div class="group relative bg-gradient-to-br from-blue-50 to-indigo-100 rounded-3xl shadow-xl p-8 hover:shadow-2xl hover:scale-105 transition-all duration-500 border border-blue-200/50">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-400/20 to-indigo-500/20 rounded-full -mt-10 -mr-10 group-hover:scale-150 transition-transform duration-500"></div>
                            <div class="relative z-10">
                                <a href="{{ route('program.pendidikan') }}" class="block">
                                    <div class="flex items-center mb-6">
                                        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl p-4 mr-4 shadow-lg group-hover:shadow-blue-500/30 transition-all duration-300">
                                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3L1 9l11 6 9-5.01L12 3z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-black text-blue-800 mb-1">Pendidikan</h3>
                                            <div class="w-12 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full"></div>
                                        </div>
                                    </div>
                                    <p class="text-blue-700 mb-6">Program peningkatan kualitas pendidikan melalui beasiswa, pembangunan sekolah, dan fasilitas pendidikan lainnya.</p>
                                </a>
                                <!-- Payment Button -->
                                <div class="mt-6 text-center">
                                    <a href="{{ route('program.pendidikan.donasi') }}" 
                                       class="inline-flex items-center bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
                                        </svg>
                                        Donasi Pendidikan
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Kesehatan Category -->
                        <div class="group relative bg-gradient-to-br from-green-50 to-emerald-100 rounded-3xl shadow-xl p-8 hover:shadow-2xl hover:scale-105 transition-all duration-500 border border-green-200/50">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-400/20 to-emerald-500/20 rounded-full -mt-10 -mr-10 group-hover:scale-150 transition-transform duration-500"></div>
                            <div class="relative z-10">
                                <a href="{{ route('program.kesehatan') }}" class="block">
                                    <div class="flex items-center mb-6">
                                        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl p-4 mr-4 shadow-lg group-hover:shadow-green-500/30 transition-all duration-300">
                                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-black text-green-800 mb-1">Kesehatan</h3>
                                            <div class="w-12 h-1 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full"></div>
                                        </div>
                                    </div>
                                    <p class="text-green-700 mb-6">Program peningkatan kesehatan masyarakat melalui pembangunan klinik, penyediaan obat, dan layanan kesehatan.</p>
                                </a>
                                <!-- Payment Button -->
                                <div class="mt-6 text-center">
                                    <a href="{{ route('program.kesehatan.donasi') }}" 
                                       class="inline-flex items-center bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-3 rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
                                        </svg>
                                        Donasi Kesehatan
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Ekonomi Category -->
                        <div class="group relative bg-gradient-to-br from-amber-50 to-orange-100 rounded-3xl shadow-xl p-8 hover:shadow-2xl hover:scale-105 transition-all duration-500 border border-amber-200/50">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-amber-400/20 to-orange-500/20 rounded-full -mt-10 -mr-10 group-hover:scale-150 transition-transform duration-500"></div>
                            <div class="relative z-10">
                                <a href="{{ route('program.ekonomi') }}" class="block">
                                    <div class="flex items-center mb-6">
                                        <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl p-4 mr-4 shadow-lg group-hover:shadow-amber-500/30 transition-all duration-300">
                                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-black text-amber-800 mb-1">Ekonomi</h3>
                                            <div class="w-12 h-1 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full"></div>
                                        </div>
                                    </div>
                                    <p class="text-amber-700 mb-6">Program pemberdayaan ekonomi masyarakat melalui modal usaha, pelatihan keterampilan, dan pengembangan UMKM.</p>
                                </a>
                                <!-- Payment Button -->
                                <div class="mt-6 text-center">
                                    <a href="{{ route('program.ekonomi.donasi') }}" 
                                       class="inline-flex items-center bg-gradient-to-r from-amber-600 to-orange-600 text-white px-6 py-3 rounded-xl hover:from-amber-700 hover:to-orange-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                                        </svg>
                                        Donasi Ekonomi
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Sosial Dakwah Category -->
                        <div class="group relative bg-gradient-to-br from-purple-50 to-violet-100 rounded-3xl shadow-xl p-8 hover:shadow-2xl hover:scale-105 transition-all duration-500 border border-purple-200/50">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-400/20 to-violet-500/20 rounded-full -mt-10 -mr-10 group-hover:scale-150 transition-transform duration-500"></div>
                            <div class="relative z-10">
                                <a href="{{ route('program.sosial-dakwah') }}" class="block">
                                    <div class="flex items-center mb-6">
                                        <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl p-4 mr-4 shadow-lg group-hover:shadow-purple-500/30 transition-all duration-300">
                                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-black text-purple-800 mb-1">Sosial Dakwah</h3>
                                            <div class="w-12 h-1 bg-gradient-to-r from-purple-500 to-violet-500 rounded-full"></div>
                                        </div>
                                    </div>
                                    <p class="text-purple-700 mb-6">Program penyebaran dakwah dan penguatan nilai-nilai sosial keislaman melalui berbagai kegiatan sosial dan keagamaan.</p>
                                </a>
                                <!-- Payment Button -->
                                <div class="mt-6 text-center">
                                    <a href="{{ route('program.sosial-dakwah.donasi') }}" 
                                       class="inline-flex items-center bg-gradient-to-r from-purple-600 to-violet-600 text-white px-6 py-3 rounded-xl hover:from-purple-700 hover:to-violet-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                                        </svg>
                                        Donasi Sosial Dakwah
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Kemanusiaan Category -->
                        <div class="group relative bg-gradient-to-br from-red-50 to-pink-100 rounded-3xl shadow-xl p-8 hover:shadow-2xl hover:scale-105 transition-all duration-500 border border-red-200/50">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-red-400/20 to-pink-500/20 rounded-full -mt-10 -mr-10 group-hover:scale-150 transition-transform duration-500"></div>
                            <div class="relative z-10">
                                <a href="{{ route('program.kemanusiaan') }}" class="block">
                                    <div class="flex items-center mb-6">
                                        <div class="bg-gradient-to-br from-red-500 to-red-700 rounded-2xl p-4 mr-4 shadow-lg group-hover:shadow-red-500/30 transition-all duration-300">
                                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-black text-red-800 mb-1">Kemanusiaan</h3>
                                            <div class="w-12 h-1 bg-gradient-to-r from-red-500 to-pink-500 rounded-full"></div>
                                        </div>
                                    </div>
                                    <p class="text-red-700 mb-6">Program bantuan kemanusiaan untuk korban bencana, musibah, dan kelompok masyarakat yang membutuhkan.</p>
                                </a>
                                <!-- Payment Button -->
                                <div class="mt-6 text-center">
                                    <a href="{{ route('program.kemanusiaan.donasi') }}" 
                                       class="inline-flex items-center bg-gradient-to-r from-red-600 to-pink-600 text-white px-6 py-3 rounded-xl hover:from-red-700 hover:to-pink-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                        Donasi Kemanusiaan
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Lingkungan Category -->
                        <div class="group relative bg-gradient-to-br from-teal-50 to-cyan-100 rounded-3xl shadow-xl p-8 hover:shadow-2xl hover:scale-105 transition-all duration-500 border border-teal-200/50">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-teal-400/20 to-cyan-500/20 rounded-full -mt-10 -mr-10 group-hover:scale-150 transition-transform duration-500"></div>
                            <div class="relative z-10">
                                <a href="{{ route('program.lingkungan') }}" class="block">
                                    <div class="flex items-center mb-6">
                                        <div class="bg-gradient-to-br from-teal-500 to-teal-700 rounded-2xl p-4 mr-4 shadow-lg group-hover:shadow-teal-500/30 transition-all duration-300">
                                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-black text-teal-800 mb-1">Lingkungan</h3>
                                            <div class="w-12 h-1 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-full"></div>
                                        </div>
                                    </div>
                                    <p class="text-teal-700 mb-6">Program pelestarian lingkungan hidup melalui penghijauan, pengelolaan sampah, dan kegiatan ramah lingkungan lainnya.</p>
                                </a>
                                <!-- Payment Button -->
                                <div class="mt-6 text-center">
                                    <a href="{{ route('program.lingkungan.donasi') }}" 
                                       class="inline-flex items-center bg-gradient-to-r from-teal-600 to-cyan-600 text-white px-6 py-3 rounded-xl hover:from-teal-700 hover:to-cyan-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        Donasi Lingkungan
                                    </a>
                                </div>
                            </div>
                        </div>
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

.animate-blob {
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

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

.hover\:shadow-3xl:hover {
    box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
}

@keyframes fade-in-down {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-down {
    animation: fade-in-down 0.5s ease-out forwards;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set the background image using JavaScript to avoid CSS linter issues
    const masjidBg = document.getElementById('masjid-bg');
    if (masjidBg) {
        masjidBg.style.backgroundImage = "url('{{ asset('img/masjid.webp') }}')";
    }
});
</script>