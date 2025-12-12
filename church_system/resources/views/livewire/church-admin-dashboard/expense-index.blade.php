@php use Illuminate\Support\Str; @endphp
<div>
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <!-- Current Month Expenses -->
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700">This Month</p>
                    <p class="text-2xl font-bold text-emerald-900 mt-1">Ksh{{ number_format($currentMonthTotal, 2) }}</p>
                </div>
                <i data-lucide="calendar" class="w-8 h-8 text-emerald-600"></i>
            </div>
            <div class="mt-2 text-xs text-emerald-600">
                @php
                    $currentMonthCount = \App\Models\Expense::forCurrentTenant()
                        ->thisMonth()
                        ->whereIn('status', ['approved', 'paid'])
                        ->count();
                @endphp
                {{ $currentMonthCount }} {{ Str::plural('expense', $currentMonthCount) }}
            </div>
        </div>

        <!-- Last Month Expenses -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700">Last Month</p>
                    <p class="text-2xl font-bold text-blue-900 mt-1">Ksh{{ number_format($lastMonthTotal, 2) }}</p>
                </div>
                <i data-lucide="trending-up" class="w-8 h-8 text-blue-600"></i>
            </div>
            <div class="mt-2 text-xs text-blue-600">
                @php
                    $lastMonthCount = \App\Models\Expense::forCurrentTenant()
                        ->lastMonth()
                        ->whereIn('status', ['approved', 'paid'])
                        ->count();
                @endphp
                {{ $lastMonthCount }} {{ Str::plural('expense', $lastMonthCount) }}
            </div>
        </div>

        <!-- Pending Approval -->
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-700">Pending</p>
                    <p class="text-2xl font-bold text-amber-900 mt-1">Ksh{{ number_format($pendingTotal, 2) }}</p>
                </div>
                <i data-lucide="clock" class="w-8 h-8 text-amber-600"></i>
            </div>
            <div class="mt-2 text-xs text-amber-600">
                @php
                    $pendingCount = \App\Models\Expense::forCurrentTenant()
                        ->pending()
                        ->count();
                @endphp
                {{ $pendingCount }} {{ Str::plural('expense', $pendingCount) }} awaiting approval
            </div>
        </div>

        <!-- Approved (Unpaid) -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">Approved</p>
                    <p class="text-2xl font-bold text-purple-900 mt-1">Ksh{{ number_format($approvedTotal, 2) }}</p>
                </div>
                <i data-lucide="check-circle" class="w-8 h-8 text-purple-600"></i>
            </div>
            <div class="mt-2 text-xs text-purple-600">
                @php
                    $approvedCount = \App\Models\Expense::forCurrentTenant()
                        ->approved()
                        ->count();
                @endphp
                {{ $approvedCount }} {{ Str::plural('expense', $approvedCount) }} ready for payment
            </div>
        </div>
    </div>

    <!-- Top Expense Categories -->
    @if($topCategories->count() > 0)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 mb-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
            <i data-lucide="pie-chart" class="w-4 h-4 mr-2"></i> Top Expense Categories (Last 3 Months)
        </h3>
        <div class="space-y-3">
            @foreach($topCategories as $category)
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm text-gray-700">{{ $category->category->name ?? 'Uncategorized' }}</span>
                    <span class="text-sm font-medium text-gray-900">Ksh{{ number_format($category->total, 2) }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    @php
                        $maxAmount = $topCategories->max('total');
                        $percentage = $maxAmount > 0 ? ($category->total / $maxAmount) * 100 : 0;
                        $colors = ['bg-emerald-500', 'bg-blue-500', 'bg-purple-500', 'bg-amber-500', 'bg-red-500'];
                        $color = $colors[$loop->index % count($colors)];
                    @endphp
                    <div class="{{ $color }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Form Toggle Button -->
    <div class="mb-6">
        <button wire:click="$toggle('showForm')" 
                class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition duration-200 shadow-sm hover:shadow">
            <i data-lucide="{{ $editingId ? 'edit' : 'plus-circle' }}" class="w-5 h-5 mr-2"></i>
            {{ $editingId ? 'Editing Expense' : 'Record New Expense' }}
            <i data-lucide="chevron-{{ $showForm ? 'up' : 'down' }}" class="w-5 h-5 ml-2"></i>
        </button>
    </div>

    <!-- Form Section (Collapsible) -->
    @if($showForm || $editingId)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6" id="expense-form">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900">
                <i data-lucide="{{ $editingId ? 'edit' : 'plus-circle' }}" class="w-5 h-5 inline mr-2"></i>
                {{ $editingId ? 'Edit Expense' : 'Record New Expense' }}
            </h2>
            @if($editingId)
            <button wire:click="resetForm" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
                <i data-lucide="x" class="w-4 h-4 mr-1"></i> Cancel
            </button>
            @endif
        </div>

        <form wire:submit.prevent="save" class="space-y-6">
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Expense Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expense Date *</label>
                    <input type="date" wire:model="expense_date" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    @error('expense_date') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Expense Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expense Number</label>
                    <input type="text" wire:model="expense_number" readonly
                           class="w-full px-4 py-2.5 border border-gray-300 bg-gray-50 rounded-lg">
                </div>
            </div>

            <!-- Category and Amount -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                    <select wire:model="expense_category_id" 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('expense_category_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Amount -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Amount (Ksh) *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">Ksh</span>
                        <input type="number" step="0.01" wire:model="amount" 
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    </div>
                    @error('amount') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                <input type="text" wire:model="description" 
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                       placeholder="e.g., 5 loaves of bread, 1 box of milk for pastoral team">
                @error('description') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <!-- Payment Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Paid To -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Paid To *</label>
                    <input type="text" wire:model="paid_to" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                           placeholder="e.g., Supermarket, John Doe, Kenya Power">
                    @error('paid_to') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Payment Method -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method *</label>
                    <select wire:model="payment_method" 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                        @foreach($paymentMethods as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('payment_method') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Reference Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reference Number</label>
                    <input type="text" wire:model="reference_number" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                           placeholder="e.g., MPESA code, Invoice #">
                    @error('reference_number') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Receipt & Notes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Receipt Available -->
                <div class="flex items-center space-x-3">
                    <input type="checkbox" wire:model="receipt_available" id="receipt_available"
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <label for="receipt_available" class="text-sm text-gray-700">
                        Receipt Available
                    </label>
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                    <textarea wire:model="notes" rows="2" 
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                              placeholder="Additional notes..."></textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-gray-200">
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition duration-200 shadow-sm hover:shadow">
                    <i data-lucide="{{ $editingId ? 'save' : 'check-circle' }}" class="w-5 h-5 mr-2"></i>
                    {{ $editingId ? 'Update Expense' : 'Save Expense' }}
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
                {{ $expenses->total() }} total expenses
            </div>
        </div>
        
        <!-- Search Box -->
        <div class="w-full md:w-64">
            <div class="relative">
                <i data-lucide="search" class="absolute left-3 top-3.5 w-4 h-4 text-gray-400"></i>
                <input type="text" wire:model.debounce.300ms="search" 
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                       placeholder="Search expenses...">
            </div>
        </div>
    </div>

    <!-- Enhanced Filters -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model="status" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="paid">Paid</option>
                    <option value="rejected">Rejected</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select wire:model="category_id" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
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
        @if($search || $status || $category_id || $month || $year)
        <div class="mt-4 pt-4 border-t border-gray-100">
            <button wire:click="clearFilters" 
                    class="inline-flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition">
                <i data-lucide="filter-x" class="w-4 h-4 mr-2"></i> Clear All Filters
            </button>
        </div>
        @endif
    </div>

    <!-- Loading Indicator -->
    <div wire:loading wire:target="search, status, category_id, month, year, perPage" class="mb-4">
        <div class="flex items-center justify-center p-8">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-emerald-600"></div>
            <span class="ml-4 text-gray-600">Loading expenses...</span>
        </div>
    </div>

    <!-- Expenses Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden" wire:loading.remove wire:target="search, status, category_id, month, year, perPage">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Details</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Payment Info</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($expenses as $expense)
                    <tr class="hover:bg-gray-50 transition">
                        <!-- Date -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $expense->expense_date->format('D, M j, Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $expense->expense_number }}
                            </div>
                        </td>

                        <!-- Details -->
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-900">Category:</span>
                                    <span class="text-sm text-gray-700">{{ $expense->category->name ?? 'N/A' }}</span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    {{ $expense->description }}
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">Paid to:</span>
                                    <span class="text-sm font-medium">{{ $expense->paid_to }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-gray-900">Amount:</span>
                                    <span class="text-lg font-bold text-gray-900">Ksh{{ number_format($expense->amount, 2) }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- Payment Info -->
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                <div class="flex items-center text-sm">
                                    <i data-lucide="credit-card" class="w-4 h-4 mr-2 text-gray-400"></i>
                                    <span class="text-gray-600">Method:</span>
                                    <span class="ml-auto font-medium capitalize">{{ $expense->payment_method }}</span>
                                </div>
                                @if($expense->reference_number)
                                <div class="flex items-center text-sm">
                                    <i data-lucide="hash" class="w-4 h-4 mr-2 text-gray-400"></i>
                                    <span class="text-gray-600">Ref:</span>
                                    <span class="ml-auto font-medium">{{ $expense->reference_number }}</span>
                                </div>
                                @endif
                                @if($expense->receipt_available)
                                <div class="flex items-center text-sm text-emerald-600">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                                    Receipt Available
                                </div>
                                @endif
                                @if($expense->notes)
                                <div class="text-xs text-gray-500 truncate max-w-xs" title="{{ $expense->notes }}">
                                    <i data-lucide="message-square" class="w-3 h-3 inline mr-1"></i>
                                    {{ Str::limit($expense->notes, 30) }}
                                </div>
                                @endif
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'approved' => 'bg-blue-100 text-blue-800',
                                    'paid' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    'cancelled' => 'bg-gray-100 text-gray-800',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$expense->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($expense->status) }}
                            </span>
                            
                            <!-- Approval Status -->
                            @if($expense->approved_by || $expense->approved_by_2)
                            <div class="mt-1 text-xs text-gray-500">
                                @if($expense->approved_by && $expense->approved_by_2)
                                    <i data-lucide="check-circle" class="w-3 h-3 inline text-green-500"></i> Dual approved
                                @elseif($expense->approved_by || $expense->approved_by_2)
                                    <i data-lucide="alert-circle" class="w-3 h-3 inline text-yellow-500"></i> Single approved
                                @endif
                            </div>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex flex-col space-y-2">
                                <!-- View/Edit -->
                                <div class="flex space-x-1">
                                    @if($expense->status === 'pending')
                                    <button wire:click="edit({{ $expense->id }})" 
                                            class="p-1.5 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded transition"
                                            title="Edit">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    @endif

                                    <!-- Approve -->
                                    @if($expense->status === 'pending')
                                    <button wire:click="startApproval({{ $expense->id }})" 
                                            class="p-1.5 text-green-600 hover:text-green-900 hover:bg-green-50 rounded transition"
                                            title="Approve">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </button>
                                    @endif

                                    <!-- Mark as Paid -->
                                    @if($expense->status === 'approved')
                                    <button wire:click="startPayment({{ $expense->id }})" 
                                            class="p-1.5 text-emerald-600 hover:text-emerald-900 hover:bg-emerald-50 rounded transition"
                                            title="Mark as Paid">
                                        <i data-lucide="banknote" class="w-4 h-4"></i>
                                    </button>
                                    @endif
                                </div>

                                <!-- Reject/Cancel/Delete -->
                                <div class="flex space-x-1">
                                    @if($expense->status === 'pending')
                                    <button wire:click="reject({{ $expense->id }})" 
                                            onclick="return confirm('Reject this expense?')"
                                            class="p-1.5 text-red-600 hover:text-red-900 hover:bg-red-50 rounded transition"
                                            title="Reject">
                                        <i data-lucide="x" class="w-4 h-4"></i>
                                    </button>
                                    
                                    <button wire:click="delete({{ $expense->id }})" 
                                            onclick="return confirm('Delete this expense?')"
                                            class="p-1.5 text-red-600 hover:text-red-900 hover:bg-red-50 rounded transition"
                                            title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                    @elseif(in_array($expense->status, ['pending', 'approved']))
                                    <button wire:click="cancel({{ $expense->id }})" 
                                            onclick="return confirm('Cancel this expense?')"
                                            class="p-1.5 text-red-600 hover:text-red-900 hover:bg-red-50 rounded transition"
                                            title="Cancel">
                                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i data-lucide="credit-card" class="w-12 h-12 mx-auto mb-3"></i>
                                <p class="text-lg font-medium text-gray-500">No expenses found</p>
                                <p class="text-sm text-gray-400 mt-1">Start by recording your first expense above.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($expenses->hasPages())
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            {{ $expenses->links() }}
        </div>
        @endif
    </div>

    <!-- Monthly Breakdown -->
    @if($monthlyBreakdown->count() > 0)
    <div class="mt-8">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
            <i data-lucide="trending-up" class="w-5 h-5 mr-2"></i> Monthly Expense Trends
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($monthlyBreakdown as $monthData)
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="text-sm font-medium text-gray-500 truncate">
                    {{ date('F', mktime(0, 0, 0, $monthData->month, 1)) }} {{ $monthData->year }}
                </div>
                <div class="text-xl font-bold text-gray-900 mt-1 truncate" title="Ksh{{ number_format($monthData->total, 2) }}">
                    Ksh{{ number_format($monthData->total, 2) }}
                </div>
                <div class="text-xs text-gray-400 mt-1">
                    @php
                        $expensesCount = \App\Models\Expense::forCurrentTenant()
                            ->whereYear('expense_date', $monthData->year)
                            ->whereMonth('expense_date', $monthData->month)
                            ->whereIn('status', ['approved', 'paid'])
                            ->count();
                    @endphp
                    {{ $expensesCount }} {{ Str::plural('expense', $expensesCount) }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Modals -->
    <!-- Approval Modal -->
    @if($approvingId)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4" 
         x-data="{ open: true }" 
         x-show="open"
         x-transition>
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6" @click.outside="open = false">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Approve Expense</h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="text-sm text-gray-600">
                    Which committee member are you?
                </div>
                
                <div class="space-y-2">
                    <button wire:click="approveFirst" 
                            class="w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition text-center">
                        <i data-lucide="user-check" class="w-5 h-5 inline mr-2"></i>
                        I am the First Approver (Treasurer)
                    </button>
                    
                    <button wire:click="approveSecond" 
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

    <!-- Payment Modal -->
    @if($payingId)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4" 
         x-data="{ open: true }" 
         x-show="open"
         x-transition>
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6" @click.outside="open = false">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Mark as Paid</h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form wire:submit.prevent="markAsPaid" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Date *</label>
                    <input type="date" wire:model="payment_date" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    @error('payment_date') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Reference (Optional)</label>
                    <input type="text" wire:model="payment_reference" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                           placeholder="e.g., MPESA code, Cheque #">
                    @error('payment_reference') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                
                <div class="pt-4 border-t border-gray-200 flex items-center justify-end space-x-3">
                    <button type="button" @click="open = false" 
                            class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition">
                        <i data-lucide="check-circle" class="w-5 h-5 inline mr-2"></i>
                        Confirm Payment
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
                document.getElementById('expense-form').scrollIntoView({ 
                    behavior: 'smooth' 
                });
            });
        });
    </script>
</div>