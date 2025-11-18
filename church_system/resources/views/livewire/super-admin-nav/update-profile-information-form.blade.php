<form wire:submit.prevent="updateProfileInformation" class="space-y-6">

    {{-- Status Message --}}
    @if ($status)
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded-lg text-sm mb-4">
            <i class="fa fa-check-circle mr-2"></i> {{ $status }}
        </div>
    @endif

    {{-- 1. Profile Photo --}}
    <div class="flex items-center space-x-6">
        <div class="shrink-0">
            @if ($new_photo)
                <img class="h-20 w-20 object-cover rounded-full border-2 border-amber-300" src="{{ $new_photo->temporaryUrl() }}" alt="New Photo Preview">
            @else
                {{-- Uses the user's current photo URL or a fallback --}}
                <img class="h-20 w-20 object-cover rounded-full border-2 border-amber-300" 
                     src="{{ $user->profile_photo_url ?? asset('images/avatar.jpg') }}" 
                     alt="{{ $user->first_name ?? $user->name }}">
            @endif
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>

            {{-- Photo Upload Button --}}
            <input type="file" id="photo-upload" wire:model="new_photo" class="hidden">
            <label for="photo-upload" 
                   class="cursor-pointer inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition">
                <i class="fa fa-upload mr-2"></i>
                {{ $user->profile_photo_path ? 'Change Photo' : 'Upload Photo' }}
            </label>
            
            {{-- Remove Photo Button --}}
            @if ($user->profile_photo_path)
                <button type="button" wire:click="deleteProfilePhoto" wire:confirm="Are you sure you want to remove your profile photo?"
                        class="ml-2 inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 transition">
                    Remove
                </button>
            @endif
            
            @error('new_photo') <span class="block text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- 2. First Name --}}
    <div>
        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
        <input id="first_name" type="text" wire:model="first_name" required autofocus
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500">
        @error('first_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>

    {{-- 3. Email Address --}}
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
        <input id="email" type="email" wire:model="email" required
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500">
        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>
    
    {{-- 4. Role Display (Read-only for Super Admin) --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Current Role</label>
        <p class="mt-1 text-sm font-semibold text-amber-800 bg-amber-200 inline-block px-3 py-1 rounded-full">
            {{ $user->roles->first()->name ?? 'User' }}
        </p>
    </div>

    {{-- Save Button --}}
    <div class="pt-4 border-t border-gray-100 mt-6">
        <button type="submit" 
                class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-lg shadow-md transition">
            <span wire:loading.remove wire:target="updateProfileInformation, new_photo">Save Changes</span>
            <span wire:loading wire:target="updateProfileInformation, new_photo">Updating...</span>
        </button>
    </div>
</form>