<div class="relative bg-gradient-to-br from-green-900 via-green-800 to-emerald-700 min-h-screen flex items-center justify-center overflow-hidden" id="beranda">
    <!-- Mosque Background Image Overlay -->
<div class="absolute inset-0 opacity-90" style="background-image: url('{{ asset("img/masjid.webp") }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
    <!-- Green Gradient Overlay for blending -->
    <div class="absolute inset-0 bg-gradient-to-br from-green-900/80 via-green-800/70 to-emerald-700/80"></div>
    
    <!-- Additional Dark Overlay for text readability -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-black/20"></div>
    
    <!-- Main Content -->
    <div class="relative max-w-6xl mx-auto px-4 py-20 md:py-32 text-center text-white z-10">
     
        <!-- Main Heading -->
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-8 leading-tight animate-fadeInUp">
            <span class="bg-gradient-to-r from-white via-green-100 to-white bg-clip-text text-transparent">
                "Dan laksanakanlah salat, tunaikanlah zakat, dan rukuklah beserta orang yang rukuk."
            </span>
        </h1>
        
        <!-- Subtitle -->
        <p class="text-2xl md:text-3xl font-light mb-4 text-green-100 animate-fadeInUp delay-500">
            (QS. Al-Baqarah: 43)
        </p>
        
        <!-- Description -->
        <p class="text-lg md:text-xl max-w-3xl mx-auto mb-12 text-green-100 leading-relaxed animate-fadeInUp delay-700">
            Tunaikan kewajiban zakat Anda dengan mudah, transparan, dan sesuai syariat Islam melalui platform digital yang terpercaya.
        </p>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fadeInUp delay-1000">
            <a href="{{ route('calculator.index') }}"
                class="group bg-white hover:bg-green-600 text-green-800 hover:text-white font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl flex items-center gap-3 min-w-[250px]">                <svg class="w-6 h-6 transition-transform group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M7 2h10a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm0 2v16h10V4H7zm2 2h6v2H9V6zm0 4h6v2H9v-2zm0 4h6v2H9v-2z"/>
                </svg>
                <span class="font-semibold tracking-wide">KALKULATOR ZAKAT</span>
            </a>
            <a href="{{ route('guest.payment.create') }}"
                class="group bg-white hover:bg-green-600 text-green-800 hover:text-white font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl flex items-center gap-3 min-w-[250px]">
                <svg class="w-6 h-6 transition-transform group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L3.09 8.26L12 22L20.91 8.26L12 2Z"/>
                </svg>
                <span class="font-semibold tracking-wide">BAYAR ZAKAT SEKARANG</span>
            </a>
        </div>
        
      
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</div>

<!-- Custom CSS for Animations -->
<style>
    @keyframes fadeInDown {
        0% {
            opacity: 0;
            transform: translateY(-30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fadeInDown {
        animation: fadeInDown 1s ease-out;
    }
    
    .animate-fadeInUp {
        animation: fadeInUp 1s ease-out;
    }
    
    .delay-500 {
        animation-delay: 0.5s;
        animation-fill-mode: both;
    }
    
    .delay-700 {
        animation-delay: 0.7s;
        animation-fill-mode: both;
    }
    
    .delay-1000 {
        animation-delay: 1s;
        animation-fill-mode: both;
    }
    
    .delay-1200 {
        animation-delay: 1.2s;
        animation-fill-mode: both;
    }
    
    .delay-2000 {
        animation-delay: 2s;
    }
    
    .delay-3000 {
        animation-delay: 3s;
    }
    
    /* Gradient text effect */
    .bg-clip-text {
        background-clip: text;
        -webkit-background-clip: text;
    }
    
    /* Glass morphism effect */
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
    }
</style>