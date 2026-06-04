<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {

    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // Cek apakah email terdaftar di database
        if (!\App\Models\User::where('email', $this->email)->exists()) {
            $this->addError('email', 'Email tidak terdaftar dalam sistem SERAP.');
            return;
        }

        Password::sendResetLink($this->only('email'));
        session()->flash('status', 'Link reset password telah dikirim ke email Anda.');
    }
}; 
?>

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
                <h3 class="fw-bold display-6 mb-2">Lupa Kata Sandi?</h3>
                <p class="text-muted">
                    Masukkan email Anda dan kami akan mengirimkan link reset password.
                </p>
            </div>

           {{-- Alert sukses --}}
            @if (session('status'))
                <div class="alert alert-success text-center small" id="alertStatus">
                    {{ session('status') }}
                </div>

                <script>
                    setTimeout(function () {
                        const alert = document.getElementById('alertStatus');
                        if (alert) {
                            alert.style.transition = 'opacity 0.5s ease';
                            alert.style.opacity = '0';
                            setTimeout(() => alert.remove(), 500);
                        }
                    }, 5000);
                </script>
            @endif

            <form wire:submit.prevent="sendPasswordResetLink">
                <div class="mb-4">
                <label class="form-label visually-hidden">Alamat Email</label>
                    <input type="email" wire:model="email"
                        class="form-control form-control-lg"
                        placeholder="Alamat Email"
                        autofocus required
                        style="border-radius: 0.5rem 0.5rem 0.5rem 0.5rem !important;">
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>  {{-- ← pastikan ini ada --}}
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold"
                    wire:loading.attr="disabled" wire:target="sendPasswordResetLink" style="border-radius: 0.5rem 0.5rem 0.5rem 0.5rem !important;">
                    <span wire:loading.remove wire:target="sendPasswordResetLink">
                        Kirim Link Reset
                    </span>
                    <span wire:loading wire:target="sendPasswordResetLink" style="display:none;">
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                        Mengirim...
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