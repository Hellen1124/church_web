<div class="min-h-screen flex items-center justify-center bg-gray-50 py-10">
    <div class="w-full max-w-md bg-white shadow-lg rounded-3xl p-6">
        <div class="text-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c.621 0 1.127-.506 1.127-1.127V8.127A1.127 1.127 0 0012 7a1.127 1.127 0 00-1.127 1.127v1.746C10.873 10.494 11.379 11 12 11z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657A8 8 0 116.343 5.343M12 11v5m0 0h.01M12 16h.01" />
            </svg>
            <h2 class="text-2xl font-bold text-gray-800">Create Your Account</h2>
            <p class="text-gray-500 text-sm mt-1">Join us and get started today</p>
        </div>

        <form wire:submit.prevent="register" class="space-y-4">
            @csrf

            <!-- First Name -->
            <div>
                <label for="first_name" class="block text-sm font-semibold text-gray-700">First Name</label>
                <input type="text" wire:model.defer="first_name" id="first_name"
                    class="mt-1 w-full border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2 outline-none"
                    placeholder="John" required>
                @error('first_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Last Name -->
            <div>
                <label for="last_name" class="block text-sm font-semibold text-gray-700">Last Name</label>
                <input type="text" wire:model.defer="last_name" id="last_name"
                    class="mt-1 w-full border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2 outline-none"
                    placeholder="Doe" required>
                @error('last_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700">Email Address</label>
                <input type="email" wire:model.defer="email" id="email"
                    class="mt-1 w-full border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2 outline-none"
                    placeholder="you@example.com" required>
                @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700">Phone Number</label>
                <input type="tel" wire:model.defer="phone" id="phone"
                    class="mt-1 w-full border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2 outline-none"
                    placeholder="+254712345678" required>
                @error('phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                <input type="password" wire:model.defer="password" id="password"
                    class="mt-1 w-full border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2 outline-none"
                    placeholder="Create a password" required>
                @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirm Password</label>
                <input type="password" wire:model.defer="password_confirmation" id="password_confirmation"
                    class="mt-1 w-full border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2 outline-none"
                    placeholder="Confirm your password" required>
                @error('password_confirmation') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Register Button -->
            <div class="pt-3">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition duration-200">
                    <svg wire:loading class="w-5 h-5 mr-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                    Register
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="text-center mt-6 text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Login</a>
        </div>
    </div>
</div>












