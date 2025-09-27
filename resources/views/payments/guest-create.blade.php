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
                            'pendidikan' => ['title' => 'Pilar Pendidikan', 'subtitle' => 'Mencerahkan Masa Depan dalam Membangun Negeri', 'image' => asset('img/program/pendidikan.jpg'), 'text_color' => 'text-blue-800'],
                            'kesehatan' => ['title' => 'Pilar Kesehatan', 'subtitle' => 'Mewujudkan Kehidupan yang Lebih Sehat untuk Semua', 'image' => asset('img/program/kesehatan.jpg'), 'text_color' => 'text-red-800'],
                            'ekonomi' => ['title' => 'Pilar Ekonomi', 'subtitle' => 'Memberdayakan Masyarakat secara Ekonomi', 'image' => asset('img/program/ekonomi.jpg'), 'text_color' => 'text-amber-800'],
                            'sosial-dakwah' => ['title' => 'Pilar Sosial & Dakwah', 'subtitle' => 'Membangun Masyarakat yang Berkualitas', 'image' => asset('img/program/sosial-dakwah.jpg'), 'text_color' => 'text-green-800'],
                            'kemanusiaan' => ['title' => 'Pilar Kemanusiaan', 'subtitle' => 'Menyejahterakan Umat Manusia Tanpa Diskriminasi', 'image' => asset('img/program/kemanusiaan.jpg'), 'text_color' => 'text-purple-800'],
                            'lingkungan' => ['title' => 'Pilar Lingkungan', 'subtitle' => 'Menjaga Lingkungan untuk Generasi Mendatang', 'image' => asset('img/program/lingkungan.jpg'), 'text_color' => 'text-cyan-800'],
                            'umum' => ['title' => 'Program Umum', 'subtitle' => 'Membangun Masyarakat yang Lebih Baik', 'image' => asset('img/masjid.webp'), 'text_color' => 'text-emerald-800']
                        ];
                        $categoryDetails = $categories[$programCategory] ?? $categories['umum'];
                    @endphp
                    
                    <img src="{{ $categoryDetails['image'] }}" alt="Program {{ $categoryDetails['title'] }}" class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-lg shadow-md flex-shrink-0">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Anda akan berdonasi untuk program:</p>
                        <h2 class="text-lg sm:text-xl font-bold {{ $categoryDetails['text_color'] }} leading-tight">
                            {{ $categoryDetails['title'] }} : {{ $categoryDetails['subtitle'] }}
                        </h2>
                    </div>
                </div>

                {{-- Pastikan form action dan method sesuai dengan route Anda --}}
                <form id="donation-form" class="space-y-6">
                    @csrf
                    
                    {{-- PERBAIKAN 1: Tambahkan hidden input yang dibutuhkan backend --}}
                    <input type="hidden" name="program_category" value="{{ $programCategory }}">
                    <input type="hidden" name="zakat_amount" id="zakat_amount">
                    <input type="hidden" name="paid_amount" id="paid_amount">

                    {{-- PERBAIKAN 2: Sistem input nominal yang benar --}}
                    <div>
                        <label for="donation_amount_display" class="block text-sm font-semibold text-gray-700 mb-2">Nominal Donasi *</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">Rp.</span>
                            {{-- Input ini hanya untuk tampilan, tidak punya atribut "name" --}}
                            <input type="text" id="donation_amount_display" inputmode="numeric" oninput="formatAndSetValues(this)" class="w-full border-2 border-gray-200 rounded-xl pl-12 pr-4 py-3 focus:border-emerald-500 focus:outline-none transition-colors" placeholder="0" required>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Minimal donasi Rp 1.000</p>
                    </div>
                    
                    <div>
                        <label for="payment_method" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Metode Pembayaran *</label>
                        <select name="payment_method" id="payment_method" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-emerald-500 focus:outline-none transition-colors" required>
                            <option value="" disabled selected>-- Pilih Metode Pembayaran --</option>
                            <option value="midtrans-gopay">GoPay</option>
                            <option value="midtrans-dana">Dana</option>
                            <option value="midtrans-bank-bni">BNI</option>
                            <option value="midtrans-bank-bca">BCA</option>
                            <option value="midtrans-bank-mandiri">Mandiri</option>
                            <option value="midtrans-bank-bri">BRI</option>
                            <option value="midtrans-bank-permata">Permata</option>
                            <option value="midtrans-convenience-alfamart">Alfamart</option>
                            <option value="midtrans-convenience-indomaret">Indomaret</option>                            
                        </select>
                    </div>

                    {{-- Donor Information Fields (Nama, HP, Email, Pesan) --}}
                    <div>
                        <label for="donor_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="donor_name" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3" placeholder="Masukkan nama lengkap Anda">
                    </div>
                    <div>
                        <label for="donor_phone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP Aktif</label>
                        <input type="tel" name="donor_phone" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3" placeholder="08xxxxxxxxxx">
                    </div>
                     <div>
                        <label for="donor_email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" name="donor_email" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3" placeholder="email@contoh.com">
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">Tulis pesan atau doa</label>
                        <textarea name="notes" rows="4" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3"></textarea>
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

<style>
.animation-delay-2000 { animation-delay: 2s; }
.animation-delay-4000 { animation-delay: 4s; }
</style>

<!-- Midtrans Snap.js -->
<!-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('Mid-client-3Lu5KOHClKj6-UcD') }}"></script> -->

<script>
function formatAndSetValues(displayElement) {
    let rawValue = displayElement.value.replace(/\D/g, '');
    document.getElementById('paid_amount').value = rawValue;
    // Hapus input zakat_amount karena tidak digunakan di controller baru
    // document.getElementById('zakat_amount').value = rawValue; 

    if (rawValue) {
        displayElement.value = new Intl.NumberFormat('id-ID').format(rawValue);
    } else {
        displayElement.value = '';
    }
}

const donationForm = document.getElementById('donation-form');
donationForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const submitButton = this.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;
    
    // Validate minimum amount
    const paidAmount = document.getElementById('paid_amount').value;
    if (paidAmount < 1000) {
        alert('Minimal donasi adalah Rp 1.000');
        return;
    }
    
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