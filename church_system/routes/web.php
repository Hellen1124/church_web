<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Registration;
use App\Http\Controllers\AuthController;
use App\Livewire\Auth\VerifyOtpForm;
use App\Livewire\Auth\RegisterForm;
use App\Livewire\Dashboard\Home;
use App\Livewire\Auth\LoginForm;







ROute::get('/', function () {
    return view('welcome');
})->name('home');

// registration routes
Route::get('/register', RegisterForm::class)->name('register');


// OTP verification route
Route::get('/otp/verify/{phone}', VerifyOtpForm::class)->name('otp.verify');

// Login route
Route::get('/login', LoginForm::class)->name('login');





Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Home::class)->name('dashboard');
});