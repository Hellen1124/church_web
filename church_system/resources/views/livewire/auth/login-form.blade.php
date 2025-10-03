<div class="max-w-md mx-auto p-6">
    <x-card>
        <x-slot name="header">
            <h2 class="text-lg font-bold">Login</h2>
        </x-slot>

        {{-- Phone --}}
        <x-input
            wire:model.defer="phone"
            label="Phone Number"
            placeholder="+15551234567"
            class="mb-4"
        />
        @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

        {{-- Password --}}
        <x-input
            type="password"
            wire:model.defer="password"
            label="Password"
            placeholder="********"
            class="mb-4"
        />
        @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

        {{-- Login Button --}}
        <x-button
            wire:click="login"
            primary
            spinner="login"
            label="Login"
            class="w-full"
        />

        <div class="mt-4 text-sm text-gray-600 text-center">
            Don’t have an account?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
        </div>
    </x-card>
</div>
