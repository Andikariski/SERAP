<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->string('email');
    }

    public function resetPassword(): void
    {
        $this->validate([
            'token'    => ['required'],
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password'       => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));
            return;
        }

        Session::flash('status', __($status));
        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div class="card shadow-lg border-0 overflow-hidden" style="width: 100%; max-width: 100%; border-radius: 1rem;">
    <div class="row g-0">

        {{-- Kolom Kiri --}}
        <div class="col-md-5 login-left d-none d-md-flex align-items-center justify-content-center text-white p-4"
            style="background: linear-gradient(135deg, #04a2dc, #002ddf);">
            <div class="text-center">
                <img src="{{ asset('assets/img/SerapLogin.png') }}" alt="Logo SIMDOTIPPS"
                    class="img-fluid logo-simdoti" style="max-width: 250px;">
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div class="col-md-7 p-5 d-flex flex-column justify-content-center">
            <div class="text-center mb-4">
                <h3 class="fw-bold display-6">Reset Password</h3>
                <p class="text-muted">Masukkan password baru Anda di bawah ini.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success text-center small">
                    {{ session('status') }}
                </div>
            @endif

            <form wire:submit.prevent="resetPassword">

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label visually-hidden">Alamat Email</label>
                    <input type="email" wire:model="email"
                        class="form-control form-control-lg"
                        placeholder="Alamat Email" required disabled>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password Baru --}}
                <div class="mb-3">
                    <label class="form-label visually-hidden">Kata Sandi Baru</label>
                    <div class="input-group">
                        <input type="password" wire:model="password"
                            id="passwordInput"
                            class="form-control form-control-lg"
                            placeholder="Kata Sandi Baru" required
                            style="border-radius: 0.5rem 0 0 0.5rem !important;">
                        <button class="btn btn-outline-secondary" type="button"
                            onclick="togglePassword('passwordInput', 'eyeIcon1')"
                            tabindex="-1"
                            style="border-radius: 0 0.5rem 0.5rem 0 !important;">
                            <i class="bi bi-eye" id="eyeIcon1"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-4">
                    <label class="form-label visually-hidden">Konfirmasi Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" wire:model="password_confirmation"
                            id="passwordConfirmInput"
                            class="form-control form-control-lg"
                            placeholder="Konfirmasi Kata Sandi" required
                            style="border-radius: 0.5rem 0 0 0.5rem !important;">
                        <button class="btn btn-outline-secondary" type="button"
                            onclick="togglePassword('passwordConfirmInput', 'eyeIcon2')"
                            tabindex="-1"
                            style="border-radius: 0 0.5rem 0.5rem 0 !important;">
                            <i class="bi bi-eye" id="eyeIcon2"></i>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold"
                    wire:loading.attr="disabled" wire:target="resetPassword">
                    <span wire:loading.remove wire:target="resetPassword">Reset Password</span>
                    <span wire:loading wire:target="resetPassword" style="display:none;">
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                        Memproses...
                    </span>
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-decoration-none text-muted small">
                    ← Kembali ke Login
                </a>
            </div>
        </div>

    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>