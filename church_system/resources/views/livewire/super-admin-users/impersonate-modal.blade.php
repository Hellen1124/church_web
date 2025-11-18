<div>
    @if($showModal)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center z-50 p-4" x-data="{ open: @entangle('showModal') }" x-show="open" x-transition.opacity>
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm" x-transition.duration.300ms>
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2 flex items-center gap-2">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.332 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Confirm Impersonation
                    </h2>
                    <p class="text-gray-600 mb-6 text-sm">You are about to enter this user's account. This action is typically logged. Do you wish to proceed?</p>
                    <div class="flex justify-end gap-3">
                        <button wire:click.prevent="$set('showModal', false)" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition text-sm font-medium">
                            Cancel
                        </button>
                        <button wire:click.prevent="impersonate" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition shadow-md text-sm font-medium">
                            Proceed to Impersonate
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
