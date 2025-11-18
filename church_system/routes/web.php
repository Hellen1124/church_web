<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdmin\ChurchController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\UsersController;
use App\Http\Controllers\SuperAdmin\RoleManagerController;
use App\Http\Controllers\SuperAdmin\ProfileManagerController;
use App\Livewire\Dashboard\Home;
use App\Livewire\Registration;
use App\Livewire\Auth\VerifyOtpForm;
use App\Livewire\Auth\RegisterForm;
use App\Livewire\Auth\LoginForm;
use App\Livewire\Auth\ForgotPasswordForm;
use App\Livewire\Tenant\ListTenants;
use App\Livewire\Tenant\CreateTenants;
use App\Livewire\Tenant\EditTenant;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// Serve favicon.ico directly
Route::get('/favicon.ico', function () {
    return response()->file(public_path('favicon.ico'));
});

// Ignore Chrome DevTools .well-known requests
Route::get('/.well-known/{any}', function () {
    return response()->noContent(); // 204 No Content
})->where('any', '.*');

// 🌐 Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/register', RegisterForm::class)->name('register');
Route::get('/otp/verify/{phone}', VerifyOtpForm::class)->name('otp.verify');
Route::get('/login', LoginForm::class)->name('login');
Route::get('/password/forgot', ForgotPasswordForm::class)->name('sendResetLink');

// 🔐 Authenticated Routes for admins
// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', Home::class)->name('dashboard');
// });

// 🛡️ System Admin Routes (with permission middleware)
Route::prefix('system-admin')->group(function () {

    Route::middleware('permission:view main dashboard')
        ->get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
        Route::get('/settings', fn() => view('settings'))->name('settings');

    Route::middleware('permission:manage users')
        ->get('/users',  [UsersController::class, 'index'])
        ->name('system-admin.users.index');    

    // Group routes by permission
    Route::middleware('permission:view tenants')->group(function () {
        Route::get('/churches', [ChurchController::class, 'index'])->name('system-admin.church.index');
    });

    Route::middleware('permission:create tenants')->group(function () {
        Route::get('/churches/create', [ChurchController::class, 'create'])->name('system-admin.church.create');
    });

    // Always put the parameterized route last
    Route::middleware('permission:view tenants')->group(function () {
        Route::get('/churches/{church}', [ChurchController::class, 'show'])->name('system-admin.church.show');
    });

   
    Route::middleware('permission:manage roles')->group(function () {
        Route::get('/role-manager', [RoleManagerController::class, 'index'])
            ->name('system-admin.rolemanager.index');
    });

    Route::middleware('permission:manage profile')->group(function () {
        Route::get('/profile', [ProfileManagerController::class, 'show'])
            ->name('system-admin.profile.show');
    });
     
});



