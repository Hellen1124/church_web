<div class="p-6 bg-stone-50 min-h-screen">
<div class="max-w-4xl mx-auto space-y-10">

    <!-- Header -->
    <div class="flex items-center justify-between gap-6 pb-6 border-b border-amber-100">
        <h2 class="text-3xl font-bold text-amber-900 flex items-center gap-3">
            <x-lucide-edit class="w-8 h-8 text-amber-600" />
            Edit Event: {{ $name }}
        </h2>
        <a href="{{ route('church.events.index') }}"
            class="inline-flex items-center gap-2 text-amber-600 hover:text-amber-800 transition">
            <x-lucide-arrow-left class="w-4 h-4" />
            Back to Events List
        </a>
    </div>

    <!-- Event Form -->
    <form wire:submit.prevent="updateEvent" class="bg-white rounded-2xl shadow-xl border border-amber-100/60 p-8 space-y-6">
        
        <p class="text-sm text-gray-500">
            Update the details for the event below. All fields are required unless specified as nullable.
        </p>

        <!-- Event Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Event Name <span class="text-red-500">*</span></label>
            <input wire:model="name" type="text" id="name" required
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500 transition">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
            <textarea wire:model="description" id="description" rows="4"
                      class="w-full border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500 transition"></textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Location & Capacity -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location (Optional)</label>
                <input wire:model="location" type="text" id="location"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500 transition">
                @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">Capacity (Optional, e.g., 100)</label>
                <input wire:model="capacity" type="number" id="capacity" min="1"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500 transition">
                @error('capacity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Start & End Time -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="start_at" class="block text-sm font-medium text-gray-700 mb-2">Start Date & Time <span class="text-red-500">*</span></label>
                <input wire:model="start_at" type="datetime-local" id="start_at" required
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500 transition">
                @error('start_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="end_at" class="block text-sm font-medium text-gray-700 mb-2">End Date & Time <span class="text-red-500">*</span></label>
                <input wire:model="end_at" type="datetime-local" id="end_at" required
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500 transition">
                @error('end_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit"
                    class="w-full md:w-auto inline-flex items-center justify-center gap-3 bg-amber-600 hover:bg-amber-700 text-white font-semibold px-8 py-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.01]">
                <x-lucide-save class="w-5 h-5" />
                Save Changes
            </button>
        </div>
    </form>

</div>


</div>