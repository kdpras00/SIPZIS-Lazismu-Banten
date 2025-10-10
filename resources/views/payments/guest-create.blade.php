@extends('layouts.main')

@section('title', 'Donasi Program - SIPZIS')

@section('content')
<div class="relative bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 overflow-hidden min-h-screen flex items-center justify-center">
    {{-- Background decorative blobs --}}
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-40 h-40 bg-emerald-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
        <div class="absolute top-0 right-0 w-40 h-40 bg-teal-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-40 h-40 bg-cyan-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse animation-delay-4000"></div>
    </div>

    <div class="relative container mx-auto px-4 py-16">
        {{-- Menggunakan max-w-4xl agar form lebih lebar --}}
        <div class="max-w-4xl mx-auto">
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/50 p-8">

                {{-- Program Information Header --}}
                <div class="flex items-start sm:items-center gap-4 border-b border-gray-200 pb-6 mb-6">
                    @php
                    $categories = [
                    // Program pilar categories
                    'pendidikan' => ['title' => 'Pilar Pendidikan', 'subtitle' => 'Mencerahkan Masa Depan dalam Membangun Negeri', 'image' => asset('img/program/pendidikan.jpg'), 'text_color' => 'text-blue-800'],
                    'kesehatan' => ['title' => 'Pilar Kesehatan', 'subtitle' => 'Mewujudkan Kehidupan yang Lebih Sehat untuk Semua', 'image' => asset('img/program/kesehatan.jpg'), 'text_color' => 'text-red-800'],
                    'ekonomi' => ['title' => 'Pilar Ekonomi', 'subtitle' => 'Memberdayakan Masyarakat secara Ekonomi', 'image' => asset('img/program/ekonomi.jpg'), 'text_color' => 'text-amber-800'],
                    'sosial-dakwah' => ['title' => 'Pilar Sosial & Dakwah', 'subtitle' => 'Membangun Masyarakat yang Berkualitas', 'image' => asset('img/program/sosial-dakwah.jpg'), 'text_color' => 'text-green-800'],
                    'kemanusiaan' => ['title' => 'Pilar Kemanusiaan', 'subtitle' => 'Menyejahterakan Umat Manusia Tanpa Diskriminasi', 'image' => asset('img/program/kemanusiaan.jpg'), 'text_color' => 'text-purple-800'],
                    'lingkungan' => ['title' => 'Pilar Lingkungan', 'subtitle' => 'Menjaga Lingkungan untuk Generasi Mendatang', 'image' => asset('img/program/lingkungan.jpg'), 'text_color' => 'text-cyan-800'],

                    // Zakat categories
                    'zakat-mal' => ['title' => 'Zakat Mal', 'subtitle' => 'Zakat harta yang telah mencapai nisab dan haul', 'image' => asset('img/zakat.jpg'), 'text_color' => 'text-orange-800'],
                    'zakat-profesi' => ['title' => 'Zakat Profesi', 'subtitle' => 'Zakat penghasilan atau pendapatan', 'image' => asset('img/zakat.jpg'), 'text_color' => 'text-orange-800'],
                    'zakat-fitrah' => ['title' => 'Zakat Fitrah', 'subtitle' => 'Zakat yang wajib dikeluarkan menjelang Idul Fitri', 'image' => asset('img/zakat.jpg'), 'text_color' => 'text-orange-800'],

                    // Infaq categories
                    'infaq-masjid' => ['title' => 'Infaq Masjid', 'subtitle' => 'Infaq untuk pembangunan dan pemeliharaan masjid', 'image' => asset('img/infaq.jpg'), 'text_color' => 'text-blue-800'],
                    'infaq-pendidikan' => ['title' => 'Infaq Pendidikan', 'subtitle' => 'Infaq untuk mendukung program pendidikan', 'image' => asset('img/infaq.jpg'), 'text_color' => 'text-blue-800'],
                    'infaq-kemanusiaan' => ['title' => 'Infaq Kemanusiaan', 'subtitle' => 'Infaq untuk membantu sesama yang membutuhkan', 'image' => asset('img/infaq.jpg'), 'text_color' => 'text-blue-800'],

                    // Shadaqah categories
                    'shadaqah-rutin' => ['title' => 'Shadaqah Rutin', 'subtitle' => 'Shadaqah yang diberikan secara berkala', 'image' => asset('img/infaq.jpg'), 'text_color' => 'text-green-800'],
                    'shadaqah-jariyah' => ['title' => 'Shadaqah Jariyah', 'subtitle' => 'Shadaqah yang manfaatnya berlangsung lama', 'image' => asset('img/infaq.jpg'), 'text_color' => 'text-green-800'],
                    'fidyah' => ['title' => 'Fidyah', 'subtitle' => 'Tebusan karena tidak menjalankan kewajiban agama', 'image' => asset('img/infaq.jpg'), 'text_color' => 'text-green-800'],

                    // Generic categories
                    'umum' => ['title' => 'Program Umum', 'subtitle' => 'Membangun Masyarakat yang Lebih Baik', 'image' => asset('img/masjid.webp'), 'text_color' => 'text-emerald-800'],
                    'zakat' => ['title' => 'Zakat', 'subtitle' => 'Penyaluran Zakat yang Tepat Sasaran', 'image' => asset('img/zakat.jpg'), 'text_color' => 'text-orange-800'],
                    'infaq' => ['title' => 'Infaq', 'subtitle' => 'Infaq untuk Kebaikan Bersama', 'image' => asset('img/infaq.jpg'), 'text_color' => 'text-blue-800']
                    ];

                    // Determine display title - use campaign title if available, otherwise use category title
                    if (isset($campaign) && $campaign) {
                    $displayTitle = $campaign->title;
                    $displaySubtitle = $categories[$programCategory]['subtitle'] ?? 'Donasi untuk campaign ini';
                    $categoryDetails = $categories[$programCategory] ?? $categories['umum'];
                    } else {
                    $categoryDetails = $categories[$programCategory] ?? $categories['umum'];
                    $displayTitle = $categoryDetails['title'];
                    $displaySubtitle = $categoryDetails['subtitle'];
                    }

                    // Check if this is a program with specific type
                    $programTypeId = request()->query('program_type_id', '');
                    if ($programTypeId) {
                    $programType = App\Models\ProgramType::find($programTypeId);
                    if ($programType) {
                    $displayTitle = $programType->name;
                    $displaySubtitle = $programType->description;
                    }
                    }

                    // Check if this is a zakat donation with specific type
                    $zakatType = request()->query('type', '');
                    if ($programCategory === 'zakat' && $zakatType) {
                    if ($zakatType === 'profesi') {
                    $displayTitle = 'Zakat Profesi';
                    $displaySubtitle = 'Zakat penghasilan atau pendapatan';
                    } elseif ($zakatType === 'harta') {
                    $displayTitle = 'Zakat Harta';
                    $displaySubtitle = 'Zakat atas harta yang dimiliki';
                    }
                    }

                    // Check if this is a program with specific type
                    $programTypeId = request()->query('program_type_id', '');
                    if ($programTypeId) {
                    $programType = App\Models\ProgramType::find($programTypeId);
                    if ($programType) {
                    $displayTitle = $programType->name;
                    $displaySubtitle = $programType->description;
                    }
                    }
                    @endphp

                    <img src="{{ $categoryDetails['image'] }}" alt="Program {{ $displayTitle }}" class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-lg shadow-md flex-shrink-0">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Anda akan berdonasi untuk:</p>
                        <h2 class="text-lg sm:text-xl font-bold {{ $categoryDetails['text_color'] }} leading-tight">
                            {{ $displayTitle }}
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">{{ $displaySubtitle }}</p>
                    </div>
                </div>

                {{-- Pastikan form action dan method sesuai dengan route Anda --}}
                <form id="donation-form" class="space-y-6" autocomplete="off">
                    @csrf

                    {{-- PERBAIKAN 1: Tambahkan hidden input yang dibutuhkan backend --}}
                    <input type="hidden" name="program_category" value="{{ $programCategory }}" autocomplete="off">
                    <input type="hidden" name="zakat_type_id" value="{{ request()->query('type') === 'profesi' ? 3 : (request()->query('type') === 'harta' ? 1 : (request()->query('type') === 'mal' ? 2 : '')) }}" autocomplete="off">
                    <input type="hidden" name="program_type_id" id="program_type_id" value="{{ request()->query('program_type_id') }}" autocomplete="off">
                    <input type="hidden" name="zakat_amount" id="zakat_amount" value="0" autocomplete="off">
                    <input type="hidden" name="paid_amount" id="paid_amount" value="0" autocomplete="off">

                    {{-- Nominal Donasi dengan Pilihan Cepat --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Nominal Donasi *</label>

                        {{-- Pilihan nominal cepat --}}
                        <div class="mb-6">
                            <h3 class="text-gray-700 font-semibold mb-3">Nominal Donasi</h3>
                            <div class="flex flex-wrap gap-3 justify-center">
                                <button type="button"
                                    class="quick-amount-btn bg-white text-green-800 border border-black-600 rounded-full px-6 py-3 font-semibold shadow-sm hover:bg-black-50 hover:shadow-md transition-all duration-200 ease-in-out"
                                    data-amount="10000">
                                    Rp 10.000
                                </button>
                                <button type="button"
                                    class="quick-amount-btn bg-white text-green-800 border border-black-600 rounded-full px-6 py-3 font-semibold shadow-sm hover:bg-black-50 hover:shadow-md transition-all duration-200 ease-in-out"
                                    data-amount="20000">
                                    Rp 20.000
                                </button>
                                <button type="button"
                                    class="quick-amount-btn bg-white text-green-800 border border-black-600 rounded-full px-6 py-3 font-semibold shadow-sm hover:bg-black-50 hover:shadow-md transition-all duration-200 ease-in-out"
                                    data-amount="50000">
                                    Rp 50.000
                                </button>
                                <button type="button"
                                    class="quick-amount-btn bg-white text-green-800 border border-black-600 rounded-full px-6 py-3 font-semibold shadow-sm hover:bg-black-50 hover:shadow-md transition-all duration-200 ease-in-out"
                                    data-amount="100000">
                                    Rp 100.000
                                </button>
                                <button type="button"
                                    class="quick-amount-btn bg-white text-green-800 border border-black rounded-full px-6 py-3 font-semibold shadow-sm hover:bg-gray-50 hover:shadow-md transition-all duration-200 ease-in-out"
                                    data-amount="custom">
                                    Lainnya
                                </button>

                            </div>
                        </div>

                        {{-- Input manual --}}
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">Rp.</span>
                            <input type="text" id="donation_amount_display" inputmode="numeric" oninput="formatAndSetValues(this)" class="w-full border-2 border-gray-200 rounded-xl pl-12 pr-4 py-3 focus:border-emerald-500 focus:outline-none transition-colors" placeholder="Masukkan nominal lain" required autocomplete="off">
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Minimal donasi Rp 1.000</p>
                    </div>

                    {{-- Hidden input for payment method --}}
                    <input type="hidden" name="payment_method" value="" autocomplete="off">

                    {{-- Donor Information Fields - Only show if user is not logged in or doesn't have a muzakki profile --}}
                    @if(!isset($loggedInMuzakki))
                    <div>
                        <label for="donor_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="donor_name" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-emerald-500 focus:outline-none transition-colors" placeholder="Masukkan nama lengkap Anda" autocomplete="off">
                    </div>
                    <div>
                        <label for="donor_phone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP Aktif</label>
                        <input type="tel" name="donor_phone" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-emerald-500 focus:outline-none transition-colors" placeholder="08xxxxxxxxxx" autocomplete="off">
                    </div>
                    <div>
                        <label for="donor_email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" name="donor_email" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-emerald-500 focus:outline-none transition-colors" placeholder="email@contoh.com" autocomplete="off">
                    </div>
                    @else
                    {{-- Hidden fields for logged in users --}}
                    <input type="hidden" name="donor_name" value="{{ $loggedInMuzakki->name }}" autocomplete="off">
                    <input type="hidden" name="donor_phone" value="{{ $loggedInMuzakki->phone }}" autocomplete="off">
                    <input type="hidden" name="donor_email" value="{{ $loggedInMuzakki->email }}" autocomplete="off">
                    @endif

                    {{-- Message/Doa field - always show --}}
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">Tulis pesan atau doa</label>
                        <textarea name="notes" rows="4" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-emerald-500 focus:outline-none transition-colors" placeholder="Tulis pesan atau doa Anda di sini..." autocomplete="off"></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-yellow-500 text-white px-8 py-4 rounded-xl hover:bg-yellow-600 font-bold text-lg">
                            SELANJUTNYA
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Clear form fields on page load to prevent browser auto-fill
    document.addEventListener('DOMContentLoaded', function() {
        // Clear all input fields
        const inputs = document.querySelectorAll('input[type="text"], input[type="tel"], input[type="email"], textarea');
        inputs.forEach(input => {
            input.value = '';
        });

        // Clear hidden fields
        document.getElementById('paid_amount').value = '0';
        document.getElementById('zakat_amount').value = '0';

        // Remove selected class from quick amount buttons
        document.querySelectorAll('.quick-amount-btn').forEach(btn => {
            btn.classList.remove('selected');
        });

        // Check if there's a pre-filled amount from the calculator
        const urlParams = new URLSearchParams(window.location.search);
        const amount = urlParams.get('amount');
        if (amount) {
            // Format and set the amount
            const formattedAmount = new Intl.NumberFormat('id-ID').format(amount);
            document.getElementById('donation_amount_display').value = formattedAmount;
            document.getElementById('paid_amount').value = amount;

            // Add selected class to the corresponding quick amount button if it exists
            const quickAmountBtn = document.querySelector(`.quick-amount-btn[data-amount="${amount}"]`);
            if (quickAmountBtn) {
                quickAmountBtn.classList.add('selected');
            }
        }

        // Set program_type_id if it exists in URL
        const programTypeId = urlParams.get('program_type_id');
        if (programTypeId) {
            document.getElementById('program_type_id').value = programTypeId;
            console.log('Program Type ID set to:', programTypeId); // For debugging
        }

        // Also ensure program_category is properly set
        const programCategory = urlParams.get('category');
        if (programCategory) {
            document.querySelector('input[name="program_category"]').value = programCategory;
            console.log('Program Category set to:', programCategory); // For debugging
        }
    });

    // Function to format and set values
    function formatAndSetValues(displayElement) {
        // Get the raw value and remove all non-digit characters
        let rawValue = displayElement.value.replace(/\D/g, '');

        // Convert to number, default to 0 if empty or invalid
        let numericValue = rawValue ? parseInt(rawValue, 10) : 0;

        // Set the hidden paid_amount input
        document.getElementById('paid_amount').value = numericValue;

        // Format display value with thousand separators
        if (rawValue) {
            displayElement.value = new Intl.NumberFormat('id-ID').format(rawValue);
            // Remove selected class from all quick amount buttons
            document.querySelectorAll('.quick-amount-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
        } else {
            displayElement.value = '';
        }
    }

    // Add event listeners for quick amount buttons
    document.querySelectorAll('.quick-amount-btn').forEach(button => {
        button.addEventListener('click', function() {
            const amount = this.getAttribute('data-amount');

            if (amount === 'custom') {
                // Focus on the custom input field
                document.getElementById('donation_amount_display').focus();
                return;
            }

            // Set the amount in both display and hidden fields
            document.getElementById('donation_amount_display').value = new Intl.NumberFormat('id-ID').format(amount);
            document.getElementById('paid_amount').value = amount;

            // Add selected class to this button and remove from others
            document.querySelectorAll('.quick-amount-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
            this.classList.add('selected');
        });
    });

    // Handle form submission
    document.getElementById('donation-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const submitButton = this.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;

        // Disable button and show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = 'Memproses...';

        const formData = new FormData(this);

        fetch('{{ route("guest.payment.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                    'Accept': 'application/json',
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.redirect_url) {
                    // Jika sukses, arahkan ke halaman summary
                    window.location.href = data.redirect_url;
                } else {
                    alert('Terjadi kesalahan: ' + (data.message || 'Silakan cek kembali data Anda.'));
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Tidak dapat terhubung ke server. Silakan coba lagi.');
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            });
    });
</script>
@endsection