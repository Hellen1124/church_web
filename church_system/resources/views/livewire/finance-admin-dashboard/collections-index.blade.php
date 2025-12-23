@php use Illuminate\Support\Str; @endphp
@php
use App\Models\SundayCollection;
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
                    <i data-lucide="shield-check" class="w-4 h-4 mr-1.5"></i>
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
                    <i data-lucide="clock" class="w-6 h-6 text-amber-700"></i>
                </div>
            </div>
            <div class="mt-3">
                @if($pendingCollections->count() > 0)
                <button wire:click="$set('status', 'pending')"
                        class="text-xs font-medium text-amber-700 hover:text-amber-900 flex items-center">
                    <i data-lucide="arrow-right" class="w-3 h-3 mr-1"></i>
                    Mark as counted
                </button>
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
                    <i data-lucide="shield" class="w-6 h-6 text-blue-700"></i>
                </div>
            </div>
            <div class="mt-3">
                @if($countedCollections->count() > 0)
                <button wire:click="$set('status', 'counted')"
                        class="text-xs font-medium text-blue-700 hover:text-blue-900 flex items-center">
                    <i data-lucide="arrow-right" class="w-3 h-3 mr-1"></i>
                    Verify now
                </button>
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
                    <i data-lucide="banknote" class="w-6 h-6 text-purple-700"></i>
                </div>
            </div>
            <div class="mt-3">
                @if($verifiedCollections->count() > 0)
                <button wire:click="$set('status', 'verified')"
                    class="text-xs font-medium text-purple-700 hover:text-purple-900 flex items-center">
                    <i data-lucide="arrow-right" class="w-3 h-3 mr-1"></i>
                    Bank now
                </button>
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
                    <i data-lucide="calendar" class="w-6 h-6 text-emerald-700"></i>
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
        <button wire:click="$toggle('showForm')" 
                class="inline-flex items-center px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition duration-200 shadow-sm hover:shadow">
            <i data-lucide="{{ $showForm ? 'x' : 'plus-circle' }}" class="w-5 h-5 mr-2"></i>
            {{ $showForm ? 'Close Form' : 'Record New Collection' }}
        </button>
        
        <button wire:click="export" 
                class="inline-flex items-center px-5 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
            <i data-lucide="download" class="w-5 h-5 mr-2"></i> Export CSV
        </button>
    </div>

    <!-- Collection Form -->
    @if($showForm || $editingId)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6" id="collection-form">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900">
                <i data-lucide="{{ $editingId ? 'edit' : 'plus-circle' }}" class="w-5 h-5 inline mr-2"></i>
                {{ $editingId ? 'Edit Collection' : 'New Collection' }}
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

                <!-- Counted By (auto-filled) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Counted By *</label>

                    <input type="text" wire:model="counted_by"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition bg-gray-50">

                    @error('counted_by')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
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
                    Cash: Ksh{{ number_format($first_service_amount + $second_service_amount + $children_service_amount, 2) }}
                    | M-Pesa: Ksh{{ number_format($mobile_mpesa_amount, 2) }}
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
                    <button wire:click="edit({{ $collection->id }})"
                            class="px-3 py-1.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition flex items-center">
                        <i data-lucide="edit" class="w-3 h-3 mr-1"></i>
                        Edit
                    </button>
                    @endif
                    
                    <button wire:click="markAsCounted({{ $collection->id }})"
                            class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition flex items-center">
                        <i data-lucide="check" class="w-3 h-3 mr-1"></i>
                        Mark as Counted
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($pendingCollections->count() > 6)
        <div class="mt-4 text-center">
            <button wire:click="$set('status', 'pending')"
                    class="text-sm font-medium text-amber-600 hover:text-amber-800 flex items-center justify-center mx-auto">
                <i data-lucide="list" class="w-4 h-4 mr-1"></i>
                View all {{ $pendingCollections->count() }} pending
            </button>
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
                    <button wire:click="verifyCollection({{ $collection->id }})"
                            class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-4 h-4 mr-2"></i>
                        Verify Collection
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($countedCollections->count() > 6)
        <div class="mt-4 text-center">
            <button wire:click="$set('status', 'counted')"
                    class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center justify-center mx-auto">
                <i data-lucide="list" class="w-4 h-4 mr-1"></i>
                View all {{ $countedCollections->count() }} to verify
            </button>
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
                    
                    <div class="text-xs text-gray-500">
                        <i data-lucide="calendar" class="w-3 h-3 inline mr-1"></i>
                        {{ $collection->collection_date->diffForHumans() }}
                    </div>
                </div>
                
                <div class="mt-4">
                    <button wire:click="startBanking({{ $collection->id }})"
                            class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition flex items-center justify-center">
                        <i data-lucide="banknote" class="w-4 h-4 mr-2"></i>
                        Mark as Banked
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($verifiedCollections->count() > 6)
        <div class="mt-4 text-center">
            <button wire:click="$set('status', 'verified')"
                    class="text-sm font-medium text-purple-600 hover:text-purple-800 flex items-center justify-center mx-auto">
                <i data-lucide="list" class="w-4 h-4 mr-1"></i>
                View all {{ $verifiedCollections->count() }} to bank
            </button>
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
            <div class="relative">
                <i data-lucide="search" class="absolute left-3 top-3.5 w-4 h-4 text-gray-400"></i>
                <input type="text" wire:model.debounce.300ms="search" 
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                       placeholder="Search collections...">
            </div>
        </div>
    </div>

    <!-- Simplified Filters -->
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
        
        <!-- Clear Filters -->
        @if($search || $status || $month || $year)
        <div class="mt-4 pt-4 border-t border-gray-100">
            <button wire:click="clearFilters" 
                    class="inline-flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition">
                <i data-lucide="filter-x" class="w-4 h-4 mr-2"></i> Clear All Filters
            </button>
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Amounts</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Counted By</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($collections as $collection)
                    <tr class="hover:bg-gray-50 transition">
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

                        <!-- Amounts -->
                        <td class="px-6 py-4">
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
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
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
                                <i data-lucide="user-check" class="w-3 h-3 mr-1 text-green-500"></i>
                                Verified by {{ $collection->firstVerifier->name ?? 'Treasurer' }}
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

                        <!-- Simplified Actions -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-1">
                                <!-- Edit (only for pending/counted collections they created) -->
                                @if(in_array($collection->status, ['pending', 'counted']) && $collection->counted_by === auth()->user()->name)
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

                                <!-- Verify Collection -->
                                @if($collection->status === 'counted')
                                <button wire:click="verifyCollection({{ $collection->id }})" 
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

                                <!-- Cancel -->
                                @if(in_array($collection->status, ['pending', 'counted']))
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
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i data-lucide="calendar-x" class="w-12 h-12 mx-auto mb-3"></i>
                                <p class="text-lg font-medium text-gray-500">No Sunday collections found</p>
                                <button wire:click="$toggle('showForm')"
                                        class="mt-3 inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition">
                                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                    Record First Collection
                                </button>
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

    <!-- Monthly Summary -->
    @if($monthlyBreakdown->count() > 0)
    <div class="mt-8 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
            <i data-lucide="trending-up" class="w-5 h-5 mr-2"></i> Monthly Collection Summary
        </h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Month</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Collections</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cash Total</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">M-Pesa Total</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Grand Total</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
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
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <span class="font-medium text-gray-900">
                                {{ date('F', mktime(0, 0, 0, $monthData->month, 1)) }} {{ $monthData->year }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-gray-600">{{ $total }} Sundays</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-medium">Ksh{{ number_format($cash, 2) }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-medium">Ksh{{ number_format($mpesa, 2) }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-bold text-gray-900">Ksh{{ number_format($monthData->total, 2) }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm {{ $banked === $total ? 'text-green-600' : ($banked > 0 ? 'text-amber-600' : 'text-red-600') }}">
                                @if($banked === $total)
                                    <i data-lucide="check-circle" class="w-3 h-3 inline mr-1"></i> Fully banked
                                @elseif($banked > 0)
                                    <i data-lucide="alert-circle" class="w-3 h-3 inline mr-1"></i> {{ $banked }}/{{ $total }} banked
                                @else
                                    <i data-lucide="x-circle" class="w-3 h-3 inline mr-1"></i> Not banked
                                @endif
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                           max="{{ now()->format('Y-m-d') }}">
                    @error('bank_deposit_date') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bank Slip Number (Optional)</label>
                    <input type="text" wire:model="bank_slip_number" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                           placeholder="e.g., DEP-00123">
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

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            Livewire.on('scroll-to-form', function() {
                const form = document.getElementById('collection-form');
                if (form) {
                    form.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</div>
