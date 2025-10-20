<div class="min-h-screen flex items-center justify-center bg-gray-50 py-10">
    <div class="w-full max-w-md bg-white shadow-lg rounded-3xl p-6">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Forgot Your Password?</h2>
            <p class="text-gray-500 text-sm mt-1">Enter your email to receive a password reset link</p>
        </div>

        <form wire:submit.prevent="sendResetLink" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700">Email Address</label>
                <input type="email" wire:model.defer="email" id="email"
                    class="mt-1 w-full border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2 outline-none"
                    placeholder="you@example.com" required>
                @error('email') 
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Reset Button -->
            <div class="pt-3">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition duration-200">
                    Send Reset Link
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="text-center mt-6 text-sm text-gray-600">
            <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">
                Back to Login
            </a>
        </div>
    </div>
</div>
