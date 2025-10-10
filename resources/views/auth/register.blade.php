@extends('layouts.main')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12">
    <div class="w-full max-w-md px-6">
        <div class="bg-white rounded-lg shadow-md p-8">
            <!-- Back Button & Title -->
            <div class="mb-8">
                <a href="{{ route('login') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Bergabung dengan SIPZIS</h1>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input id="name" type="text"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror"
                        name="name" value="{{ old('name') }}"
                        placeholder="John Doe"
                        required autocomplete="name" autofocus>
                    @error('name')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input id="email" type="email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror"
                        name="email" value="{{ old('email') }}"
                        placeholder="johndoe@example.com"
                        required autocomplete="email">
                    @error('email')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- No. Telepon -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        No. Telepon
                    </label>
                    <div class="flex gap-2">
                        <select class="px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="+62">🇮🇩 +62</option>
                        </select>
                        <input id="phone" type="tel"
                            class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                            name="phone" value="{{ old('phone') }}"
                            placeholder="81234567890">
                    </div>
                    @error('phone')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Kata Sandi -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="password" type="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-500 @enderror pr-12"
                            name="password"
                            placeholder="Masukkan kata sandi"
                            required autocomplete="new-password">
                        <button class="absolute inset-y-0 right-0 flex items-center pr-4 bg-transparent border-0 text-gray-500 cursor-pointer" type="button" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="mt-2 space-y-1 text-xs text-gray-500">
                        <p class="flex items-center">
                            <span class="w-4 h-4 rounded-full border border-gray-300 mr-2" id="length-check"></span>
                            8 Karakter atau lebih
                        </p>
                        <p class="flex items-center">
                            <span class="w-4 h-4 rounded-full border border-gray-300 mr-2" id="capital-check"></span>
                            1 huruf kapital
                        </p>
                        <p class="flex items-center">
                            <span class="w-4 h-4 rounded-full border border-gray-300 mr-2" id="number-check"></span>
                            1 angka
                        </p>
                    </div>
                    @error('password')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="password_confirmation" type="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent pr-12"
                            name="password_confirmation"
                            placeholder="Masukkan ulang kata sandi"
                            required autocomplete="new-password">
                        <button class="absolute inset-y-0 right-0 flex items-center pr-4 bg-transparent border-0 text-gray-500 cursor-pointer" type="button" id="togglePasswordConfirm">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Hidden fields with null values -->
                <input type="hidden" name="nik" value="">
                <input type="hidden" name="gender" value="">
                <input type="hidden" name="address" value="">
                <input type="hidden" name="city" value="">
                <input type="hidden" name="province" value="">
                <input type="hidden" name="occupation" value="">
                <input type="hidden" name="monthly_income" value="">
                <input type="hidden" name="date_of_birth" value="">

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 mt-6">
                    Daftar
                </button>
            </form>

            <!-- Login Link -->
            <p class="text-center text-sm text-gray-600 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-medium">
                    Masuk
                </a>
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
        const passwordConfirm = document.getElementById('password_confirmation');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            const icon = this.querySelector('i');
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });

        togglePasswordConfirm.addEventListener('click', function() {
            const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirm.setAttribute('type', type);
            const icon = this.querySelector('i');
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });

        // Password Validation
        const lengthCheck = document.getElementById('length-check');
        const capitalCheck = document.getElementById('capital-check');
        const numberCheck = document.getElementById('number-check');

        password.addEventListener('input', function() {
            const value = this.value;

            // Check length
            if (value.length >= 8) {
                lengthCheck.classList.add('bg-green-500', 'border-green-500');
                lengthCheck.classList.remove('border-gray-300');
            } else {
                lengthCheck.classList.remove('bg-green-500', 'border-green-500');
                lengthCheck.classList.add('border-gray-300');
            }

            // Check capital letter
            if (/[A-Z]/.test(value)) {
                capitalCheck.classList.add('bg-green-500', 'border-green-500');
                capitalCheck.classList.remove('border-gray-300');
            } else {
                capitalCheck.classList.remove('bg-green-500', 'border-green-500');
                capitalCheck.classList.add('border-gray-300');
            }

            // Check number
            if (/[0-9]/.test(value)) {
                numberCheck.classList.add('bg-green-500', 'border-green-500');
                numberCheck.classList.remove('border-gray-300');
            } else {
                numberCheck.classList.remove('bg-green-500', 'border-green-500');
                numberCheck.classList.add('border-gray-300');
            }
        });
    });
</script>
@endsection