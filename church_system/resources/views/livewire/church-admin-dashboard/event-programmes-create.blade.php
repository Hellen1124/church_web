<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <header class="pb-6 border-b border-gray-200">
        <h2 class="text-3xl font-extrabold text-gray-900">
            @if ($event->exists)
                <i class="fas fa-edit text-amber-600 text-3xl mr-3 inline-block align-middle"></i> Edit Event: {{ $event->name }}
            @else
                <i class="fas fa-calendar-plus text-amber-600 text-3xl mr-3 inline-block align-middle"></i> Create New Event
            @endif
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Define all the essential details for this programme, including time, location, and capacity.
        </p>
    </header>

    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-8 mt-6 bg-white p-6 rounded-xl shadow-lg border border-gray-100">
        
        <div class="grid grid-cols-6 gap-6">

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Event Name</label>
                <input wire:model.blur="name" type="text" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-2.5">
                @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <!-- Location -->
            <div class="col-span-6 sm:col-span-2">
                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                <input wire:model.blur="location" type="text" id="location" placeholder="e.g., Sanctuary, Zoom, Field" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-2.5">
                @error('location') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            
            <!-- Start Time -->
            <div class="col-span-6 sm:col-span-3">
                <label for="start_at" class="block text-sm font-medium text-gray-700">Start Date & Time</label>
                <input wire:model.blur="start_at" type="datetime-local" id="start_at" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-2.5">
                @error('start_at') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <!-- End Time -->
            <div class="col-span-6 sm:col-span-3">
                <label for="end_at" class="block text-sm font-medium text-gray-700">End Date & Time</label>
                <input wire:model.blur="end_at" type="datetime-local" id="end_at" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-2.5">
                @error('end_at') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <!-- Description -->
            <div class="col-span-6">
                <label for="description" class="block text-sm font-medium text-gray-700">Description / Details</label>
                <div class="mt-1">
                    <textarea wire:model.blur="description" id="description" rows="5" class="shadow-sm focus:ring-amber-500 focus:border-amber-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md p-2.5" placeholder="Provide a detailed summary of the event..."></textarea>
                </div>
                @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <!-- Capacity -->
            <div class="col-span-6 sm:col-span-3">
                <label for="capacity" class="block text-sm font-medium text-gray-700">Max Capacity (Optional)</label>
                <input wire:model.blur="capacity" type="number" id="capacity" min="1" placeholder="e.g., 50" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-2.5">
                <p class="mt-2 text-xs text-gray-500">Leave blank for unlimited capacity.</p>
                @error('capacity') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            
            <!-- Is Public Toggle -->
            <div class="col-span-6 sm:col-span-3 flex items-end">
                <div class="flex items-center space-x-3 h-10">
                    <input wire:model="is_public" id="is_public" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                    <label for="is_public" class="text-sm font-medium text-gray-700">
                        Public Event (Visible to everyone)
                    </label>
                </div>
                @error('is_public') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

        </div>

        <!-- --- FORM ACTIONS --- -->
        <div class="pt-5 border-t border-gray-200 flex justify-end">
            <a href="#" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-150">
                Cancel
            </a>
            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-150">
                <span wire:loading.remove wire:target="save">
                    <i class="fas fa-save mr-1"></i> 
                    @if ($event->exists) Save Changes @else Create Event @endif
                </span>
                <span wire:loading wire:target="save">
                    <i class="fas fa-spinner fa-spin mr-1"></i> Saving...
                </span>
            </button>
        </div>
    </form>
</div>
