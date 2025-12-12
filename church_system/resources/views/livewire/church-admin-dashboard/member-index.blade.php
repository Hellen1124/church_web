<div class="p-4 sm:p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-8 lg:mb-10">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-amber-900 flex items-center gap-4">
                <x-lucide-users-round class="w-8 h-8 lg:w-10 lg:h-10 text-amber-600 flex-shrink-0" />
                Church Fellowship Members
            </h1>

            <a href="{{ route('church.members.create') }}"
               class="inline-flex items-center justify-center gap-3 bg-amber-600 hover:bg-amber-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 whitespace-nowrap">
                <x-lucide-user-plus class="w-5 h-5" />
                Add New Member
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-xl border border-amber-100/60 p-5 lg:p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5">

                <div class="lg:col-span-1">
                    <div class="relative">
                        <x-lucide-search class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" />
                        <input wire:model.live.debounce.300ms="search"
                               type="text"
                               placeholder="Search by name or email..."
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition placeholder:text-gray-500 text-gray-700">
                    </div>
                </div>

                <select wire:model.live="statusFilter"
                        class="border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition appearance-none cursor-pointer">
                    <option value="">Status: All</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>

                <select wire:model.live="roleFilter"
                        class="border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition appearance-none cursor-pointer">
                    <option value="">Role: All</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>

                <button wire:click="resetFilters"
                        class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg px-5 py-2.5 transition active:scale-[0.98]">
                    <x-lucide-rotate-cw class="w-4 h-4" />
                    Reset Filters
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-xl border border-amber-100/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-amber-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">Member Details</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-amber-800 uppercase tracking-wider hidden sm:table-cell">Membership No.</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-amber-800 uppercase tracking-wider hidden lg:table-cell">Contact Info</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">Status & Role</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-amber-800 uppercase tracking-wider hidden md:table-cell">Joined</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-amber-800 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($members as $member)
                            <tr class="hover:bg-amber-50/50 transition duration-200 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        {{-- Placeholder Avatar --}}
                                        <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center text-amber-700 font-bold text-sm shadow-inner flex-shrink-0">
                                            {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900 leading-tight">{{ $member->full_name }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">{{ $member->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden sm:table-cell">
                                    <span class="font-mono text-gray-700">{{ $member->membership_no ?? '—' }}</span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden lg:table-cell">
                                    {{ $member->phone ?? '—' }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1">
                                        @if($member->role)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 w-fit">
                                                {{ $member->role }}
                                            </span>
                                        @endif

                                        @php
                                            $statusColors = [
                                                'Active'    => 'bg-green-100 text-green-800',
                                                'Inactive'  => 'bg-red-100 text-red-800',
                                                'Pending'   => 'bg-yellow-100 text-yellow-800', // Changed from amber for better contrast/standardization
                                                'Suspended' => 'bg-gray-100 text-gray-700',
                                            ];
                                            $badge = $statusColors[$member->status] ?? 'bg-gray-100 text-gray-700';
                                        @endphp

                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }} w-fit">
                                            {{ $member->status }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden md:table-cell">
                                    {{ $member->date_joined->format('M j, Y') }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-75 group-hover:opacity-100 transition duration-150">

                                        {{-- 1. VIEW / DETAILS ACTION --}}
                                        @can('view members')
                                            <a href="{{ route('church.members.show', $member->id) }}" 
                                            class="text-amber-600 hover:text-amber-800 transition p-1" 
                                            title="View Details">
                                                <x-lucide-eye class="w-5 h-5" />
                                            </a>
                                        @endcan

                                        {{-- 2. EDIT / UPDATE ACTION --}}
                                        @can('update members')
                                            <a href="{{ route('church.members.edit', $member->id) }}" 
                                            class="text-blue-600 hover:text-blue-800 transition p-1" 
                                            title="Edit Member">
                                                <x-lucide-edit-3 class="w-5 h-5" />
                                            </a>
                                        @endcan
                                        
                                        {{-- 3. DELETE ACTION --}}
                                        @can('delete members')
                                            <button wire:click="confirmMemberDeletion({{ $member->id }})"
                                                    class="text-red-600 hover:text-red-800 transition p-1"
                                                    title="Delete Member">
                                                <x-lucide-trash-2 class="w-5 h-5" />
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-16 text-gray-500">
                                    <div class="mx-auto max-w-xs">
                                        <x-lucide-users-round class="w-16 h-16 mx-auto mb-4 text-gray-300" />
                                        <p class="text-xl font-semibold text-gray-700">No members found</p>
                                        <p class="text-sm mt-2 text-gray-500">Try adjusting your filters or click 'Add New Member' to get started.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-amber-50 border-t border-gray-200 px-6 py-3">
                {{ $members->links() }}
            </div>
        </div>
    </div>

    @if ($confirmingMemberDeletion)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:block sm:p-0">

                <div class="fixed inset-0 bg-gray-900 bg-opacity-70 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>

                <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-6 pt-6 pb-6 sm:p-8 sm:pb-6">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-red-50 sm:mx-0 sm:h-12 sm:w-12 border-4 border-red-100 shadow-inner">
                                <x-lucide-trash-2 class="h-6 w-6 text-red-600"/>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-xl leading-7 font-bold text-gray-900" id="modal-title">
                                    Permanently Delete Member Record
                                </h3>
                                <div class="mt-3">
                                    <p class="text-sm text-gray-600">
                                        You are about to permanently delete this member's record. This action is irreversible.
                                        All associated data (contributions, roles, etc.) will be lost.
                                    </p>
                                    <p class="mt-4 p-3 bg-red-50 text-red-700 rounded-lg border border-red-200 text-sm font-semibold flex items-center gap-2">
                                        <x-lucide-alert-triangle class="w-4 h-4 flex-shrink-0" />
                                        Confirm only if absolutely certain. This process is final.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3 rounded-b-xl">

                        <button wire:click="deleteMember" 
                                wire:loading.attr="disabled"
                                class="w-full inline-flex justify-center rounded-lg shadow-md px-6 py-3 text-base font-semibold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-red-300 sm:ml-0 sm:w-auto transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="deleteMember">
                                Yes, Delete Member
                            </span>
                            <span wire:loading wire:target="deleteMember">
                                <x-lucide-loader-2 class="animate-spin w-5 h-5 mr-2" />
                                Deleting...
                            </span>
                        </button>
                        
                        <button wire:click="$set('confirmingMemberDeletion', false)" 
                                wire:loading.attr="disabled"
                                type="button" 
                                class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-lg shadow-sm px-6 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 sm:w-auto transition duration-150 disabled:opacity-50">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
