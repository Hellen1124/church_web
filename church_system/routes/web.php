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
| Utility / Browser Noise
|--------------------------------------------------------------------------
*/
Route::get('/favicon.ico', fn () =>
    response()->file(public_path('favicon.ico'))
);

Route::get('/.well-known/{any}', fn () =>
    response()->noContent()
)->where('any', '.*');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::view('/', 'welcome')->name('home');
Route::view('/system-portal', 'Landing')->name('system.portal');

/*
|--------------------------------------------------------------------------
| Authentication (Livewire)
|--------------------------------------------------------------------------
*/
Route::get('/login', \App\Livewire\Auth\LoginForm::class)->name('login');
Route::get('/register', \App\Livewire\Auth\RegisterForm::class)->name('register');
Route::get('/otp/verify/{phone}', \App\Livewire\Auth\VerifyOtpForm::class)->name('otp.verify');
Route::get('/password/forgot', \App\Livewire\Auth\ForgotPasswordForm::class)->name('sendResetLink');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | System Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('system-admin')->group(function () {

        Route::middleware('permission:view main dashboard')
            ->get('/dashboard',
                [\App\Http\Controllers\SystemAdmin\DashboardController::class, 'index']
            )->name('admin.dashboard');

        Route::middleware('permission:manage users')
            ->get('/users',
                [\App\Http\Controllers\SystemAdmin\UsersController::class, 'index']
            )->name('system-admin.users.index');

        Route::middleware('permission:view tenants')
            ->get('/churches',
                [\App\Http\Controllers\SystemAdmin\ChurchController::class, 'index']
            )->name('system-admin.church.index');

        Route::middleware('permission:create tenants')
            ->get('/churches/create',
                [\App\Http\Controllers\SystemAdmin\ChurchController::class, 'create']
            )->name('system-admin.church.create');

        Route::middleware('permission:view tenants')
            ->get('/churches/{church}',
                [\App\Http\Controllers\SystemAdmin\ChurchController::class, 'show']
            )->name('system-admin.church.show');

        Route::middleware('permission:manage roles')
            ->get('/role-manager',
                [\App\Http\Controllers\SystemAdmin\RoleManagerController::class, 'index']
            )->name('system-admin.rolemanager.index');

        Route::middleware('permission:manage profile')
            ->get('/profile',
                [\App\Http\Controllers\SystemAdmin\ProfileManagerController::class, 'show']
            )->name('system-admin.profile.show');

        Route::post('/logout',
            [\App\Http\Controllers\Auth\AuthController::class, 'logout']
        )->name('logout');
    });

    /*
    |--------------------------------------------------------------------------
    | Church Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('church-admin')
        ->middleware('role:church-admin')
        ->group(function () {

        Route::get('/dashboard',
            [\App\Http\Controllers\ChurchAdmin\DashboardController::class, 'index']
        )->name('church.dashboard');

        Route::middleware('permission:view members')
            ->get('/members',
                [\App\Http\Controllers\ChurchAdmin\MembersController::class, 'index']
            )->name('church.members.index');

        Route::middleware('permission:create members')
            ->get('/members/create',
                [\App\Http\Controllers\ChurchAdmin\MembersController::class, 'create']
            )->name('church.members.create');

        Route::middleware('permission:update members')
            ->get('/members/{member}/edit',
                [\App\Http\Controllers\ChurchAdmin\MembersController::class, 'edit']
            )->name('church.members.edit');

        Route::middleware('permission:delete members')
            ->delete('/members/{member}',
                [\App\Http\Controllers\ChurchAdmin\MembersController::class, 'destroy']
            )->name('church.members.destroy');

        Route::middleware('permission:manage members')
            ->get('/members/{member}',
                [\App\Http\Controllers\ChurchAdmin\MembersController::class, 'show']
            )->name('church.members.show');

        Route::middleware('permission:view finance')
            ->get('/collections',
                [\App\Http\Controllers\ChurchAdmin\SundayCollectionController::class, 'index']
            )->name('church.offerings.index');

        Route::middleware('permission:manage finance')
            ->get('/offerings/create',
                [\App\Http\Controllers\ChurchAdmin\OfferingsController::class, 'create']
            )->name('church.offerings.create');

        Route::middleware('permission:view reports')
            ->get('/financial-reports',
                [\App\Http\Controllers\ChurchAdmin\FinancialReportController::class, 'index']
            )->name('church.financialreports.index');
    });

    /*
    |--------------------------------------------------------------------------
    | Church Treasurer Routes ✅
    |--------------------------------------------------------------------------
    */
    Route::prefix('church-treasurer')
        ->middleware('role:church-treasurer')
        ->group(function () {

        Route::get('/dashboard',
            [\App\Http\Controllers\FinanceAdmin\DashboardController::class, 'index']
        )->name('finance.dashboard');

        Route::middleware('permission:view finance')
            ->get('/collections',
                [\App\Http\Controllers\FinanceAdmin\CollectionController::class, 'index']
            )->name('finance.collections.index');

        Route::middleware('permission:manage finance')
            ->get('/expenses',
                [\App\Http\Controllers\FinanceAdmin\ExpenseController::class, 'index']
            )->name('finance.expenses.index');
            
    });
});
