<div class="p-6 bg-stone-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <!-- Header + Add Button -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 mb-10">
            <h2 class="text-3xl font-bold text-orange-900 flex items-center gap-4">
                <x-lucide-building-2 class="w-10 h-10 text-orange-600" />
                Departments Management
            </h2>
            <a href="{{ route('church.departments.create') }}"
               class="inline-flex items-center gap-3 bg-amber-600 hover:bg-amber-700 text-white font-medium px-6 py-3.5 rounded-full shadow-lg transition">
                <x-lucide-plus class="w-5 h-5" /> Add New Department
            </a>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-2xl shadow-lg border border-orange-100/50 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="md:col-span-2 relative">
                    <x-lucide-search class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search departments or leaders..."
                           class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500">
                </div>
                <select wire:model.live="statusFilter" class="border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500">
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-xl border border-orange-100/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-orange-100">
                    <thead class="bg-gradient-to-r from-orange-50 to-amber-50">
                        <tr>
                            <th wire:click="setSortBy('name')" class="px-6 py-4 text-left text-xs font-semibold text-orange-800 uppercase tracking-wider cursor-pointer hover:bg-orange-100">
                                <div class="flex items-center gap-2">
                                    Name @if($sortBy==='name') <x-lucide-chevron-up class="w-4 h-4 {{ $sortDirection==='asc'?'':'rotate-180' }}" /> @endif
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-orange-800 uppercase tracking-wider hidden md:table-cell">Leader</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-orange-800 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-orange-800 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-orange-800 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-orange-50">
    @forelse ($departments as $department)
        <tr class="hover:bg-orange-25 transition duration-200 group">
            <td class="px-6 py-5 font-semibold text-gray-900">
                {{ $department->name }}
            </td>

            <td class="px-6 py-5 text-gray-700 hidden md:table-cell">
                @if($department->leader)
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-orange-200 rounded-full flex items-center justify-center text-orange-900 font-bold text-sm">
                            {{ strtoupper(substr($department->leader->first_name, 0, 1)) }}{{ strtoupper(substr($department->leader->last_name, 0, 1)) }}
                        </div>
                        <span>{{ $department->leader->full_name }}</span>
                    </div>
                @else
                    <span class="text-gray-400 italic">No leader assigned</span>
                @endif
            </td>

            <td class="px-6 py-5 text-center text-gray-600">
                <span class="inline-flex items-center gap-2">
                    <x-lucide-calendar class="w-4 h-4" />
                    {{ $department->created_at->format('M d, Y') }}
                </span>
            </td>

            <td class="px-6 py-5">
                @php
                    $badge = $department->status === 'Active'
                        ? 'bg-emerald-100 text-emerald-800'
                        : 'bg-red-100 text-red-800';
                @endphp
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-semibold {{ $badge }}">
                    <x-lucide-circle class="w-3 h-3 mr-1.5 {{ $department->status === 'Active' ? 'fill-emerald-500' : 'fill-red-500' }}" />
                    {{ $department->status }}
                </span>
            </td>

            <td class="px-6 py-5 text-right">
                <div class="flex items-center justify-end gap-4">
                    {{-- Edit button - NOW INSIDE THE @forelse LOOP --}}
                  
                    <button wire:click="showEditModal({{ $department->id }})" 
                            class="text-orange-600 hover:text-orange-800 transition"
                        title="Edit Department">
                        <x-lucide-edit-3 class="w-5 h-5" />
                        
                    </button>

                    {{-- Delete button - ALSO INSIDE THE LOOP --}}
                    <button wire:click="deleteDepartment({{ $department->id }})"
                            wire:confirm="Are you sure you want to permanently delete {{ $department->name }}? This cannot be undone."
                            class="text-red-600 hover:text-red-900 transition"
                            title="Delete">
                        <x-lucide-trash-2 class="w-5 h-5" />
                    </button>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center py-16 text-gray-500">
                <div class="mx-auto max-w-sm">
                    <x-lucide-building class="w-16 h-16 mx-auto mb-5 text-gray-300" />
                    <p class="text-lg font-medium">No departments found</p>
                    <p class="text-sm mt-2">
                        @if($search || ($statusFilter !== 'Active' && $statusFilter !== 'All'))
                            Try adjusting your search or filter
                        @else
                            Start organizing your ministries and teams.
                        @endif
                    </p>
                </div>
            </td>
        </tr>
    @endforelse
</tbody>
                </table>
            </div>
            <div class="bg-orange-25 border-t border-orange-100 px-6 py-4">
                {{ $departments->links() }}
            </div>
        </div>
    </div>
<!-- Add this at the bottom of your component -->
<div class="mt-4">
    
    
   @if($showEditModal)
<div class="fixed inset-0 z-50 overflow-y-auto" x-data>
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
    
    <!-- Modal container -->
    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <!-- Modal panel -->
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xl">
            <form wire:submit.prevent="updateDepartment">
                <!-- Modal header -->
                <div class="bg-white px-6 pt-5 pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-orange-900">
                            Edit Department: {{ $departmentName }}
                        </h3>
                        <button type="button" 
                                wire:click="$set('showEditModal', false)"
                                class="text-gray-400 hover:text-gray-500">
                            <x-lucide-x class="w-6 h-6" />
                        </button>
                    </div>
                    
                    <!-- Form fields -->
                    <div class="space-y-4">
                        <!-- Department Name -->
                        <div>
                            <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Name
                            </label>
                            <input wire:model="departmentName" 
                                   type="text" 
                                   id="edit_name" 
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            @error('departmentName') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                            @enderror
                        </div>
                        
                        <!-- Status -->
                        <div>
                            <label for="edit_status" class="block text-sm font-medium text-gray-700 mb-1">
                                Status
                            </label>
                            <select wire:model="departmentStatus" 
                                    id="edit_status"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            @error('departmentStatus') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                            @enderror
                        </div>
                        
                        <!-- Leader Assignment -->
                        <div>
                            <label for="edit_leader" class="block text-sm font-medium text-gray-700 mb-1">
                                Assigned Leader
                            </label>
                            <select wire:model="departmentLeaderId" 
                                    id="edit_leader"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="">-- No Leader Assigned --</option>
                                @foreach ($allLeaders as $leader)
                                    <option value="{{ $leader->id }}">
                                        {{ $leader->first_name }} {{ $leader->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('departmentLeaderId') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Modal footer -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                    <button type="button" 
                            wire:click="$set('showEditModal', false)"
                            class="inline-flex justify-center items-center gap-2 px-5 py-2.5 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition">
                        <x-lucide-x class="w-4 h-4" />
                        Cancel
                    </button>
                    
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            class="inline-flex justify-center items-center gap-2 px-5 py-2.5 border border-transparent rounded-xl text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition">
                        <span wire:loading.remove wire:target="updateDepartment">
                            <x-lucide-save class="w-4 h-4" />
                            Save Changes
                        </span>
                        <span wire:loading wire:target="updateDepartment">
                            <x-lucide-loader-2 class="w-4 h-4 animate-spin" />
                            Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
</div>
 
    <!-- Flash Message -->
    @if(session('message'))
        <div class="fixed bottom-4 right-4 z-50">
            <div class="bg-white rounded-xl shadow-2xl border-l-4 {{ session('message.type')==='success'?'border-emerald-500':'border-red-500' }} p-4 max-w-sm">
                <div class="flex items-center gap-3">
                    @if(session('message.type')==='success') <x-lucide-check-circle class="w-6 h-6 text-emerald-500" /> @endif
                    <div>
                        <h4 class="font-semibold">{{ session('message.title') }}</h4>
                        <p class="text-sm text-gray-600">{{ session('message.message') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>