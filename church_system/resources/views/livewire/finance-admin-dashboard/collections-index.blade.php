@php use Illuminate\Support\Str; @endphp
@php use App\Models\SundayCollection; @endphp

@php
use BladeUI\Icons\Components\Icon;
@endphp

<div>
    <!-- Treasurer Dashboard Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Sunday Collections</h1>
                <p class="text-gray-600 mt-1">Treasurer Dashboard - Manage collections workflow</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1.5 bg-emerald-100 text-emerald-800 rounded-full text-sm font-semibold flex items-center">
                    <x-icon name="shield-check" class="w-4 h-4 mr-1.5" />
                    Treasurer Access
                </span>
                <span class="text-sm text-gray-600">
                    {{ auth()->user()->name }}
                </span>
            </div>
        </div>
    </div>

    <!-- Simplified Status Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <!-- Pending Count -->
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-700">Pending</p>
                    <p class="text-2xl font-bold text-amber-900 mt-1">
                        {{ $pendingCollections->count() }}
                    </p>
                </div>
                <div class="p-2 bg-amber-200 rounded-lg">
                    <x-icon name="clock" class="w-6 h-6 text-amber-700" />
                </div>
            </div>
            <div class="mt-3">
                @if($pendingCollections->count() > 0)
                <x-button wire:click="$set('status', 'pending')"
                          label="Mark as counted"
                          flat
                          sm
                          color="amber"
                          icon="arrow-right"
                          class="font-medium" />
                @else
                <span class="text-xs text-amber-600">All collections counted</span>
                @endif
            </div>
        </div>

        <!-- Awaiting Verification -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700">To Verify</p>
                    <p class="text-2xl font-bold text-blue-900 mt-1">
                        {{ $countedCollections->count() }}
                    </p>
                </div>
                <div class="p-2 bg-blue-200 rounded-lg">
                    <x-icon name="shield-check" class="w-6 h-6 text-blue-700" />
                </div>
            </div>
            <div class="mt-3">
                @if($countedCollections->count() > 0)
                <x-button wire:click="$set('status', 'counted')"
                          label="Verify now"
                          flat
                          sm
                          color="blue"
                          icon="arrow-right"
                          class="font-medium" />
                @else
                <span class="text-xs text-blue-600">None to verify</span>
                @endif
            </div>
        </div>

        <!-- Ready for Banking -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">To Bank</p>
                    <p class="text-2xl font-bold text-purple-900 mt-1">
                        {{ $verifiedCollections->count() }}
                    </p>
                </div>
                <div class="p-2 bg-purple-200 rounded-lg">
                    <x-icon name="banknotes" class="w-6 h-6 text-purple-700" />
                </div>
            </div>
            <div class="mt-3">
                @if($verifiedCollections->count() > 0)
                <x-button wire:click="$set('status', 'verified')"
                          label="Bank now"
                          flat
                          sm
                          color="purple"
                          icon="arrow-right"
                          class="font-medium" />
                @else
                <span class="text-xs text-purple-600">None to bank</span>
                @endif
            </div>
        </div>

        <!-- This Month Total -->
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700">This Month</p>
                    <p class="text-2xl font-bold text-emerald-900 mt-1">Ksh{{ number_format($currentMonthTotal, 2) }}</p>
                </div>
                <div class="p-2 bg-emerald-200 rounded-lg">
                    <x-icon name="calendar" class="w-6 h-6 text-emerald-700" />
                </div>
            </div>
            <div class="mt-3">
                <span class="text-xs text-emerald-600">
                    {{ now()->format('F Y') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Quick Action Buttons -->
    <div class="flex flex-wrap gap-3 mb-6">
        <x-button wire:click="$toggle('showForm')"
                  :label="$showForm ? 'Close Form' : 'Record New Collection'"
                  primary
                  :icon="$showForm ? 'x-mark' : 'plus-circle'"
                  class="font-semibold shadow-sm hover:shadow" />
        
        <x-button wire:click="export"
                  label="Export CSV"
                  secondary
                  icon="arrow-down-tray"
                  class="font-semibold" />
    </div>

    <!-- Collection Form -->
    @if($showForm || $editingId)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6" id="collection-form">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900">
                <x-icon name="pencil-square" class="w-5 h-5 inline mr-2" />
                {{ $editingId ? 'Edit Collection' : 'New Collection' }}
            </h2>
            
            @if($editingId)
            <x-button wire:click="resetForm"
                      label="Cancel"
                      flat
                      sm
                      icon="x-mark" />
            @endif
        </div>

        <form wire:submit.prevent="save" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Collection Date -->
                <x-datetime-picker
                    label="Collection Date *"
                    placeholder="Select date"
                    wire:model="collection_date"
                    without-time
                    :max-date="now()"
                />

                <!-- Counted By -->
                <x-input
                    label="Counted By *"
                    wire:model="counted_by"
                    placeholder="Enter counter name"
                    class="bg-gray-50"
                />
            </div>

            <!-- Amounts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- First Service -->
                <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-4">
                    <x-input
                        label="First Service"
                        wire:model="first_service_amount"
                        type="number"
                        step="0.01"
                        prefix="Ksh"
                        placeholder="0.00"
                        class="border-emerald-200"
                    />
                </div>

                <!-- Second Service -->
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                    <x-input
                        label="Second Service"
                        wire:model="second_service_amount"
                        type="number"
                        step="0.01"
                        prefix="Ksh"
                        placeholder="0.00"
                        class="border-blue-200"
                    />
                </div>

                <!-- Children's Service -->
                <div class="bg-purple-50 border border-purple-100 rounded-lg p-4">
                    <x-input
                        label="Children's Service"
                        wire:model="children_service_amount"
                        type="number"
                        step="0.01"
                        prefix="Ksh"
                        placeholder="0.00"
                        class="border-purple-200"
                    />
                </div>

                <!-- M-Pesa Total -->
                <div class="bg-amber-50 border border-amber-100 rounded-lg p-4">
                    <x-input
                        label="M-Pesa Total"
                        wire:model="mobile_mpesa_amount"
                        type="number"
                        step="0.01"
                        prefix="Ksh"
                        placeholder="0.00"
                        class="border-amber-200"
                    />
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
                    Cash: Ksh{{ number_format($first_service_amount + $second_service_amount + $children_service_amount, 2) }}
                    | M-Pesa: Ksh{{ number_format($mobile_mpesa_amount, 2) }}
                </div>
            </div>

            <!-- Notes -->
            <x-textarea
                label="Notes (Optional)"
                wire:model="notes"
                rows="2"
                placeholder="Any special notes... (e.g., Thanksgiving Sunday, Special program, etc.)"
            />

            <!-- Submit Button -->
            <div class="pt-2">
                <x-button type="submit"
                          :label="$editingId ? 'Update Collection' : 'Save Collection'"
                          primary
                          :icon="$editingId ? 'check-circle' : 'plus-circle'"
                          class="font-semibold shadow-sm hover:shadow" />
            </div>
        </form>
    </div>
    @endif

    <!-- Workflow Sections -->
    <!-- Pending Collections -->
    @if($pendingCollections->count() > 0 && !$status)
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-3 h-3 rounded-full bg-amber-500 mr-3"></div>
                <h3 class="text-lg font-bold text-gray-900">Step 1: Mark as Counted</h3>
            </div>
            <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm font-semibold">
                {{ $pendingCollections->count() }} pending
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($pendingCollections->take(6) as $collection)
            <div class="bg-white border border-amber-200 rounded-lg p-4 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <span class="font-medium text-gray-900">
                        {{ $collection->collection_date->format('D, M j') }}
                    </span>
                    <span class="px-2 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">
                        Pending
                    </span>
                </div>
                
                <div class="space-y-2">
                    <div class="text-sm text-gray-600">Recorded by: {{ $collection->counted_by }}</div>
                    
                    <div class="flex items-center justify-between pt-2 border-t border-amber-100">
                        <span class="text-sm font-medium text-gray-700">Total:</span>
                        <span class="font-bold text-gray-900">
                            Ksh{{ number_format($collection->total_amount, 2) }}
                        </span>
                    </div>
                </div>
                
                <div class="mt-4 flex items-center justify-end space-x-2">
                    @if($collection->counted_by === auth()->user()->name)
                    <x-button wire:click="edit({{ $collection->id }})"
                              label="Edit"
                              flat
                              sm
                              icon="pencil-square"
                              color="gray" />
                    @endif
                    
                    <x-button wire:click="markAsCounted({{ $collection->id }})"
                              label="Mark as Counted"
                              sm
                              primary
                              icon="check" />
                </div>
            </div>
            @endforeach
        </div>
        
        @if($pendingCollections->count() > 6)
        <div class="mt-4 text-center">
            <x-button wire:click="$set('status', 'pending')"
                      :label="'View all ' . $pendingCollections->count() . ' pending'"
                      flat
                      sm
                      color="amber"
                      icon="list-bullet"
                      class="font-medium" />
        </div>
        @endif
    </div>
    @endif

    <!-- Counted Collections (Awaiting Verification) -->
    @if($countedCollections->count() > 0 && !$status)
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-3 h-3 rounded-full bg-blue-500 mr-3"></div>
                <h3 class="text-lg font-bold text-gray-900">Step 2: Verify Collection</h3>
            </div>
            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                {{ $countedCollections->count() }} to verify
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($countedCollections->take(6) as $collection)
            <div class="bg-white border border-blue-200 rounded-lg p-4 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <span class="font-medium text-gray-900">
                        {{ $collection->collection_date->format('D, M j') }}
                    </span>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                        Counted
                    </span>
                </div>
                
                <div class="space-y-2">
                    <div class="text-sm text-gray-600">Counted by: {{ $collection->counted_by }}</div>
                    
                    <div class="grid grid-cols-2 gap-2 pt-2 border-t border-blue-100">
                        <div>
                            <span class="text-xs text-gray-500">Cash:</span>
                            <div class="font-medium">
                                Ksh{{ number_format($this->getTotalPhysicalCash($collection), 2) }}
                            </div>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500">M-Pesa:</span>
                            <div class="font-medium">
                                Ksh{{ number_format($collection->mobile_mpesa_amount, 2) }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between pt-2 border-t border-blue-100">
                        <span class="text-sm font-medium text-gray-700">Total:</span>
                        <span class="font-bold text-gray-900">
                            Ksh{{ number_format($collection->total_amount, 2) }}
                        </span>
                    </div>
                </div>
                
                <div class="mt-4">
                    <x-button wire:click="verifyCollection({{ $collection->id }})"
                              label="Verify Collection"
                              full
                              primary
                              icon="shield-check" />
                </div>
            </div>
            @endforeach
        </div>
        
        @if($countedCollections->count() > 6)
        <div class="mt-4 text-center">
            <x-button wire:click="$set('status', 'counted')"
                      :label="'View all ' . $countedCollections->count() . ' to verify'"
                      flat
                      sm
                      color="blue"
                      icon="list-bullet"
                      class="font-medium" />
        </div>
        @endif
    </div>
    @endif

    <!-- Verified Collections (Ready for Banking) -->
    @if($verifiedCollections->count() > 0 && !$status)
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-3 h-3 rounded-full bg-purple-500 mr-3"></div>
                <h3 class="text-lg font-bold text-gray-900">Step 3: Bank Collection</h3>
            </div>
            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">
                {{ $verifiedCollections->count() }} to bank
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($verifiedCollections->take(6) as $collection)
            <div class="bg-white border border-purple-200 rounded-lg p-4 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <span class="font-medium text-gray-900">
                        {{ $collection->collection_date->format('D, M j') }}
                    </span>
                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">
                        Verified
                    </span>
                </div>
                
                <div class="space-y-2">
                    <div class="text-sm text-gray-600">
                        Verified by: {{ $collection->firstVerifier->name ?? 'Treasurer' }}
                    </div>
                    
                    <div class="flex items-center justify-between pt-2 border-t border-purple-100">
                        <span class="text-sm font-medium text-gray-700">Total:</span>
                        <span class="font-bold text-gray-900">
                            Ksh{{ number_format($collection->total_amount, 2) }}
                        </span>
                    </div>
                    
                    <div class="text-xs text-gray-500 flex items-center">
                        <x-icon name="calendar" class="w-3 h-3 mr-1" />
                        {{ $collection->collection_date->diffForHumans() }}
                    </div>
                </div>
                
                <div class="mt-4">
                    <x-button wire:click="startBanking({{ $collection->id }})"
                              label="Mark as Banked"
                              full
                              primary
                              color="purple"
                              icon="banknotes" />
                </div>
            </div>
            @endforeach
        </div>
        
        @if($verifiedCollections->count() > 6)
        <div class="mt-4 text-center">
            <x-button wire:click="$set('status', 'verified')"
                      :label="'View all ' . $verifiedCollections->count() . ' to bank'"
                      flat
                      sm
                      color="purple"
                      icon="list-bullet"
                      class="font-medium" />
        </div>
        @endif
    </div>
    @endif

    <!-- Search and Filters -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="flex items-center space-x-3">
            <!-- Record Count -->
            <div class="text-sm text-gray-600 bg-gray-50 px-3 py-1.5 rounded-lg">
                {{ $collections->total() }} total records
            </div>
        </div>
        
        <!-- Search Box -->
        <div class="w-full md:w-64">
            <x-input
                wire:model.debounce.300ms="search"
                placeholder="Search collections..."
                icon="magnifying-glass"
            />
        </div>
    </div>

    <!-- Simplified Filters -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Status Filter -->
            <x-select
                label="Status"
                wire:model="status"
                placeholder="All Status"
                :options="[
                    ['value' => '', 'label' => 'All Status'],
                    ['value' => 'pending', 'label' => 'Pending'],
                    ['value' => 'counted', 'label' => 'Counted'],
                    ['value' => 'verified', 'label' => 'Verified'],
                    ['value' => 'banked', 'label' => 'Banked'],
                    ['value' => 'cancelled', 'label' => 'Cancelled'],
                ]"
            />

            <!-- Month Filter -->
            <x-select
                label="Month"
                wire:model="month"
                placeholder="All Months"
                :options="collect(range(1, 12))->map(fn($m) => [
                    'value' => $m,
                    'label' => date('F', mktime(0, 0, 0, $m, 1))
                ])->prepend(['value' => '', 'label' => 'All Months'])"
            />

            <!-- Year Filter -->
            <x-select
                label="Year"
                wire:model="year"
                placeholder="All Years"
                :options="collect(range(date('Y'), date('Y') - 2))->map(fn($y) => [
                    'value' => $y,
                    'label' => $y
                ])->prepend(['value' => '', 'label' => 'All Years'])"
            />

            <!-- Items Per Page -->
            <x-select
                label="Show"
                wire:model="perPage"
                :options="[
                    ['value' => 10, 'label' => '10 per page'],
                    ['value' => 15, 'label' => '15 per page'],
                    ['value' => 25, 'label' => '25 per page'],
                    ['value' => 50, 'label' => '50 per page'],
                ]"
            />
        </div>
        
        <!-- Clear Filters -->
        @if($search || $status || $month || $year)
        <div class="mt-4 pt-4 border-t border-gray-100">
            <x-button wire:click="clearFilters"
                      label="Clear All Filters"
                      flat
                      sm
                      color="gray"
                      icon="funnel-x-mark"
                      class="hover:text-gray-900" />
        </div>
        @endif
    </div>

    <!-- Loading Indicator -->
    <div wire:loading wire:target="search, status, month, year, perPage" class="mb-4">
        <div class="flex items-center justify-center p-8">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-emerald-600"></div>
            <span class="ml-4 text-gray-600">Loading collections...</span>
        </div>
    </div>

    <!-- Collections Table -->
    <x-card class="overflow-hidden" wire:loading.remove wire:target="search, status, month, year, perPage">
        <x-table>
            <x-slot name="thead">
                <x-table.th sortable wire:click="sortBy('collection_date')" :direction="$sortField === 'collection_date' ? $sortDirection : null">
                    Date
                </x-table.th>
                <x-table.th>Amounts</x-table.th>
                <x-table.th>Status</x-table.th>
                <x-table.th>Counted By</x-table.th>
                <x-table.th>Actions</x-table.th>
            </x-slot>
            
            <x-slot name="tbody">
                @forelse($collections as $collection)
                <x-table.tr wire:key="row-{{ $collection->id }}" class="hover:bg-gray-50">
                    <!-- Date -->
                    <x-table.td>
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
                    </x-table.td>

                    <!-- Amounts -->
                    <x-table.td>
                        <div class="space-y-1">
                            <div class="flex items-center text-sm">
                                <span class="text-gray-600">Cash:</span>
                                <span class="ml-auto font-medium">Ksh{{ number_format($this->getTotalPhysicalCash($collection), 2) }}</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <span class="text-gray-600">M-Pesa:</span>
                                <span class="ml-auto font-medium text-amber-700">Ksh{{ number_format($collection->mobile_mpesa_amount, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between pt-1 border-t border-gray-100">
                                <span class="text-sm font-medium text-gray-900">Total:</span>
                                <span class="font-bold text-gray-900">Ksh{{ number_format($collection->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </x-table.td>

                    <!-- Status -->
                    <x-table.td>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'counted' => 'bg-blue-100 text-blue-800',
                                'verified' => 'bg-purple-100 text-purple-800',
                                'banked' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$collection->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($collection->status) }}
                        </span>
                        
                        @if($collection->verified_by)
                        <div class="mt-1 text-xs text-gray-500 flex items-center">
                            <x-icon name="user-check" class="w-3 h-3 mr-1 text-green-500" />
                            Verified by {{ $collection->firstVerifier->name ?? 'Treasurer' }}
                        </div>
                        @endif
                    </x-table.td>

                    <!-- Counted By -->
                    <x-table.td>
                        <div class="text-sm text-gray-900">{{ $collection->counted_by }}</div>
                        @if($collection->notes)
                        <div class="text-xs text-gray-500 truncate max-w-xs" title="{{ $collection->notes }}">
                            <x-icon name="chat-bubble-left-right" class="w-3 h-3 inline mr-1" />
                            {{ Str::limit($collection->notes, 30) }}
                        </div>
                        @endif
                    </x-table.td>

                    <!-- Actions -->
                    <x-table.td>
                        <div class="flex items-center space-x-1">
                            <!-- Edit -->
                            @if(in_array($collection->status, ['pending', 'counted']) && $collection->counted_by === auth()->user()->name)
                            <x-button wire:click="edit({{ $collection->id }})"
                                      icon="pencil-square"
                                      flat
                                      xs
                                      color="blue"
                                      title="Edit" />
                            @endif

                            <!-- Mark as Counted -->
                            @if($collection->status === 'pending')
                            <x-button wire:click="markAsCounted({{ $collection->id }})"
                                      icon="check"
                                      flat
                                      xs
                                      color="green"
                                      title="Mark as Counted" />
                            @endif

                            <!-- Verify Collection -->
                            @if($collection->status === 'counted')
                            <x-button wire:click="verifyCollection({{ $collection->id }})"
                                      icon="shield-check"
                                      flat
                                      xs
                                      color="indigo"
                                      title="Verify" />
                            @endif

                            <!-- Mark as Banked -->
                            @if($collection->status === 'verified')
                            <x-button wire:click="startBanking({{ $collection->id }})"
                                      icon="banknotes"
                                      flat
                                      xs
                                      color="emerald"
                                      title="Mark as Banked" />
                            @endif

                            <!-- Duplicate -->
                            <x-button wire:click="duplicateCollection({{ $collection->id }})"
                                      icon="document-duplicate"
                                      flat
                                      xs
                                      color="purple"
                                      title="Duplicate" />

                            <!-- Cancel -->
                            @if(in_array($collection->status, ['pending', 'counted']))
                            <x-button wire:click="cancel({{ $collection->id }})"
                                      icon="x-circle"
                                      flat
                                      xs
                                      color="red"
                                      title="Cancel"
                                      x-on:click="confirm('Are you sure you want to cancel this collection?') || $event.stopImmediatePropagation()" />
                            @endif
                        </div>
                    </x-table.td>
                </x-table.tr>
                @empty
                <x-table.tr>
                    <x-table.td colspan="5" class="text-center py-12">
                        <div class="text-gray-400">
                            <x-icon name="calendar-x-mark" class="w-12 h-12 mx-auto mb-3" />
                            <p class="text-lg font-medium text-gray-500">No Sunday collections found</p>
                            <x-button wire:click="$toggle('showForm')"
                                      label="Record First Collection"
                                      primary
                                      icon="plus"
                                      class="mt-3" />
                        </div>
                    </x-table.td>
                </x-table.tr>
                @endforelse
            </x-slot>
        </x-table>
        
        <!-- Pagination -->
        @if($collections->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $collections->links() }}
        </div>
        @endif
    </x-card>

    <!-- Monthly Summary -->
    @if($monthlyBreakdown->count() > 0)
    <div class="mt-8">
        <x-card>
            <x-slot name="title">
                <div class="flex items-center">
                    <x-icon name="chart-bar" class="w-5 h-5 mr-2" />
                    Monthly Collection Summary
                </div>
            </x-slot>
            
            <x-table>
                <x-slot name="thead">
                    <x-table.th>Month</x-table.th>
                    <x-table.th>Collections</x-table.th>
                    <x-table.th>Cash Total</x-table.th>
                    <x-table.th>M-Pesa Total</x-table.th>
                    <x-table.th>Grand Total</x-table.th>
                    <x-table.th>Status</x-table.th>
                </x-slot>
                
                <x-slot name="tbody">
                    @foreach($monthlyBreakdown as $monthData)
                    @php
                        $monthCollections = SundayCollection::forCurrentTenant()
                            ->whereYear('collection_date', $monthData->year)
                            ->whereMonth('collection_date', $monthData->month)
                            ->get();
                        
                        $cash = $monthCollections->sum(function($c) {
                            return $c->first_service_amount + $c->second_service_amount + $c->children_service_amount;
                        });
                        
                        $mpesa = $monthCollections->sum('mobile_mpesa_amount');
                        
                        $banked = $monthCollections->where('status', 'banked')->count();
                        $total = $monthCollections->count();
                    @endphp
                    <x-table.tr class="hover:bg-gray-50">
                        <x-table.td>
                            <span class="font-medium text-gray-900">
                                {{ date('F', mktime(0, 0, 0, $monthData->month, 1)) }} {{ $monthData->year }}
                            </span>
                        </x-table.td>
                        <x-table.td>
                            <span class="text-sm text-gray-600">{{ $total }} Sundays</span>
                        </x-table.td>
                        <x-table.td>
                            <span class="font-medium">Ksh{{ number_format($cash, 2) }}</span>
                        </x-table.td>
                        <x-table.td>
                            <span class="font-medium">Ksh{{ number_format($mpesa, 2) }}</span>
                        </x-table.td>
                        <x-table.td>
                            <span class="font-bold text-gray-900">Ksh{{ number_format($monthData->total, 2) }}</span>
                        </x-table.td>
                        <x-table.td>
                            <span class="text-sm {{ $banked === $total ? 'text-green-600' : ($banked > 0 ? 'text-amber-600' : 'text-red-600') }}">
                                @if($banked === $total)
                                    <x-icon name="check-circle" class="w-3 h-3 inline mr-1" />
                                    Fully banked
                                @elseif($banked > 0)
                                    <x-icon name="exclamation-circle" class="w-3 h-3 inline mr-1" />
                                    {{ $banked }}/{{ $total }} banked
                                @else
                                    <x-icon name="x-circle" class="w-3 h-3 inline mr-1" />
                                    Not banked
                                @endif
                            </span>
                        </x-table.td>
                    </x-table.tr>
                    @endforeach
                </x-slot>
            </x-table>
        </x-card>
    </div>
    @endif

    <!-- Banking Modal -->
    <x-modal wire:model.defer="bankingId" max-width="md">
        <x-card>
            <x-slot name="title">
                <div class="flex items-center">
                    <x-icon name="banknotes" class="w-5 h-5 mr-2" />
                    Mark as Banked
                </div>
            </x-slot>

            <form wire:submit.prevent="markAsBanked" class="space-y-4">
                <x-datetime-picker
                    label="Deposit Date *"
                    placeholder="Select deposit date"
                    wire:model="bank_deposit_date"
                    without-time
                    :max-date="now()"
                />
                
                <x-input
                    label="Bank Slip Number (Optional)"
                    wire:model="bank_slip_number"
                    placeholder="e.g., DEP-00123"
                />
                
                <x-slot name="footer">
                    <div class="flex items-center justify-end space-x-3">
                        <x-button flat label="Cancel" x-on:click="close" />
                        <x-button type="submit" primary label="Confirm Banking" icon="check-circle" />
                    </div>
                </x-slot>
            </form>
        </x-card>
    </x-modal>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('scroll-to-form', function() {
                const form = document.getElementById('collection-form');
                if (form) {
                    form.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</div>
