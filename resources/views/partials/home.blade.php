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
                class="group bg-white hover:bg-green-600 text-green-800 hover:text-white font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl flex items-center gap-3 min-w-[250px]"> <svg class="w-6 h-6 transition-transform group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M7 2h10a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm0 2v16h10V4H7zm2 2h6v2H9V6zm0 4h6v2H9v-2zm0 4h6v2H9v-2z" />
                </svg>
                <span class="font-semibold tracking-wide">KALKULATOR ZAKAT</span>
            </a>
            <a href="{{ route('guest.payment.create') }}"
                class="group bg-white hover:bg-green-600 text-green-800 hover:text-white font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl flex items-center gap-3 min-w-[250px]">
                <svg class="w-6 h-6 transition-transform group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L3.09 8.26L12 22L20.91 8.26L12 2Z" />
                </svg>
                <span class="font-semibold tracking-wide">BAYAR ZAKAT SEKARANG</span>
            </a>
        </div>


    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
    </div>
</div>

<!-- Campaigns Terbaru Section -->
<div class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12 animate-fadeInUp">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Campaigns Terbaru</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Temukan campaign zakat, infaq, dan sedekah terbaru yang sedang berjalan</p>
        </div>

        <!-- Slider Container -->
        <div class="relative">
            <!-- Navigation Buttons -->
            <button id="campaigns-prev" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-green-600 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button id="campaigns-next" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-green-600 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Slider Wrapper -->
            <div class="group">
                <div id="campaigns-slider" class="flex overflow-x-auto snap-x snap-mandatory gap-4 pb-4 scrollbar-hide">
                    @foreach(\App\Models\Campaign::published()->latest()->take(10)->get() as $campaign)
                    <div class="flex-shrink-0 w-72 snap-start">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 animate-fadeInUp h-full flex flex-col">
                            @if($campaign->photo)
                            <div class="h-40 overflow-hidden">
                                @php
                                $rawImage = trim($campaign->photo ?? '');
                                // Cek apakah image adalah URL penuh (CDN)
                                $isFullUrl = filter_var($rawImage, FILTER_VALIDATE_URL);
                                // Tentukan URL akhir
                                $imageUrl = $isFullUrl
                                ? $rawImage
                                : asset('storage/' . $campaign->photo);
                                @endphp
                                <img src="{{ $imageUrl }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                            </div>
                            @else
                            <div class="h-40 bg-gray-200 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="text-base font-bold text-gray-800 mb-1 line-clamp-2 flex-grow-0">{{ $campaign->title }}</h3>
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2 flex-grow">{{ Str::limit(strip_tags($campaign->description), 80) }}</p>

                                <!-- Progress Bar -->
                                <div class="mb-3 flex-grow-0">
                                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                                        <span>Terkumpul</span>
                                        <span>{{ 'Rp ' . number_format($campaign->collected_amount, 0, ',', '.') }}</span>
                                    </div>
                                    @php
                                    $progress = $campaign->progress_percentage;
                                    if ($progress > 100) $progress = 100;
                                    @endphp
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: <?php echo number_format($progress, 0); ?>%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-600 mt-1">
                                        <span>Target: {{ 'Rp ' . number_format($campaign->target_amount, 0, ',', '.') }}</span>
                                        <span>{{ number_format($campaign->progress_percentage, 1) }}%</span>
                                    </div>
                                </div>

                                <a href="{{ route('campaigns.show', [$campaign->program_category, $campaign]) }}"
                                    class="inline-block w-full text-center bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-1.5 px-3 rounded-lg transition-colors duration-300 flex-grow-0">
                                    Lihat Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('campaigns.index', 'all') }}"
                class="inline-block bg-white border-2 border-green-600 text-green-600 hover:bg-green-600 hover:text-white font-bold py-2.5 px-6 rounded-full transition-all duration-300 transform hover:scale-105 text-sm">
                Lihat Semua Campaign
            </a>
        </div>
    </div>
</div>

<!-- Berita Terbaru Section -->
<div class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12 animate-fadeInUp">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Berita Terbaru</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Ikuti perkembangan terbaru tentang kegiatan zakat dan program sosial</p>
        </div>

        <!-- Slider Container -->
        <div class="relative">
            <!-- Navigation Buttons -->
            <button id="news-prev" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-green-600 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button id="news-next" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-green-600 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Slider Wrapper -->
            <div class="group">
                <div id="news-slider" class="flex overflow-x-auto snap-x snap-mandatory gap-4 pb-4 scrollbar-hide">
                    @foreach(\App\Models\News::published()->latest()->take(10)->get() as $news)
                    <div class="flex-shrink-0 w-72 snap-start">
                        <div class="bg-gray-50 rounded-lg shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 animate-fadeInUp">
                            @if($news->image)
                            <div class="h-40 overflow-hidden">
                                @php
                                $rawImage = trim($news->image ?? '');
                                // Cek apakah image adalah URL penuh (CDN)
                                $isFullUrl = filter_var($rawImage, FILTER_VALIDATE_URL);
                                // Tentukan URL akhir
                                $imageUrl = $isFullUrl
                                ? $rawImage
                                : asset('storage/' . $news->image);
                                @endphp
                                <img src="{{ $imageUrl }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                            </div>
                            @else
                            <div class="h-40 bg-gray-200 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </div>
                            @endif
                            <div class="p-4">
                                <div class="flex items-center text-xs text-gray-500 mb-1.5">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $news->created_at->format('d M Y') }}</span>
                                </div>
                                <h3 class="text-base font-bold text-gray-800 mb-2 line-clamp-2">{{ $news->title }}</h3>
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $news->excerpt }}</p>
                                <a href="{{ route('news.show', $news->slug) }}"
                                    class="text-green-600 hover:text-green-700 font-medium text-sm flex items-center">
                                    Baca Selengkapnya
                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('news.all') }}"
                class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-full transition-all duration-300 transform hover:scale-105 text-sm">
                Lihat Semua Berita
            </a>
        </div>
    </div>
</div>

<!-- Artikel Terbaru Section -->
<div class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12 animate-fadeInUp">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Artikel Terbaru</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Temukan artikel edukasi tentang zakat, infaq, dan sedekah</p>
        </div>

        <!-- Slider Container -->
        <div class="relative">
            <!-- Navigation Buttons -->
            <button id="artikel-prev" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-green-600 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button id="artikel-next" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-green-600 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Slider Wrapper -->
            <div class="group">
                <div id="artikel-slider" class="flex overflow-x-auto snap-x snap-mandatory gap-4 pb-4 scrollbar-hide">
                    @foreach(\App\Models\Artikel::published()->latest()->take(10)->get() as $artikel)
                    <div class="flex-shrink-0 w-72 snap-start">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 animate-fadeInUp">
                            @if($artikel->image)
                            <div class="h-40 overflow-hidden">
                                @php
                                $rawImage = trim($artikel->image ?? '');
                                // Cek apakah image adalah URL penuh (CDN)
                                $isFullUrl = filter_var($rawImage, FILTER_VALIDATE_URL);
                                // Tentukan URL akhir
                                $imageUrl = $isFullUrl
                                ? $rawImage
                                : asset('storage/' . $artikel->image);
                                @endphp
                                <img src="{{ $imageUrl }}" alt="{{ $artikel->title }}" class="w-full h-full object-cover">
                            </div>
                            @else
                            <div class="h-40 bg-gray-200 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </div>
                            @endif
                            <div class="p-4">
                                <div class="flex items-center text-xs text-gray-500 mb-1.5">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $artikel->created_at->format('d M Y') }}</span>
                                </div>
                                <h3 class="text-base font-bold text-gray-800 mb-2 line-clamp-2">{{ $artikel->title }}</h3>
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $artikel->excerpt }}</p>
                                <a href="{{ route('artikel.show', $artikel->slug) }}"
                                    class="text-green-600 hover:text-green-700 font-medium text-sm flex items-center">
                                    Baca Selengkapnya
                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('artikel.all') }}"
                class="inline-block bg-white border-2 border-green-600 text-green-600 hover:bg-green-600 hover:text-white font-bold py-2.5 px-6 rounded-full transition-all duration-300 transform hover:scale-105 text-sm">
                Lihat Semua Artikel
            </a>
        </div>
    </div>
</div>

<!-- CHATBOT FLOATING BUTTON + POPUP -->
<!-- Container Utama -->
<div id="chatbot-container" class="fixed bottom-6 right-6 z-50 flex flex-col items-end space-y-3">

    <!-- Popup Chat (Awalnya disembunyikan) -->
    <div id="chatbot-popup"
        class="hidden flex-col bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl w-80 max-h-[500px] border border-emerald-200 overflow-hidden">
        <div class="bg-emerald-600 text-white p-3 font-bold text-center">
            Asisten Zakat Virtual 🤖
        </div>
        <div id="chat-messages" class="flex-1 p-3 overflow-y-auto space-y-2 text-sm text-gray-800">
            <div class="text-center text-gray-400 text-xs">Mulai percakapan...</div>
        </div>
        <div class="p-3 border-t border-gray-200 flex">
            <input id="chat-input" type="text" placeholder="Ketik pesan..."
                class="flex-1 border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
            <button id="send-btn"
                class="ml-2 bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition">Kirim</button>
        </div>
    </div>

    <!-- Tombol Chat -->
    <button id="chatbot-button"
        class="bg-emerald-600 hover:bg-emerald-700 text-white rounded-full p-4 shadow-lg transition">
        💬
    </button>
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

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
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

    /* Line clamp utility */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Floating chat icon */
    .fixed.bottom-6.right-6 {
        right: 1.5rem !important;
        /* 24px */
        bottom: 1.5rem !important;
        /* 24px */
    }

    #chatbot-popup {
        width: 320px !important;
        max-width: 90vw;
    }

    #chat-container {
        max-height: 100px;
        /* atau tinggi sesuai tampilan */
        overflow-y: auto;
    }

    #chat-container {
        max-height: 400px;
        overflow-y: auto;
        scroll-behavior: smooth;
    }
</style>

<!-- JavaScript for Slider Functionality -->
<script src="https://js.puter.com/v2/"></script>

<script>
    // Chatbot functionality

    document.addEventListener("DOMContentLoaded", () => {
        const toggleBtn = document.getElementById("chatbot-toggle");
        const popup = document.getElementById("chatbot-popup");
        const sendBtn = document.getElementById("send-btn");
        const input = document.getElementById("chat-input");
        const messages = document.getElementById("chat-messages");
        const chatbotBtn = document.getElementById('chatbot-button');
        const chatbotPopup = document.getElementById('chatbot-popup');


        chatbotBtn.addEventListener('click', () => {
            chatbotPopup.classList.toggle('hidden');
            // Clear welcome message when first opening chat
            if (chatbotPopup.classList.contains('hidden') === false && messages.children.length === 1) {
                messages.innerHTML = '';
                appendMessage('<p>Selamat datang di Asisten Zakat Virtual! 👋</p><p>Saya dapat membantu Anda dengan pertanyaan seputar zakat, cara pembayaran, program yang tersedia, dan informasi lainnya.</p><p>Apa yang ingin Anda tanyakan hari ini?</p>', "bot");
            }
        });

        // Function to append messages in HTML format
        function appendMessage(htmlContent, sender) {
            const div = document.createElement("div");
            div.classList.add("p-2", "rounded-lg", "max-w-[80%]");
            if (sender === "user") {
                div.classList.add("bg-emerald-100", "self-end", "ml-auto");
            } else {
                div.classList.add("bg-gray-100");
            }

            // Set the HTML content properly
            div.innerHTML = htmlContent;
            messages.appendChild(div);
            messages.scrollTop = messages.scrollHeight;
        }

        // Format response to HTML
        function formatResponseToHtml(text) {
            // Convert line breaks to paragraphs
            const paragraphs = text.split('\n\n').filter(p => p.trim() !== '');
            let html = '';

            paragraphs.forEach(paragraph => {
                // Handle bullet points
                if (paragraph.trim().startsWith('- ') || paragraph.trim().startsWith('* ')) {
                    const lines = paragraph.split('\n');
                    html += '<ul>';
                    lines.forEach(line => {
                        const cleanLine = line.trim().replace(/^[*-]\s*/, '');
                        if (cleanLine) {
                            html += `<li>${cleanLine}</li>`;
                        }
                    });
                    html += '</ul>';
                } else {
                    // Regular paragraph
                    html += `<p>${paragraph.trim()}</p>`;
                }
            });

            return html;
        }

        // Send message handler
        async function sendMessage() {
            const userText = input.value.trim();
            if (!userText) return;

            // Display user message
            appendMessage(`<p>${userText}</p>`, "user");
            input.value = "";

            // Show typing indicator
            const loadingMsg = document.createElement("div");
            loadingMsg.id = "typing-indicator";
            loadingMsg.innerHTML = '<div class="p-2 rounded-lg bg-gray-100 max-w-[80%]"><p class="text-gray-400 italic text-xs">Mengetik...</p></div>';
            messages.appendChild(loadingMsg);
            messages.scrollTop = messages.scrollHeight;

            try {
                // Check if we should use custom responses for common zakat questions
                let replyHtml = '';

                if (userText.toLowerCase().includes('zakat') && userText.toLowerCase().includes('apa')) {
                    replyHtml = `
                        <p>Zakat adalah rukun Islam kelima yang wajib dilaksanakan oleh setiap Muslim yang memenuhi syarat.</p>
                        <p>Zakat berasal dari bahasa Arab yang berarti "bersih" atau "tumbuh". Zakat merupakan bentuk ibadah sekaligus sistem ekonomi dalam Islam yang bertujuan untuk membersihkan harta dan menyejahterakan umat.</p>
                        <p><strong>Syarat wajib zakat:</strong></p>
                        <ul>
                            <li>Muslim</li>
                            <li>Baligh (dewasa)</li>
                            <li>Merdeka (bukan budak)</li>
                            <li>Kaya (melebihi nisab)</li>
                            <li>Memiliki harta selama satu tahun (haul)</li>
                        </ul>
                    `;
                } else if (userText.toLowerCase().includes('bayar') || userText.toLowerCase().includes('cara')) {
                    replyHtml = `
                        <p>Untuk membayar zakat melalui platform kami, Anda dapat mengikuti langkah-langkah berikut:</p>
                        <ul>
                            <li>Klik tombol "BAYAR ZAKAT SEKARANG" di halaman utama</li>
                            <li>Pilih jenis zakat yang ingin Anda bayarkan</li>
                            <li>Isi formulir dengan data diri dan nominal zakat</li>
                            <li>Pilih metode pembayaran yang tersedia</li>
                            <li>Konfirmasi pembayaran dan simpan bukti transfer</li>
                        </ul>
                        <p>Pembayaran zakat bisa dilakukan kapan saja sepanjang tahun. Namun, banyak umat Muslim yang memilih membayarnya saat bulan Ramadhan karena keutamaannya.</p>
                    `;
                } else if (userText.toLowerCase().includes('jenis') && (userText.toLowerCase().includes('zakat') || userText.toLowerCase().includes('macam'))) {
                    replyHtml = `
                        <p>Ada beberapa jenis zakat yang wajib dan sunnah dibayarkan:</p>
                        <ul>
                            <li><strong>Zakat Mal</strong> - Zakat atas harta yang dimiliki</li>
                            <li><strong>Zakat Fitrah</strong> - Zakat yang wajib dibayar saat Ramadhan</li>
                            <li><strong>Zakat Profesi</strong> - Zakat atas penghasilan/profesi</li>
                            <li><strong>Zakat Emas/Perak</strong> - Zakat atas kepemilikan logam mulia</li>
                            <li><strong>Zakat Perniagaan</strong> - Zakat atas aset perdagangan</li>
                            <li><strong>Zakat Pertanian</strong> - Zakat atas hasil pertanian</li>
                            <li><strong>Zakat Peternakan</strong> - Zakat atas hewan ternak</li>
                        </ul>
                        <p>Untuk memudahkan perhitungan, Anda dapat menggunakan Kalkulator Zakat yang tersedia di platform kami.</p>
                    `;
                } else if (userText.toLowerCase().includes('manfaat') || userText.toLowerCase().includes('guna')) {
                    replyHtml = `
                        <p>Zakat memiliki manfaat besar bagi kedua belah pihak:</p>
                        <p><strong>Bagi Muzakki (Pembayar Zakat):</strong></p>
                        <ul>
                            <li>Membersihkan harta dari kotoran dan sifat kikir</li>
                            <li>Mendapatkan pahala dan ridha Allah SWT</li>
                            <li>Melatih sikap peduli terhadap sesama</li>
                            <li>Mendapat perlindungan dari bencana dan musibah</li>
                        </ul>
                        <p><strong>Bagi Mustahik (Penerima Zakat):</strong></p>
                        <ul>
                            <li>Memenuhi kebutuhan dasar hidup</li>
                            <li>Meningkatkan taraf hidup dan kesejahteraan</li>
                            <li>Mendapat kesempatan untuk berkembang secara ekonomi</li>
                            <li>Merasakan kepedulian dan kasih sayang dari sesama Muslim</li>
                        </ul>
                    `;
                } else {
                    // For other questions, use the AI API
                    const response = await puter.ai.chat(userText, {
                        model: "claude-sonnet-4-5"
                    });

                    const reply = response.message.content[0].text;
                    replyHtml = formatResponseToHtml(reply);
                }

                // Remove typing indicator
                document.getElementById("typing-indicator").remove();

                // Display bot response
                appendMessage(replyHtml, "bot");
            } catch (err) {
                // Remove typing indicator
                document.getElementById("typing-indicator").remove();

                // Display error message
                appendMessage('<p>⚠️ Terjadi kesalahan saat memproses pesan Anda. Silakan coba lagi nanti.</p>', "bot");
                console.error(err);
            }
        }

        sendBtn.addEventListener("click", sendMessage);
        input.addEventListener("keydown", e => {
            if (e.key === "Enter") sendMessage();
        });
    });

    // Slider
    document.addEventListener('DOMContentLoaded', function() {
        // Campaigns Slider
        const campaignsSlider = document.getElementById('campaigns-slider');
        const campaignsPrev = document.getElementById('campaigns-prev');
        const campaignsNext = document.getElementById('campaigns-next');

        // News Slider
        const newsSlider = document.getElementById('news-slider');
        const newsPrev = document.getElementById('news-prev');
        const newsNext = document.getElementById('news-next');

        // Artikel Slider
        const artikelSlider = document.getElementById('artikel-slider');
        const artikelPrev = document.getElementById('artikel-prev');
        const artikelNext = document.getElementById('artikel-next');

        // Scroll amount (width of one card + gap)
        const scrollAmount = 304; // 288px card width + 16px gap

        // Auto-slide intervals
        let newsAutoSlideInterval;
        let artikelAutoSlideInterval;

        // Function to start auto sliding
        function startAutoSlide() {
            // Clear any existing intervals
            if (newsAutoSlideInterval) clearInterval(newsAutoSlideInterval);
            if (artikelAutoSlideInterval) clearInterval(artikelAutoSlideInterval);

            // Start auto sliding for news (every 5 seconds)
            newsAutoSlideInterval = setInterval(() => {
                if (newsSlider) {
                    const maxScroll = newsSlider.scrollWidth - newsSlider.clientWidth;
                    if (newsSlider.scrollLeft >= maxScroll - 5) {
                        // If at the end, scroll back to the beginning
                        newsSlider.scrollTo({
                            left: 0,
                            behavior: 'smooth'
                        });
                    } else {
                        // Otherwise, scroll to the next item
                        newsSlider.scrollBy({
                            left: scrollAmount,
                            behavior: 'smooth'
                        });
                    }
                }
            }, 5000);

            // Start auto sliding for articles (every 6 seconds)
            artikelAutoSlideInterval = setInterval(() => {
                if (artikelSlider) {
                    const maxScroll = artikelSlider.scrollWidth - artikelSlider.clientWidth;
                    if (artikelSlider.scrollLeft >= maxScroll - 5) {
                        // If at the end, scroll back to the beginning
                        artikelSlider.scrollTo({
                            left: 0,
                            behavior: 'smooth'
                        });
                    } else {
                        // Otherwise, scroll to the next item
                        artikelSlider.scrollBy({
                            left: scrollAmount,
                            behavior: 'smooth'
                        });
                    }
                }
            }, 6000);
        }

        // Function to stop auto sliding
        function stopAutoSlide() {
            if (newsAutoSlideInterval) {
                clearInterval(newsAutoSlideInterval);
                newsAutoSlideInterval = null;
            }
            if (artikelAutoSlideInterval) {
                clearInterval(artikelAutoSlideInterval);
                artikelAutoSlideInterval = null;
            }
        }

        // Campaigns navigation
        if (campaignsNext) {
            campaignsNext.addEventListener('click', () => {
                campaignsSlider.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });
        }

        if (campaignsPrev) {
            campaignsPrev.addEventListener('click', () => {
                campaignsSlider.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            });
        }

        // News navigation
        if (newsNext) {
            newsNext.addEventListener('click', () => {
                newsSlider.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
                // Reset auto slide timer
                stopAutoSlide();
                startAutoSlide();
            });
        }

        if (newsPrev) {
            newsPrev.addEventListener('click', () => {
                newsSlider.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
                // Reset auto slide timer
                stopAutoSlide();
                startAutoSlide();
            });
        }

        // Artikel navigation
        if (artikelNext) {
            artikelNext.addEventListener('click', () => {
                artikelSlider.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
                // Reset auto slide timer
                stopAutoSlide();
                startAutoSlide();
            });
        }

        if (artikelPrev) {
            artikelPrev.addEventListener('click', () => {
                artikelSlider.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
                // Reset auto slide timer
                stopAutoSlide();
                startAutoSlide();
            });
        }

        // Hide navigation buttons when at start/end
        function updateNavigationButtons(slider, prevBtn, nextBtn) {
            if (slider.scrollLeft <= 0) {
                prevBtn.classList.add('opacity-0');
                prevBtn.classList.remove('opacity-100');
            } else {
                prevBtn.classList.add('opacity-100');
                prevBtn.classList.remove('opacity-0');
            }

            if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 5) {
                nextBtn.classList.add('opacity-0');
                nextBtn.classList.remove('opacity-100');
            } else {
                nextBtn.classList.add('opacity-100');
                nextBtn.classList.remove('opacity-0');
            }
        }

        // Add scroll listeners to update button visibility
        if (campaignsSlider) {
            campaignsSlider.addEventListener('scroll', () => {
                updateNavigationButtons(campaignsSlider, campaignsPrev, campaignsNext);
            });
            // Initial check
            updateNavigationButtons(campaignsSlider, campaignsPrev, campaignsNext);
        }

        if (newsSlider) {
            newsSlider.addEventListener('scroll', () => {
                updateNavigationButtons(newsSlider, newsPrev, newsNext);
            });
            // Initial check
            updateNavigationButtons(newsSlider, newsPrev, newsNext);
        }

        if (artikelSlider) {
            artikelSlider.addEventListener('scroll', () => {
                updateNavigationButtons(artikelSlider, artikelPrev, artikelNext);
            });
            // Initial check
            updateNavigationButtons(artikelSlider, artikelPrev, artikelNext);
        }

        // Start auto sliding after a short delay
        setTimeout(startAutoSlide, 2000);
    });
</script>