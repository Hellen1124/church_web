<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    <!-- HEADER -->
    <header class="pb-6 mb-8 border-b border-gray-200">
        <!-- Back Button -->
        <a href="{{ route('church.events.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-amber-600 transition duration-150 mb-4 rounded-full p-2 -ml-2 hover:bg-gray-50">
            <x-lucide-chevron-left class="w-5 h-5 mr-1" />
            Back to Events List
        </a>
        <h2 class="text-4xl font-extrabold text-gray-900 flex items-center gap-3">
            @if ($event->exists)
                <x-lucide-edit-3 class="w-8 h-8 text-amber-600" />
                Edit Event: <span class="text-amber-700 truncate">{{ $event->name }}</span>
            @else
                <x-lucide-calendar-plus class="w-8 h-8 text-amber-600" />
                Create New Event
            @endif
        </h2>
        <p class="mt-2 text-md text-gray-500">
            Define all the essential details for this programme, including time, location, and capacity.
        </p>
    </header>

    {{-- Success Notification --}}
    @if (session()->has('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-xl shadow-md" role="alert">
            <p class="font-medium flex items-center gap-2">
                <x-lucide-check-circle class="w-5 h-5" /> {{ session('success') }}
            </p>
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-10 mt-6 bg-white p-8 rounded-3xl shadow-2xl border border-gray-100">

        <!-- SECTION 1: BASIC INFORMATION -->
        <div>
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2 mb-4 pb-2 border-b">
                <x-lucide-info class="w-5 h-5 text-gray-400" />
                Basic Information
            </h3>
            <div class="grid grid-cols-6 gap-6">

                <!-- Name -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Event Name</label>
                    <input wire:model.blur="name" type="text" id="name" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3" placeholder="e.g., End of Year Youth Bash">
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Location -->
                <div class="col-span-6 sm:col-span-2">
                    <label for="location" class="block text-sm font-semibold text-gray-700 mb-1">Location</label>
                    <input wire:model.blur="location" type="text" id="location" placeholder="Sanctuary, Zoom, Field" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3">
                    @error('location') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div class="col-span-6">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Description / Details</label>
                    <div class="mt-1">
                        <textarea wire:model.blur="description" id="description" rows="5" class="shadow-sm focus:ring-amber-500 focus:border-amber-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-xl p-3" placeholder="Provide a detailed summary of the event..."></textarea>
                    </div>
                    @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- SECTION 2: EVENT SCHEDULE (Focus on your requested area) -->
        <div class="pt-8 border-t border-gray-100">
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2 mb-4 pb-2 border-b">
                <x-lucide-clock class="w-5 h-5 text-gray-400" />
                Event Schedule
            </h3>
            <p class="text-sm text-gray-500 mb-6 -mt-2">
                Specify both the date and the time (including AM/PM) for the start and end of the event. Single-day events are supported.
            </p>
            <div class="grid grid-cols-6 gap-6">

                <!-- Start Time -->
                <div class="col-span-6 sm:col-span-3">
                    <label for="start_at" class="block text-sm font-semibold text-gray-700 mb-1">Start Date & Time</label>
                    {{-- Using datetime-local allows the browser UI to handle AM/PM selection cleanly --}}
                    <input wire:model.blur="start_at" type="datetime-local" id="start_at" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3">
                    @error('start_at') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- End Time -->
                <div class="col-span-6 sm:col-span-3">
                    <label for="end_at" class="block text-sm font-semibold text-gray-700 mb-1">End Date & Time</label>
                    <input wire:model.blur="end_at" type="datetime-local" id="end_at" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3">
                    @error('end_at') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- SECTION 3: ATTENDANCE & VISIBILITY -->
        <div class="pt-8 border-t border-gray-100">
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2 mb-4 pb-2 border-b">
                <x-lucide-sliders class="w-5 h-5 text-gray-400" />
                Attendance & Visibility
            </h3>
            <div class="grid grid-cols-6 gap-6 items-start">
                
                <!-- Capacity -->
                <div class="col-span-6 sm:col-span-3">
                    <label for="capacity" class="block text-sm font-semibold text-gray-700 mb-1">Max Capacity (Optional)</label>
                    <input wire:model.blur="capacity" type="number" id="capacity" min="1" placeholder="e.g., 50" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3">
                    <p class="mt-2 text-xs text-gray-500">Leave blank for unlimited capacity.</p>
                    @error('capacity') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                
                <!-- Is Public Toggle -->
                <div class="col-span-6 sm:col-span-3 mt-4 sm:mt-0">
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl border border-gray-200">
                        <input wire:model="is_public" id="is_public" type="checkbox" class="h-5 w-5 rounded border-gray-300 text-amber-600 focus:ring-amber-500 shadow-sm">
                        <label for="is_public" class="text-base font-semibold text-gray-700 flex items-center gap-2">
                            Public Event
                        </label>
                        <p class="text-xs text-gray-500">(Visible to all)</p>
                    </div>
                    @error('is_public') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- --- FORM ACTIONS --- -->
        <div class="pt-6 border-t border-gray-200 flex justify-end gap-3">
            <a href="#" class="py-2.5 px-6 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                Cancel
            </a>
            
            <button type="submit" class="py-2.5 px-6 border border-transparent shadow-md text-sm font-medium rounded-xl text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-150 transform active:scale-95">
                <span wire:loading.remove wire:target="save" class="flex items-center gap-1">
                    <x-lucide-save class="w-4 h-4" />
                    @if ($event->exists) Save Changes @else Create Event @endif
                </span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <x-lucide-loader-2 class="w-4 h-4 animate-spin" /> Saving...
                </span>
            </button>
        </div>
    </form>
</div>
