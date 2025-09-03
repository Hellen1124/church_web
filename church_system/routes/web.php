<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Registration;
use App\Livewire\Login;

Route::get('/', function () {
    return view('livewire/login');
});

// Auth and First time OTP Routes
Route::prefix('auth')->group(function () {
    Route::get('/registration', [AuthController::class, 'OTP'])->name('auth.otp');
    Route::get('/verifyotp', [SMSController::class, 'verify'])->name('auth.verifyotp');
    Route::get('/login', [AuthController::class, 'register'])->name('auth.registration');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});



Route::get('/register', Registration::class)->name('register.form');


Route::get('/login', Login::class)->name('login.form');
