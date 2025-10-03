<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
    
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            
            <!-- Header -->
            <div class="bg-primary text-white text-center py-4">
                <img src="#" alt="Jobwira" width="80" class="mb-2">
                <h4 class="fw-bold mb-0">Create Your Account</h4>
                <small class="text-white-50">Join Jobwira today</small>
            </div>

            <!-- Body -->
            <div class="card-body p-4">
                <form wire:submit.prevent="register">
                    @csrf

                    <!-- First & Last Name -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="fname" class="form-label">First Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text" wire:model.defer="first_name"
                                       class="form-control border-start-0 @error('first_name') is-invalid @enderror"
                                       id="fname" placeholder="John" required>
                            </div>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="lname" class="form-label">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text" wire:model.defer="last_name"
                                       class="form-control border-start-0 @error('last_name') is-invalid @enderror"
                                       id="lname" placeholder="Doe" required>
                            </div>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mt-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-envelope text-muted"></i>
                            </span>
                            <input type="email" wire:model.defer="email"
                                   class="form-control border-start-0 @error('email') is-invalid @enderror"
                                   id="email" placeholder="you@example.com" required>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mt-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-phone text-muted"></i>
                            </span>
                            <input type="tel" wire:model.defer="phone"
                                   class="form-control border-start-0 @error('phone') is-invalid @enderror"
                                   id="phone" placeholder="+254712345678" required>
                        </div>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mt-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-lock text-muted"></i>
                            </span>
                            <input type="password" wire:model.defer="password"
                                   class="form-control border-start-0 @error('password') is-invalid @enderror"
                                   id="password" placeholder="Create a password" required>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-lock text-muted"></i>
                            </span>
                            <input type="password" wire:model.defer="password_confirmation"
                                   class="form-control border-start-0 @error('password_confirmation') is-invalid @enderror"
                                   id="password_confirmation" placeholder="Confirm your password" required>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Button -->
                    <div class="d-grid mt-4">
                        <button class="btn btn-warning btn-lg fw-semibold shadow-sm" type="submit">
                            <i class="fas fa-user-plus me-2"></i> Register
                        </button>
                    </div>

                    <!-- Terms -->
                    <p class="text-center small text-muted mt-3">
                        By registering, you agree to Kaziwira
                        <a href="#" class="text-decoration-none">Terms</a> and
                        <a href="#" class="text-decoration-none">Privacy</a>.
                    </p>
                </form>
            </div>

            <!-- Footer -->
            <div class="card-footer bg-light text-center py-3">
                <span class="text-muted">Already a member?</span>
                <a href="{{ url('/login') }}" class="fw-semibold text-primary text-decoration-none ms-1">Login now</a>
            </div>
        </div>
    </div>
</div>











