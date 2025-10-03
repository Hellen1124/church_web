
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
    
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="bg-primary text-white text-center py-4">
                <h4 class="fw-bold mb-0">Verify Your Phone</h4>
                <small class="text-white-50">Enter the OTP sent to {{ $phone }}</small>
            </div>
            <div class="card-body p-4">
                <form wire:submit.prevent="verify">
                    <div class="mb-3">
                        <label for="code" class="form-label">OTP Code</label>
                        <input type="text" wire:model.defer="code"
                               class="form-control @error('code') is-invalid @enderror"
                               id="code" placeholder="Enter 6-digit OTP" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                            Verify OTP
                        </button>
                    </div>
                    <div class="text-center mt-3">
                        <button wire:click="resendOtp" class="btn btn-link"
                                @if(!$canResend) disabled @endif>
                            Resend OTP
                            @if(!$canResend) ({{ $resendCountdown }}s) @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('startCountdown', () => {
                let countdown = {{ $resendCountdown }};
                const button = document.querySelector('button[wire\\:click="resendOtp"]');
                button.disabled = true;

                const interval = setInterval(() => {
                    countdown--;
                    button.textContent = `Resend OTP (${countdown}s)`;
                    if (countdown <= 0) {
                        clearInterval(interval);
                        button.disabled = false;
                        button.textContent = 'Resend OTP';
                        @this.set('canResend', true);
                    }
                }, 1000);
            });
        });
    </script>
@endpush

