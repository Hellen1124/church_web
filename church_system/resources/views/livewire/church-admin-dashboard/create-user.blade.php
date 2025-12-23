<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow">

    {{-- Header --}}
    <div class="mb-6 border-b pb-4">
        <h2 class="text-xl font-semibold text-gray-800">
            Create Church User
        </h2>
        <p class="text-sm text-gray-500">
            This will create a church member with system access and an assigned role.
        </p>
    </div>

    {{-- Form --}}
    <form wire:submit.prevent="saveUser" class="space-y-6">

        {{-- Personal Information --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- First Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    First Name
                </label>
                <input
                    type="text"
                    wire:model.defer="first_name"
                    autocomplete="given-name"
                    class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-200
                        @error('first_name') border-red-500 @enderror"
                >
                @error('first_name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Last Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Last Name
                </label>
                <input
                    type="text"
                    wire:model.defer="last_name"
                    autocomplete="family-name"
                    class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-200
                        @error('last_name') border-red-500 @enderror"
                >
                @error('last_name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Contact Information --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email Address
                </label>
                <input
                    type="email"
                    wire:model.defer="email"
                    autocomplete="email"
                    class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-200
                        @error('email') border-red-500 @enderror"
                >
                @error('email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Phone Number
                </label>
                <input
                    type="tel"
                    wire:model.defer="phone"
                    autocomplete="tel"
                    class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-200
                        @error('phone') border-red-500 @enderror"
                >
                @error('phone')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Role Selection --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                System Role
            </label>
            <select
                wire:model.defer="selectedRole"
                class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-200
                    @error('selectedRole') border-red-500 @enderror"
            >
                @foreach($availableRoles as $role)
                    <option value="{{ $role['value'] }}">
                        {{ $role['label'] }}
                    </option>
                @endforeach
            </select>
            @error('selectedRole')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Security --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Password
                </label>
                <input
                    type="password"
                    wire:model.defer="password"
                    autocomplete="new-password"
                    class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-200
                        @error('password') border-red-500 @enderror"
                >
                @error('password')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Confirm Password
                </label>
                <input
                    type="password"
                    wire:model.defer="password_confirmation"
                    autocomplete="new-password"
                    class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
                >
            </div>

        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-4 pt-6 border-t">

            <button
                type="button"
                wire:click="$reset"
                class="px-4 py-2 text-sm rounded-md border border-gray-300
                    text-gray-700 hover:bg-gray-100"
            >
                Reset
            </button>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="saveUser"
                class="relative inline-flex items-center justify-center
                       px-6 py-2 text-sm font-semibold rounded-md
                       bg-blue-600 text-white hover:bg-blue-700
                       disabled:opacity-60 disabled:cursor-not-allowed"
            >
                {{-- Normal State --}}
                <span wire:loading.remove wire:target="saveUser">
                    Create User
                </span>

                {{-- Loading State --}}
                <span wire:loading wire:target="saveUser" class="flex items-center gap-2">
                    <svg
                        class="animate-spin h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v8z"
                        ></path>
                    </svg>
                    Creating...
                </span>
            </button>

        </div>

    </form>

</div>

