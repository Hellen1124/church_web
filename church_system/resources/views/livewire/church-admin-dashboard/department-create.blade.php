<div>
    <h2 class="text-3xl font-bold text-orange-600 mb-6">Create New Department</h2>

    {{-- Session Flash Messages --}}
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="saveDepartment" class="bg-white shadow-lg rounded-lg p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Department Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Department Name <span class="text-red-500">*</span></label>
                <input wire:model="name" type="text" id="name" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            
            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <select wire:model="status" id="status" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200">
                    @foreach ($statuses as $statusOption)
                        <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                    @endforeach
                </select>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Leader ID (Points to users.id) --}}
            <div class="md:col-span-2">
                <label for="leader_id" class="block text-sm font-medium text-gray-700">Department Head / Leader</label>
                <select wire:model="leader_id" id="leader_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200">
                    {{-- ✅ FIX: Explicitly use "null" value for the default option --}}
                    <option value="null" selected>-- Select a Leader (Optional) --</option> 
                    @foreach ($leaders as $leader)
                        <option value="{{ $leader->id }}">{{ $leader->first_name }} {{ $leader->last_name }}</option>
                    @endforeach
                </select>
                @error('leader_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Description / Mission</label>
                <textarea wire:model="description" id="description" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200"></textarea>
                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

        </div>

        {{-- Form Actions --}}
        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('church.departments.index') }}" 
               class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                Cancel
            </a>
            <button type="submit" 
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                Save Department
            </button>
        </div>
    </form>
</div>