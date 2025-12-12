<div class="p-6 bg-stone-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 mb-10">
            <h2 class="text-3xl font-bold text-orange-900 flex items-center gap-4">
                <x-lucide-building-2 class="w-10 h-10 text-orange-600" />
                Departments Management
            </h2>

            <a href="{{ route('church.departments.create') }}"
                class="inline-flex items-center gap-3 bg-amber-600 hover:bg-amber-700 text-white font-medium px-6 py-3.5 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5">
                    <x-lucide-plus class="w-5 h-5" />
                    Add New Department
            </a>
        </div>

        <!-- Search & Filters -->
        <div class="bg-white rounded-2xl shadow-lg border border-orange-100/50 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <!-- Search -->
                <div class="md:col-span-2 relative">
                    <x-lucide-search class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                    <input wire:model.live.debounce.300ms="search"
                           type="text"
                           placeholder="Search departments or leader names..."
                           class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                </div>

                <!-- Status Filter -->
                <select wire:model.live="statusFilter"
                        class="border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Departments Table -->
        <div class="bg-white rounded-2xl shadow-xl border border-orange-100/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-orange-100">
                    <thead class="bg-gradient-to-r from-orange-50 to-amber-50">
                        <tr>
                            <th wire:click="setSortBy('name')" 
                                class="px-6 py-4 text-left text-xs font-semibold text-orange-800 uppercase tracking-wider cursor-pointer hover:bg-orange-100 transition-colors">
                                <div class="flex items-center gap-2">
                                    Department Name
                                    @if($sortBy === 'name')
                                        <x-lucide-chevron-up class="w-4 h-4 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" />
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-orange-800 uppercase tracking-wider hidden md:table-cell">
                                Head / Leader
                            </th>
                            <th wire:click="setSortBy('created_at')"
                                class="px-6 py-4 text-center text-xs font-semibold text-orange-800 uppercase tracking-wider cursor-pointer hover:bg-orange-100 transition-colors">
                                <div class="flex items-center justify-center gap-2">
                                    Created
                                    @if($sortBy === 'created_at')
                                        <x-lucide-chevron-up class="w-4 h-4 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" />
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-orange-800 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-orange-800 uppercase tracking-wider">
                                Actions
                            </th>
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
                                                {{ strtoupper(substr($department->leader->first_name, 0, 1)) }}
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
                                        <a href="{{ route('church.departments.edit', $department) }}"
                                           class="text-orange-600 hover:text-orange-800 transition"
                                           title="Edit Department">
                                            <x-lucide-edit-3 class="w-5 h-5" />
                                        </a>
                                        <button wire:click="showDeleteModal({{ $department->id }})"
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

            <!-- Pagination -->
            <div class="bg-orange-25 border-t border-orange-100 px-6 py-4">
                {{ $departments->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/50 transition-opacity" aria-hidden="true"></div>

            <!-- Modal -->
            <div class="flex min-h-screen items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-red-50 to-orange-50 px-6 py-5 border-b border-red-100">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <x-lucide-alert-triangle class="w-7 h-7 text-red-600" />
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-red-900" id="modal-title">
                                    Delete Department
                                </h3>
                                <p class="text-sm text-red-700 mt-1">
                                    This action cannot be undone
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="px-6 py-5">
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-5">
                            <div class="flex items-start gap-3">
                                <x-lucide-alert-circle class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0" />
                                <div>
                                    <p class="font-medium text-amber-900">Are you sure you want to delete this department?</p>
                                    <p class="text-sm text-amber-800 mt-1">
                                        All department data including member assignments will be permanently removed.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Department Details -->
                        @if($departmentToDelete)
                            <div class="border border-gray-200 rounded-xl p-4 mb-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                                        <x-lucide-building-2 class="w-7 h-7 text-orange-600" />
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg">{{ $departmentToDelete->name }}</h4>
                                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                                            <span class="flex items-center gap-1.5">
                                                <x-lucide-users class="w-4 h-4" />
                                                {{ $departmentToDelete->members()->count() }} members
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <x-lucide-user class="w-4 h-4" />
                                                {{ $departmentToDelete->leader ? $departmentToDelete->leader->full_name : 'No leader' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Confirmation Input -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Type <span class="font-mono bg-gray-100 px-2 py-1 rounded">DELETE</span> to confirm:
                            </label>
                            <input wire:model.live="deleteConfirmation"
                                   type="text"
                                   placeholder="Type DELETE here"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition
                                          @if($deleteError) border-red-500 @endif"
                                   autocomplete="off">
                            @if($deleteError)
                                <p class="mt-2 text-sm text-red-600">{{ $deleteError }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row-reverse sm:justify-between gap-3">
                        <div class="flex gap-3">
                            <button wire:click="closeDeleteModal"
                                    type="button"
                                    class="inline-flex justify-center items-center gap-2 px-5 py-2.5 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition">
                                <x-lucide-x class="w-4 h-4" />
                                Cancel
                            </button>
                            <button wire:click="deleteDepartment"
                                    wire:loading.attr="disabled"
                                    :disabled="$deleteConfirmation !== 'DELETE'"
                                    class="inline-flex justify-center items-center gap-2 px-5 py-2.5 border border-transparent rounded-xl text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50 disabled:cursor-not-allowed transition">
                                <x-lucide-trash-2 class="w-4 h-4" />
                                <span wire:loading.remove wire:target="deleteDepartment">
                                    Delete Department
                                </span>
                                <span wire:loading wire:target="deleteDepartment">
                                    <x-lucide-loader-2 class="w-4 h-4 animate-spin" />
                                    Deleting...
                                </span>
                            </button>
                        </div>
                        
                        <div class="text-xs text-gray-500 pt-1 sm:pt-0">
                            <div class="flex items-center gap-1">
                                <x-lucide-shield-alert class="w-3 h-3" />
                                Permanent action. No recovery available.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Flash Messages -->
    @if(session()->has('message'))
        @php
            $message = session('message');
        @endphp
        <div class="fixed bottom-4 right-4 z-50 animate-fade-in-up">
            <div class="bg-white rounded-xl shadow-2xl border-l-4 {{ $message['type'] === 'success' ? 'border-emerald-500' : 'border-red-500' }} p-4 max-w-sm">
                <div class="flex items-start gap-3">
                    @if($message['type'] === 'success')
                        <x-lucide-check-circle class="w-6 h-6 text-emerald-500 flex-shrink-0" />
                    @else
                        <x-lucide-x-circle class="w-6 h-6 text-red-500 flex-shrink-0" />
                    @endif
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900">{{ $message['title'] }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $message['message'] }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600">
                        <x-lucide-x class="w-5 h-5" />
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>