<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Update Password</h2>
    
    <p class="text-sm text-gray-600 mb-4">
        Ensure your account is using a long, random password to stay secure.
    </p>

    <form wire:submit.prevent="updatePassword" class="space-y-6">

        {{-- Status Message --}}
        @if ($status)
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded-lg text-sm mb-4">
                <i class="fa fa-check-circle mr-2"></i> {{ $status }}
            </div>
        @endif

        {{-- Current Password --}}
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
            <input id="current_password" type="password" wire:model.defer="state.current_password" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500">
            @error('state.current_password', 'updatePassword') 
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
            @enderror
        </div>

        {{-- New Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
            <input id="password" type="password" wire:model.defer="state.password" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500">
            @error('state.password', 'updatePassword') 
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input id="password_confirmation" type="password" wire:model.defer="state.password_confirmation" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500">
            @error('state.password_confirmation', 'updatePassword') 
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
            @enderror
        </div>

        {{-- Save Button --}}
        <div class="pt-4 border-t border-gray-100 mt-6">
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-lg shadow-md transition">
                <span wire:loading.remove wire:target="updatePassword">Save New Password</span>
                <span wire:loading wire:target="updatePassword">Saving...</span>
            </button>
        </div>
    </form>
</div>