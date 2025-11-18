<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        Log::info('Login attempt', ['input_phone' => $this->phone]);

        // Normalize the phone number to local format
        $localPhone = $this->normalizePhone($this->phone);

        // Generate international format only for validation
        $intlPhone = '+254' . substr($localPhone, 1);

        try {
            $this->validate();

            // Validate the phone number format using intl form (phone:KE)
            if (!app('validator')->make(['phone' => $intlPhone], ['phone' => 'phone:KE'])->passes()) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'phone' => ['Invalid Kenyan phone number format.'],
                ]);
            }

            Log::info('Validation passed', ['normalized_phone' => $localPhone]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            throw $e;
        }

        // Check if the user exists
        $user = \App\Models\User::where('phone', $localPhone)->first();
        if (!$user) {
            Log::warning('User not found', ['phone' => $localPhone]);

            $this->notification()->error(
                title: 'Login Failed',
                description: 'No account found with this phone number.'
            );

            return;
        }

        // Attempt authentication
        if (Auth::attempt(['phone' => $localPhone, 'password' => $this->password])) {

             $user->forcefill([
                'last_login_at' =>now(),
             ])->save();

            Log::info('Auth successful', ['user_id' => Auth::id(), 'phone' => $localPhone]);

            $this->notification()->success(
                title: 'Welcome Back!',
                description: 'You have successfully logged in.'
            );

            return redirect()->route('dashboard');
        }

        Log::warning('Auth failed', ['phone' => $localPhone]);

        $this->notification()->error(
            title: 'Login Failed',
            description: 'Invalid phone number or password. Please try again.'
        );
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
