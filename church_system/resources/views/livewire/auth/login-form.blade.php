<div class="flex min-h-screen items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8 space-y-6">
        <!-- Header -->
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c.621 0 1.127-.506 1.127-1.127V8.127A1.127 1.127 0 0012 7a1.127 1.127 0 00-1.127 1.127v1.746C10.873 10.494 11.379 11 12 11z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657A8 8 0 116.343 5.343M12 11v5m0 0h.01M12 16h.01" />
            </svg>
            <h2 class="mt-4 text-2xl font-semibold text-gray-800">Welcome Back</h2>
            <p class="text-gray-500 text-sm">Sign in to your account to continue</p>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="login">
            <!-- Phone Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input
                    type="text"
                    wire:model.defer="phone"
                    placeholder="e.g. +254712345678"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                />
                @error('phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input
                    type="password"
                    wire:model.defer="password"
                    placeholder="********"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                />
                @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="flex items-center justify-center w-full py-2.5 px-4 text-white bg-blue-600 hover:bg-blue-700 rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-blue-300"
                >
                    <svg wire:loading class="w-5 h-5 mr-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span>Login</span>
                </button>
            </div>
        </form>

        <!-- Forgot Password -->
        <div class="text-right">
            <button
                wire:click="forgotPassword"
                type="button"
                class="text-sm text-blue-600 hover:text-blue-800 hover:underline"
            >
                Forgot Password?
            </button>
        </div>

        <!-- Footer -->
        <div class="text-center text-sm text-gray-600">
            Don’t have an account?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">Register</a>
        </div>
    </div>
</div>
