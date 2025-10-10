@extends('layouts.app')

@section('page-title', 'Manajemen Akun - Dashboard Muzakki')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Manajemen Akun</h2>
    </div>
</div>

<div class="row">
    <!-- Profile Information -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-person-circle"></i> Informasi Profil</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>Nama</strong></td>
                        <td>: {{ $muzakki->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>: {{ $muzakki->email ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Telepon</strong></td>
                        <td>: {{ $muzakki->phone ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>NIK</strong></td>
                        <td>: {{ $muzakki->nik ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>: {{ $muzakki->address ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kota</strong></td>
                        <td>: {{ $muzakki->city ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Pekerjaan</strong></td>
                        <td>: {{ ucfirst(str_replace('_', ' ', $muzakki->occupation)) ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Bergabung</strong></td>
                        <td>: {{ $muzakki->created_at->format('d F Y') }}</td>
                    </tr>
                </table>

                <a href="{{ route('profile.show') }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>

    <!-- Account Settings -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-gear"></i> Pengaturan Akun</h5>
            </div>
            <div class="card-body">
                <!-- Change Password -->
                <div class="mb-4">
                    <h6><i class="bi bi-lock"></i> Ganti Password</h6>
                    <p class="text-muted">Ubah password Anda untuk keamanan akun.</p>
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="bi bi-key"></i> Ganti Password
                    </button>
                </div>

                <hr>

                <!-- Delete Account -->
                <div>
                    <h6><i class="bi bi-trash"></i> Hapus Akun</h6>
                    <p class="text-muted">Hapus akun Anda secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="bi bi-exclamation-triangle"></i> Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Ganti Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('profile.update') }}" id="changePasswordForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <!-- Password Requirements -->
                        <div class="mt-2">
                            <small class="form-text text-muted">Password harus mengandung:</small>
                            <ul class="list-unstyled small">
                                <li>
                                    <i class="bi bi-x-circle-fill text-secondary requirement-icon" id="length-icon"></i>
                                    <span id="length-text">8 karakter atau lebih</span>
                                </li>
                                <li>
                                    <i class="bi bi-x-circle-fill text-secondary requirement-icon" id="uppercase-icon"></i>
                                    <span id="uppercase-text">1 huruf kapital</span>
                                </li>
                                <li>
                                    <i class="bi bi-x-circle-fill text-secondary requirement-icon" id="number-icon"></i>
                                    <span id="number-text">1 angka</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="changePasswordBtn" disabled>Ganti Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Hapus Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i> <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                </div>
                <p>Anda akan menghapus akun Anda secara permanen. Semua data Anda akan dihapus dari sistem kami.</p>
                <p>Sebelum melanjutkan, pastikan Anda:</p>
                <ul>
                    <li>Telah mencatat semua informasi penting</li>
                    <li>Tidak memiliki pembayaran yang tertunda</li>
                    <li>Memahami bahwa data tidak dapat dipulihkan</li>
                </ul>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                    <label class="form-check-label" for="confirmDelete">
                        Saya mengerti dan ingin menghapus akun saya
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton" disabled>
                    <i class="bi bi-trash"></i> Hapus Akun
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Enable delete button when checkbox is checked
    document.getElementById('confirmDelete').addEventListener('change', function() {
        document.getElementById('confirmDeleteButton').disabled = !this.checked;
    });

    // Handle delete account confirmation
    document.getElementById('confirmDeleteButton').addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin menghapus akun Anda secara permanen? Tindakan ini tidak dapat dibatalkan.')) {
            // In a real implementation, this would send a request to delete the account
            alert('Fitur penghapusan akun akan segera tersedia. Silakan hubungi administrator untuk bantuan.');
            bootstrap.Modal.getInstance(document.getElementById('deleteAccountModal')).hide();
        }
    });

    // Password visibility toggle functions
    function togglePasswordVisibility(inputId, buttonId) {
        const input = document.getElementById(inputId);
        const button = document.getElementById(buttonId);
        const icon = button.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    // Password strength validation
    function validatePassword(password) {
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            number: /\d/.test(password)
        };

        return requirements;
    }

    // Update password requirement indicators
    function updatePasswordIndicators(password) {
        const requirements = validatePassword(password);

        // Length requirement
        const lengthIcon = document.getElementById('length-icon');
        const lengthText = document.getElementById('length-text');
        if (requirements.length) {
            lengthIcon.classList.remove('bi-x-circle-fill', 'text-secondary');
            lengthIcon.classList.add('bi-check-circle-fill', 'text-success');
            lengthText.classList.add('text-success');
        } else {
            lengthIcon.classList.remove('bi-check-circle-fill', 'text-success');
            lengthIcon.classList.add('bi-x-circle-fill', 'text-secondary');
            lengthText.classList.remove('text-success');
        }

        // Uppercase requirement
        const uppercaseIcon = document.getElementById('uppercase-icon');
        const uppercaseText = document.getElementById('uppercase-text');
        if (requirements.uppercase) {
            uppercaseIcon.classList.remove('bi-x-circle-fill', 'text-secondary');
            uppercaseIcon.classList.add('bi-check-circle-fill', 'text-success');
            uppercaseText.classList.add('text-success');
        } else {
            uppercaseIcon.classList.remove('bi-check-circle-fill', 'text-success');
            uppercaseIcon.classList.add('bi-x-circle-fill', 'text-secondary');
            uppercaseText.classList.remove('text-success');
        }

        // Number requirement
        const numberIcon = document.getElementById('number-icon');
        const numberText = document.getElementById('number-text');
        if (requirements.number) {
            numberIcon.classList.remove('bi-x-circle-fill', 'text-secondary');
            numberIcon.classList.add('bi-check-circle-fill', 'text-success');
            numberText.classList.add('text-success');
        } else {
            numberIcon.classList.remove('bi-check-circle-fill', 'text-success');
            numberIcon.classList.add('bi-x-circle-fill', 'text-secondary');
            numberText.classList.remove('text-success');
        }

        // Enable/disable submit button based on all requirements
        const allMet = requirements.length && requirements.uppercase && requirements.number;
        const confirmPassword = document.getElementById('new_password_confirmation').value;
        const passwordsMatch = password === confirmPassword && confirmPassword !== '';

        const submitBtn = document.getElementById('changePasswordBtn');
        if (allMet && passwordsMatch) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }

    // Add event listeners for password toggle buttons
    document.addEventListener('DOMContentLoaded', function() {
        // Current password toggle
        document.getElementById('toggleCurrentPassword')?.addEventListener('click', function() {
            togglePasswordVisibility('current_password', 'toggleCurrentPassword');
        });

        // New password toggle
        document.getElementById('toggleNewPassword')?.addEventListener('click', function() {
            togglePasswordVisibility('new_password', 'toggleNewPassword');
        });

        // Confirm password toggle
        document.getElementById('toggleConfirmPassword')?.addEventListener('click', function() {
            togglePasswordVisibility('new_password_confirmation', 'toggleConfirmPassword');
        });

        // Password strength validation
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('new_password_confirmation');

        newPasswordInput?.addEventListener('input', function() {
            updatePasswordIndicators(this.value);
        });

        confirmPasswordInput?.addEventListener('input', function() {
            const newPassword = document.getElementById('new_password').value;
            updatePasswordIndicators(newPassword);
        });
    });
</script>
@endpush
@endsection