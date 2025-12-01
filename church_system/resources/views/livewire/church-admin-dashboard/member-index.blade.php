<div class="p-6 bg-stone-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <!-- Header + CTA -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-10">
            <h1 class="text-3xl font-bold text-amber-900 flex items-center gap-4">
                <x-lucide-users-round class="w-10 h-10 text-amber-600" />
                Church Fellowship Members
            </h1>

            <a href="{{ route('church.members.create') }}"
               class="inline-flex items-center gap-3 bg-amber-600 hover:bg-amber-700 text-white font-medium px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5">
                <x-lucide-user-plus class="w-5 h-5" />
                Add New Member
            </a>
        </div>

        <!-- Search & Filters -->
        <div class="bg-white rounded-2xl shadow-lg border border-amber-100/60 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- Search -->
                <div class="lg:col-span-1">
                    <div class="relative">
                        <x-lucide-search class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                        <input wire:model.live="search"
                               type="text"
                               placeholder="Search members..."
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                    </div>
                </div>

                <!-- Status Filter -->
                <select wire:model.live="statusFilter"
                        class="border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>

                <!-- Role Filter -->
                <select wire:model.live="roleFilter"
                        class="border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                    <option value="">All Roles</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>

                <!-- Reset -->
                <button wire:click="resetFilters"
                        class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl px-5 py-2.5 transition">
                    <x-lucide-rotate-cw class="w-4 h-4" />
                    Reset
                </button>
            </div>
        </div>

        <!-- Members Table -->
        <div class="bg-white rounded-2xl shadow-xl border border-amber-100/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-amber-100">
                    <thead class="bg-gradient-to-r from-amber-50 to-orange-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-amber-800 uppercase tracking-wider">Member</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-amber-800 uppercase tracking-wider hidden sm:table-cell">Membership No.</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-amber-800 uppercase tracking-wider hidden lg:table-cell">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-amber-800 uppercase tracking-wider">Role / Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-amber-800 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-amber-800 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-amber-50">
                        @forelse ($members as $member)
                            <tr class="hover:bg-amber-25 transition duration-200 group">
                                <!-- Avatar + Name -->
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-amber-200 rounded-full flex items-center justify-center text-amber-900 font-bold text-sm shadow-sm">
                                            {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $member->full_name }}</div>
                                            <div class="text-sm text-gray-500">{{ $member->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Membership No -->
                                <td class="px-6 py-5 text-sm text-gray-600 hidden sm:table-cell">
                                    {{ $member->membership_no ?? '—' }}
                                </td>

                                <!-- Phone -->
                                <td class="px-6 py-5 text-sm text-gray-600 hidden lg:table-cell">
                                    {{ $member->phone ?? '—' }}
                                </td>

                                <!-- Role & Status -->
                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-2">
                                        @if($member->role)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                {{ $member->role }}
                                            </span>
                                        @endif

                                        @php
                                            $statusColors = [
                                                'Active'   => 'bg-emerald-100 text-emerald-800',
                                                'Inactive' => 'bg-red-100 text-red-800',
                                                'Pending'  => 'bg-amber-100 text-amber-800',
                                                'Suspended'=> 'bg-gray-100 text-gray-700',
                                            ];
                                            $badge = $statusColors[$member->status] ?? 'bg-gray-100 text-gray-700';
                                        @endphp

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $badge }}">
                                            {{ $member->status }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Joined Date -->
                                <td class="px-6 py-5 text-sm text-gray-600">
                                    {{ $member->date_joined->format('M j, Y') }}
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="#" class="text-amber-600 hover:text-amber-800 transition" title="View">
                                            <x-lucide-eye class="w-5 h-5" />
                                        </a>
                                        <a href="#" class="text-blue-600 hover:text-blue-800 transition" title="Edit">
                                            <x-lucide-edit-3 class="w-5 h-5" />
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-16 text-gray-500">
                                    <div class="mx-auto max-w-xs">
                                        <x-lucide-users class="w-16 h-16 mx-auto mb-4 text-gray-300" />
                                        <p class="text-lg font-medium">No members found</p>
                                        <p class="text-sm mt-2">Try adjusting your filters or add your first member.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-amber-25 border-t border-amber-100 px-6 py-4">
                {{ $members->links() }}
            </div>
        </div>
    </div>
</div>
