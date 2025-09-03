@extends('layouts.registration')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="card shadow-lg border-0 rounded-3" style="max-width: 500px; width:100%;">
        <div class="card-body p-4 p-sm-5">
            
            <!-- Logo -->
            <div class="text-center mb-4">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" width="100">
                <h5 class="mt-3 fw-bold text-dark">Create Account</h5>
                <p class="text-muted small">Register to join Toshaserve</p>
            </div>

            <!-- Registration Form -->
            <form method="POST" action="{{ url('/otp/send') }}">
                @csrf

                <!-- First Name -->
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" required>
                    </div>
                </div>

                <!-- Middle Name -->
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="mname" id="mname" class="form-control" placeholder="Middle Name (optional)">
                    </div>
                </div>

                <!-- Last Name -->
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="lname" id="lname" class="form-control" placeholder="Last Name" required>
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required>
                    </div>
                </div>

                <!-- Phone -->
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Phone Number" required>
                    </div>
                </div>

                <!-- Submit -->
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-warning fw-semibold shadow-sm">Send me an OTP</button>
                </div>
                <p class="text-center text-muted small mt-2">
                    You agree to Toshaserve <a class="text-warning" href="#">Terms</a> and 
                    <a class="text-warning" href="#">Privacy</a>
                </p>
            </form>

            <!-- Divider -->
            <div class="d-flex align-items-center my-4">
                <hr class="flex-grow-1">
                <span class="mx-2 text-muted small">OR</span>
                <hr class="flex-grow-1">
            </div>

            <!-- Social Signup -->
            <div class="d-flex justify-content-center mb-3">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <a href="#" class="btn btn-outline-primary btn-sm rounded-circle">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#" class="btn btn-outline-info btn-sm rounded-circle">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#" class="btn btn-outline-danger btn-sm rounded-circle">
                            <i class="fab fa-google"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#" class="btn btn-outline-primary btn-sm rounded-circle">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <p class="small mb-0">Already have an account? 
                    <a href="{{ route('login.form') }}" class="fw-bold text-warning">Login now</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection


