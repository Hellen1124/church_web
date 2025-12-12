@php use Illuminate\Support\Str; @endphp
<div>
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700">This Month</p>
                    <p class="text-2xl font-bold text-emerald-900 mt-1">Ksh{{ number_format($currentMonthTotal, 2) }}</p>
                </div>
                <i data-lucide="calendar" class="w-8 h-8 text-emerald-600"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700">Last Month</p>
                    <p class="text-2xl font-bold text-blue-900 mt-1">Ksh{{ number_format($lastMonthTotal, 2) }}</p>
                </div>
                <i data-lucide="trending-up" class="w-8 h-8 text-blue-600"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">Weekly Avg</p>
                    <p class="text-2xl font-bold text-purple-900 mt-1">Ksh{{ number_format($weeklyAverage, 2) }}</p>
                </div>
                <i data-lucide="bar-chart-3" class="w-8 h-8 text-purple-600"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-700">This Week</p>
                    <p class="text-2xl font-bold text-amber-900 mt-1">
                        @php
                            $thisWeek = $collections->where('collection_date', '>=', now()->startOfWeek())->sum('total_amount');
                        @endphp
                        Ksh{{ number_format($thisWeek, 2) }}
                    </p>
                </div>
                <i data-lucide="clock" class="w-8 h-8 text-amber-600"></i>
            </div>
        </div>
    </div>

    <!-- Form Toggle Button -->
    <div class="mb-6">
        <button wire:click="$toggle('showForm')" 
                class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition duration-200 shadow-sm hover:shadow">
            <i data-lucide="{{ $editingId ? 'edit' : 'plus-circle' }}" class="w-5 h-5 mr-2"></i>
            {{ $editingId ? 'Editing Collection' : 'Record New Sunday Collection' }}
            <i data-lucide="chevron-{{ $showForm ? 'up' : 'down' }}" class="w-5 h-5 ml-2"></i>
        </button>
    </div>

    <!-- Form Section (Collapsible) -->
    @if($showForm || $editingId)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6" id="collection-form">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900">
                <i data-lucide="{{ $editingId ? 'edit' : 'plus-circle' }}" class="w-5 h-5 inline mr-2"></i>
                {{ $editingId ? 'Edit Sunday Collection' : 'Record New Sunday Collection' }}
            </h2>
            @if($editingId)
            <button wire:click="resetForm" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
                <i data-lucide="x" class="w-4 h-4 mr-1"></i> Cancel
            </button>
            @endif
        </div>

        <form wire:submit.prevent="save" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Collection Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Collection Date *</label>
                    <input type="date" wire:model="collection_date" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    @error('collection_date') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Counted By -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Counted By *</label>
                    <input type="text" wire:model="counted_by" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                           placeholder="Treasurer's name">
                    @error('counted_by') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Amounts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- First Service -->
                <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-4">
                    <label class="block text-sm font-medium text-emerald-700 mb-1">First Service</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">Ksh</span>
                        <input type="number" step="0.01" wire:model="first_service_amount" 
                               class="w-full pl-8 pr-4 py-2.5 border border-emerald-200 bg-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    </div>
                    @error('first_service_amount') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Second Service -->
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                    <label class="block text-sm font-medium text-blue-700 mb-1">Second Service</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">Ksh</span>
                        <input type="number" step="0.01" wire:model="second_service_amount" 
                               class="w-full pl-8 pr-4 py-2.5 border border-blue-200 bg-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    @error('second_service_amount') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Children's Service -->
                <div class="bg-purple-50 border border-purple-100 rounded-lg p-4">
                    <label class="block text-sm font-medium text-purple-700 mb-1">Children's Service</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">Ksh</span>
                        <input type="number" step="0.01" wire:model="children_service_amount" 
                               class="w-full pl-8 pr-4 py-2.5 border border-purple-200 bg-white rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition">
                    </div>
                    @error('children_service_amount') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- M-Pesa Total -->
                <div class="bg-amber-50 border border-amber-100 rounded-lg p-4">
                    <label class="block text-sm font-medium text-amber-700 mb-1">M-Pesa Total</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">Ksh</span>
                        <input type="number" step="0.01" wire:model="mobile_mpesa_amount" 
                               class="w-full pl-8 pr-4 py-2.5 border border-amber-200 bg-white rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                    </div>
                    @error('mobile_mpesa_amount') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Total Preview -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Estimated Total:</span>
                    <span class="text-xl font-bold text-gray-900">
                        Ksh{{ number_format(($first_service_amount + $second_service_amount + $children_service_amount + $mobile_mpesa_amount), 2) }}
                    </span>
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    Breakdown: Ksh{{ number_format($first_service_amount, 2) }} (1st) + 
                    Ksh{{ number_format($second_service_amount, 2) }} (2nd) + 
                    Ksh{{ number_format($children_service_amount, 2) }} (Children) + 
                    Ksh{{ number_format($mobile_mpesa_amount, 2) }} (M-Pesa)
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                <textarea wire:model="notes" rows="2" 
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                          placeholder="Any special notes... (e.g., Thanksgiving Sunday, Special program, etc.)"></textarea>
                @error('notes') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition duration-200 shadow-sm hover:shadow">
                    <i data-lucide="{{ $editingId ? 'save' : 'check-circle' }}" class="w-5 h-5 mr-2"></i>
                    {{ $editingId ? 'Update Collection' : 'Save Collection' }}
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="flex items-center space-x-3">
            <!-- Export Button -->
            <button wire:click="export" 
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                <i data-lucide="download" class="w-4 h-4 mr-2"></i> Export CSV
            </button>
            
            <!-- Record Count -->
            <div class="text-sm text-gray-600 bg-gray-50 px-3 py-1.5 rounded-lg">
                {{ $collections->total() }} total records
            </div>
        </div>
        
        <!-- Search Box -->
        <div class="w-full md:w-64">
            <div class="relative">
                <i data-lucide="search" class="absolute left-3 top-3.5 w-4 h-4 text-gray-400"></i>
                <input type="text" wire:model.debounce.300ms="search" 
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                       placeholder="Search collections...">
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div wire:loading wire:target="search, status, month, year, perPage" class="mb-4">
        <div class="flex items-center justify-center p-8">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-emerald-600"></div>
            <span class="ml-4 text-gray-600">Loading collections...</span>
        </div>
    </div>

    <!-- Enhanced Filters -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model="status" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="counted">Counted</option>
                    <option value="verified">Verified</option>
                    <option value="banked">Banked</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <!-- Month Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                <select wire:model="month" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    <option value="">All Months</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Year Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                <select wire:model="year" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    <option value="">All Years</option>
                    @foreach(range(date('Y'), date('Y') - 2) as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Items Per Page -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Show</label>
                <select wire:model="perPage" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    <option value="10">10 per page</option>
                    <option value="15">15 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                </select>
            </div>
        </div>
        
        <!-- Clear Filters Button -->
        @if($search || $status || $month || $year)
        <div class="mt-4 pt-4 border-t border-gray-100">
            <button wire:click="clearFilters" 
                    class="inline-flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition">
                <i data-lucide="filter-x" class="w-4 h-4 mr-2"></i> Clear All Filters
            </button>
        </div>
        @endif
    </div>

    <!-- Collections Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden" wire:loading.remove wire:target="search, status, month, year, perPage">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                            wire:click="sortBy('collection_date')">
                            <div class="flex items-center">
                                Date
                                @if($sortField === 'collection_date')
                                <i data-lucide="chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" class="w-4 h-4 ml-1"></i>
                                @endif
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Services</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Amounts</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Counted By</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($collections as $collection)
                    <tr class="hover:bg-gray-50 transition group">
                        <!-- Date -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $collection->collection_date->format('D, M j, Y') }}
                                </div>
                                @if($collection->bank_deposit_date)
                                <div class="text-xs text-gray-500">
                                    Banked: {{ $collection->bank_deposit_date->format('M j') }}
                                </div>
                                @endif
                            </div>
                        </td>

                        <!-- Services Breakdown -->
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                <div class="flex items-center text-sm">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></div>
                                    <span class="text-gray-600">1st:</span>
                                    <span class="ml-auto font-medium">Ksh{{ number_format($collection->first_service_amount, 2) }}</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <div class="w-2 h-2 rounded-full bg-blue-500 mr-2"></div>
                                    <span class="text-gray-600">2nd:</span>
                                    <span class="ml-auto font-medium">Ksh{{ number_format($collection->second_service_amount, 2) }}</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <div class="w-2 h-2 rounded-full bg-purple-500 mr-2"></div>
                                    <span class="text-gray-600">Children:</span>
                                    <span class="ml-auto font-medium">Ksh{{ number_format($collection->children_service_amount, 2) }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- Amounts -->
                        <td class="px-6 py-4">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">M-Pesa:</span>
                                    <span class="font-medium text-amber-700">Ksh{{ number_format($collection->mobile_mpesa_amount, 2) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-900">Total:</span>
                                    <span class="font-bold text-gray-900">Ksh{{ number_format($collection->total_amount, 2) }}</span>
                                </div>
                                <div class="text-xs text-gray-500">
                                    Cash: Ksh{{ number_format($collection->first_service_amount + $collection->second_service_amount + $collection->children_service_amount, 2) }}
                                </div>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'counted' => 'bg-blue-100 text-blue-800',
                                    'verified' => 'bg-indigo-100 text-indigo-800',
                                    'banked' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$collection->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($collection->status) }}
                            </span>
                            
                            @if($collection->verified_by || $collection->verified_by_2)
                            <div class="mt-1 text-xs text-gray-500">
                                @if($collection->verified_by && $collection->verified_by_2)
                                    <i data-lucide="check-circle" class="w-3 h-3 inline text-green-500"></i> Dual verified
                                @elseif($collection->verified_by || $collection->verified_by_2)
                                    <i data-lucide="alert-circle" class="w-3 h-3 inline text-yellow-500"></i> Single verified
                                @endif
                            </div>
                            @endif
                        </td>

                        <!-- Counted By -->
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $collection->counted_by }}</div>
                            @if($collection->notes)
                            <div class="text-xs text-gray-500 truncate max-w-xs" title="{{ $collection->notes }}">
                                <i data-lucide="message-square" class="w-3 h-3 inline mr-1"></i>
                                {{ Str::limit($collection->notes, 30) }}
                            </div>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-1">
                                <!-- Edit (only for pending/counted) -->
                                @if(in_array($collection->status, ['pending', 'counted']))
                                <button wire:click="edit({{ $collection->id }})" 
                                        class="p-1.5 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded transition"
                                        title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                @endif

                                <!-- Mark as Counted -->
                                @if($collection->status === 'pending')
                                <button wire:click="markAsCounted({{ $collection->id }})" 
                                        class="p-1.5 text-green-600 hover:text-green-900 hover:bg-green-50 rounded transition"
                                        title="Mark as Counted">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </button>
                                @endif

                                <!-- Verify -->
                                @if($collection->status === 'counted' && auth()->user()->hasRole('church-treasurer'))
                                <button wire:click="startVerify({{ $collection->id }})" 
                                        class="p-1.5 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded transition"
                                        title="Verify">
                                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                                </button>
                                @endif

                                <!-- Mark as Banked -->
                                @if($collection->status === 'verified')
                                <button wire:click="startBanking({{ $collection->id }})" 
                                        class="p-1.5 text-emerald-600 hover:text-emerald-900 hover:bg-emerald-50 rounded transition"
                                        title="Mark as Banked">
                                    <i data-lucide="banknote" class="w-4 h-4"></i>
                                </button>
                                @endif

                                <!-- Duplicate -->
                                <button wire:click="duplicateCollection({{ $collection->id }})" 
                                        class="p-1.5 text-purple-600 hover:text-purple-900 hover:bg-purple-50 rounded transition"
                                        title="Duplicate">
                                    <i data-lucide="copy" class="w-4 h-4"></i>
                                </button>

                                <!-- Delete/Cancel -->
                                @if($collection->status === 'pending')
                                <button wire:click="delete({{ $collection->id }})" 
                                        onclick="return confirm('Are you sure you want to delete this collection?')"
                                        class="p-1.5 text-red-600 hover:text-red-900 hover:bg-red-50 rounded transition"
                                        title="Delete">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                                @elseif(in_array($collection->status, ['pending', 'counted']))
                                <button wire:click="cancel({{ $collection->id }})" 
                                        onclick="return confirm('Are you sure you want to cancel this collection?')"
                                        class="p-1.5 text-red-600 hover:text-red-900 hover:bg-red-50 rounded transition"
                                        title="Cancel">
                                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i data-lucide="calendar-x" class="w-12 h-12 mx-auto mb-3"></i>
                                <p class="text-lg font-medium text-gray-500">No Sunday collections found</p>
                                <p class="text-sm text-gray-400 mt-1">Start by recording your first Sunday collection above.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($collections->hasPages())
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            {{ $collections->links() }}
        </div>
        @endif
    </div>

    <!-- Monthly Breakdown -->
@if($monthlyBreakdown->count() > 0)
<div class="mt-8">
    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
        <i data-lucide="trending-up" class="w-5 h-5 mr-2"></i> Monthly Collection Trends
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($monthlyBreakdown as $monthData)
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition">
            <div class="text-sm font-medium text-gray-500 truncate">
                {{ date('F', mktime(0, 0, 0, $monthData->month, 1)) }} {{ $monthData->year }}
            </div>
            <div class="text-xl font-bold text-gray-900 mt-1 truncate" title="Ksh{{ number_format($monthData->total, 2) }}">
                Ksh{{ number_format($monthData->total, 2) }}
            </div>
            <div class="text-xs text-gray-400 mt-1">
                @php
                    $weeks = \App\Models\SundayCollection::forCurrentTenant()
                        ->whereYear('collection_date', $monthData->year)
                        ->whereMonth('collection_date', $monthData->month)
                        ->count();
                @endphp
                {{ $weeks }} {{ Str::plural('Sunday', $weeks) }}
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

    <!-- Modals -->
    <!-- Verification Modal -->
    @if($verifyingId)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4" 
         x-data="{ open: true }" 
         x-show="open"
         x-transition>
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6" @click.outside="open = false">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Verify Collection</h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="text-sm text-gray-600">
                    Which committee member are you?
                </div>
                
                <div class="space-y-2">
                    <button wire:click="verifyFirst" 
                            class="w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition text-center">
                        <i data-lucide="user-check" class="w-5 h-5 inline mr-2"></i>
                        I am the First Verifier (Treasurer)
                    </button>
                    
                    <button wire:click="verifySecond" 
                            class="w-full px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition text-center">
                        <i data-lucide="users" class="w-5 h-5 inline mr-2"></i>
                        I am the Second Committee Member
                    </button>
                </div>
                
                <div class="pt-4 border-t border-gray-200">
                    <button @click="open = false" 
                            class="w-full px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Banking Modal -->
    @if($bankingId)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4" 
         x-data="{ open: true }" 
         x-show="open"
         x-transition>
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6" @click.outside="open = false">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Mark as Banked</h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form wire:submit.prevent="markAsBanked" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deposit Date *</label>
                    <input type="date" wire:model="bank_deposit_date" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    @error('bank_deposit_date') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bank Slip Number (Optional)</label>
                    <input type="text" wire:model="bank_slip_number" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                           placeholder="e.g., DEP-00123">
                    @error('bank_slip_number') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                
                <div class="pt-4 border-t border-gray-200 flex items-center justify-end space-x-3">
                    <button type="button" @click="open = false" 
                            class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition">
                        <i data-lucide="check-circle" class="w-5 h-5 inline mr-2"></i>
                        Confirm Banking
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- JavaScript for Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            // Scroll to form when editing
            Livewire.on('scroll-to-form', function() {
                document.getElementById('collection-form').scrollIntoView({ 
                    behavior: 'smooth' 
                });
            });
        });
    </script>
</div>