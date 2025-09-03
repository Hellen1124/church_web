@extends('layouts.login')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="card shadow-lg border-0 rounded-3" style="max-width: 420px; width:100%;">
        <div class="card-body p-4 p-sm-5">
            
            <!-- Logo -->
            <div class="text-center mb-4">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" width="100">
                <h5 class="mt-3 fw-bold text-dark">Welcome Back</h5>
                <p class="text-muted small">Login to continue to Toshaserve</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ url('/auth/loginuser') }}">
                @csrf

                <!-- Phone -->
                <div class="mb-3">
                    
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="text" name="mobile" id="mobile" class="form-control" 
                            placeholder="Enter phone number" required>
                    </div>
                </div>

                <!-- OTP (Password) -->
                <div class="mb-3">
                    
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" name="password" id="password" class="form-control" 
                            placeholder="Enter OTP" required>
                    </div>
                </div>

                <!-- Remember Me + Forgot -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input id="remember-me" name="remember" class="form-check-input" type="checkbox">
                        <label for="remember-me" class="form-check-label">Remember Me</label>
                    </div>
                    <a href="#" class="small text-decoration-none">Forgot OTP?</a>
                </div>

                <!-- Submit -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-warning fw-semibold shadow-sm">Sign In</button>
                </div>
            </form>

            <!-- Divider -->
            <div class="d-flex align-items-center my-4">
                <hr class="flex-grow-1">
                <span class="mx-2 text-muted small">OR</span>
                <hr class="flex-grow-1">
            </div>

            <!-- Sign Up -->
            <div class="text-center">
                <p class="small mb-0">New to Toshaserve? 
                    <a href="{{ route('register.form') }}" class="fw-bold text-warning">Sign up now</a>

                </p>
            </div>
        </div>
    </div>
</div>
@endsection
