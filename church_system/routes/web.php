<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Registration;
use App\Http\Controllers\AuthController;
use App\Livewire\Auth\VerifyOtpForm;
use App\Livewire\Auth\RegisterForm;
use App\Livewire\Dashboard\Home;
use App\Livewire\Auth\LoginForm;
use App\Livewire\Auth\ForgotPasswordForm;
use App\Livewire\Tenant\ListTenants;
use App\Livewire\Tenant\CreateTenants;
use App\Livewire\Tenant\EditTenant;







ROute::get('/', function () {
    return view('welcome');
})->name('home');

// registration routes
Route::get('/register', RegisterForm::class)->name('register');


// OTP verification route
Route::get('/otp/verify/{phone}', VerifyOtpForm::class)->name('otp.verify');

// Login route
Route::get('/login', LoginForm::class)->name('login');
// Request password reset route
Route::get('/password/forgot', ForgotPasswordForm::class)->name('sendResetLink');





Route::middleware(['auth'])->group(function () {

    Route::get('/tenants/{tenant}/edit', EditTenant::class)->name('tenants.edit');
    Route::get('/tenants/create', CreateTenants::class)->name('tenants.create');
    Route::get('/tenants', ListTenants::class)->name('tenants.index');
    


    Route::get('/dashboard', Home::class)->name('dashboard');
});