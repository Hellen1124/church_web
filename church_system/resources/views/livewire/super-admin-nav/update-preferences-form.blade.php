<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Application Preferences</h2>
    
    <p class="text-sm text-gray-600 mb-4">
        Customize the look and feel of the system and manage your notification settings.
    </p>

    <form wire:submit.prevent="updatePreferences" class="space-y-6">

        {{-- Status Message --}}
        @if ($status)
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded-lg text-sm mb-4">
                <i class="fa fa-check-circle mr-2"></i> {{ $status }}
            </div>
        @endif
        
        <div class="space-y-4">
            
            {{-- 1. Theme Selection --}}
            <div>
                <label for="theme" class="block text-sm font-medium text-gray-700 mb-1">Default Theme</label>
                <p class="text-xs text-gray-500 mb-2">Choose between a light or dark interface theme.</p>
                <div class="flex space-x-6">
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="theme" value="light" 
                               class="form-radio text-amber-600 border-gray-300 focus:ring-amber-500">
                        <span class="ml-2 text-sm text-gray-700">Light</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="theme" value="dark" 
                               class="form-radio text-amber-600 border-gray-300 focus:ring-amber-500">
                        <span class="ml-2 text-sm text-gray-700">Dark</span>
                    </label>
                </div>
                @error('theme') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            
            <div class="border-t border-gray-100 pt-4"></div>

            {{-- 2. Email Notifications (Toggle Switch) --}}
            <div class="flex items-center justify-between">
                <div>
                    <label for="notifications_enabled" class="block text-sm font-medium text-gray-700">Email Notifications</label>
                    <p class="text-xs text-gray-500">Receive system alerts and updates via email.</p>
                </div>
                
                {{-- Toggle Switch using Tailwind/Alpine pattern --}}
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model="notifications_enabled" id="notifications_enabled" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                </label>
                
                @error('notifications_enabled') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            
        </div>

        {{-- Save Button --}}
        <div class="pt-4 border-t border-gray-100 mt-6">
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-lg shadow-md transition">
                <span wire:loading.remove wire:target="updatePreferences">Save Preferences</span>
                <span wire:loading wire:target="updatePreferences">Saving...</span>
            </button>
        </div>
    </form>
</div>
