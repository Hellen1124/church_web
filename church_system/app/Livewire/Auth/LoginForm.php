<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class LoginForm extends Component
{
    use WireUiActions;

    public string $phone = '';
    public string $password = '';

    protected $rules = [
        'phone' => 'required',
        'password' => 'required|string|min:6',
    ];

    /**
     * Normalize phone number to local 0XXXXXXXXX format (Kenya)
     */
    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\s+/', '', $phone); // remove spaces

        // Convert international or numeric forms to local format
        if (Str::startsWith($phone, '+254')) {
            $phone = '0' . substr($phone, 4);
        } elseif (Str::startsWith($phone, '254')) {
            $phone = '0' . substr($phone, 3);
        }

        return $phone;
    }

public function login()
{
    Log::info('Login attempt started', ['input_phone' => $this->phone]);

    // 1. Normalize phone number
    $localPhone = $this->normalizePhone($this->phone);
    $intlPhone  = '+254' . substr($localPhone, -9);

    // 2. Validate form + Kenyan phone format
    try {
        $this->validate();

        if (!app('validator')->make(['phone' => $intlPhone], ['phone' => 'phone:KE'])->passes()) {
            throw ValidationException::withMessages([
                'phone' => 'Please enter a valid Kenyan phone number (e.g. 0712345678).',
            ]);
        }
    } catch (ValidationException $e) {
        Log::error('Login validation failed', ['errors' => $e->errors()]);
        throw $e;
    }

    // 3. Find user
    $user = User::where('phone', $localPhone)->first();

    if (!$user) {
        Log::warning('Login failed – user not found', ['phone' => $localPhone]);

        $this->notification()->error(
            title: 'Login Failed',
            description: 'No account found with this phone number.'
        );
        return;
    }

    // 4. Attempt authentication
    if (!Auth::attempt(['phone' => $localPhone, 'password' => $this->password], $this->remember ?? false)) {
        Log::warning('Login failed – invalid password', ['user_id' => $user->id]);

        RateLimiter::hit($this->throttleKey());

        $this->notification()->error(
            title: 'Login Failed',
            description: 'Incorrect password.'
        );
        return;
    }

    // 5. Update login timestamp
    $user->forceFill([
        'last_login_at' => now(),
    ])->save();

    Log::info('Login successful', [
        'user_id'   => $user->id,
        'tenant_id' => $user->tenant_id,
        'roles'     => $user->getRoleNames(),
    ]);

    $this->notification()->success(
        title: 'Welcome back!',
        description: 'You have successfully logged in.'
    );

    /*
    |--------------------------------------------------------------------------
    | ROLE + TENANCY AWARE REDIRECT (FINAL)
    |--------------------------------------------------------------------------
    */

    if (is_null($user->tenant_id)) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('church-admin')) {
        return redirect()->route('church.dashboard');
    }

    if ($user->hasRole('church-treasurer')) {
        return redirect()->route('finance.dashboard');
    }

    // Absolute safety fallback
    Auth::logout();
    abort(403, 'Unauthorized role.');
}


    public function forgotPassword()
    {
        $this->notification()->info(
            title: 'Password Reset',
            description: 'Password reset functionality not yet implemented.'
        );
    }

    public function render()
    {
        return view('livewire.auth.login-form')
            ->layout('layouts.app');
    }
}
