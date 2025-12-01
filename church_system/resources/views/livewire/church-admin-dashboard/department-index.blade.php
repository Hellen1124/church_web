<div class="p-6 bg-stone-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 mb-10">
            <h2 class="text-3xl font-bold text-orange-900 flex items-center gap-4">
                <x-lucide-building-2 class="w-10 h-10 text-orange-600" />
                Departments Management
            </h2>

            <a href="{{ route('church.departments.create') }}"
               class="inline-flex items-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-3.5 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5">
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
                    <option value="">All Statuses</option>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-orange-800 uppercase tracking-wider">
                                Department Name
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-orange-800 uppercase tracking-wider hidden md:table-cell">
                                Head / Leader
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-orange-800 uppercase tracking-wider">
                                Members
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

                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center gap-2 text-lg font-bold text-orange-700">
                                        <x-lucide-users class="w-5 h-5" />
                                        {{ $department->members_count ?? $department->members()->count() }}
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
                                        <a href="#"
                                           class="text-orange-600 hover:text-orange-800 transition"
                                           title="Edit Department">
                                            <x-lucide-edit-3 class="w-5 h-5" />
                                        </a>
                                        <button wire:click="deleteDepartment({{ $department->id }})"
                                                wire:confirm="Are you sure you want to delete this department?"
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
                                        <p class="text-lg font-medium">No departments yet</p>
                                        <p class="text-sm mt-2">Start organizing your ministries and teams.</p>
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
</div>
