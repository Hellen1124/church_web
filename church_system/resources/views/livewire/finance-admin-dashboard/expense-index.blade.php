@php use Illuminate\Support\Str; @endphp
<div>
    <!-- Treasurer Dashboard Header -->
    <div class="mb-8">
        <x-card class="bg-gradient-to-r from-blue-50 to-white border-l-4 border-l-blue-600">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                        <x-icon name="banknotes" class="w-8 h-8 text-blue-600" />
                        Church Expenses Management
                    </h1>
                    <p class="text-gray-600 mt-1">Treasurer Dashboard • Review, approve, and track all church expenditures</p>
                </div>
                <div class="flex items-center space-x-3">
                    <x-badge blue rounded class="flex items-center">
                        <x-icon name="shield-check" class="w-4 h-4 mr-1.5" />
                        Treasurer Access
                    </x-badge>
                    <span class="text-sm text-gray-600">
                        {{ auth()->user()->name }}
                    </span>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Simplified Status Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <!-- Pending Review -->
        <x-card class="border-l-4 border-l-yellow-500 hover:shadow-lg transition-shadow cursor-pointer"
                @click="$wire.set('status', 'pending')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-yellow-600">Pending Review</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ $pendingCount }}
                    </p>
                    <p class="text-xs text-gray-600 mt-1">Ksh{{ number_format($pendingTotal, 2) }}</p>
                </div>
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <x-icon name="clock" class="w-6 h-6 text-yellow-600" />
                </div>
            </div>
            @if($pendingCount > 0)
            <div class="mt-3 pt-3 border-t border-yellow-100">
                <x-button flat xs full class="text-yellow-600 hover:text-yellow-800"
                          @click="$wire.set('status', 'pending')">
                    <x-icon name="arrow-right" class="w-3 h-3 mr-1" />
                    Review now
                </x-button>
            </div>
            @endif
        </x-card>

        <!-- Approved Unpaid -->
        <x-card class="border-l-4 border-l-blue-500 hover:shadow-lg transition-shadow cursor-pointer"
                @click="$wire.set('status', 'approved')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600">Ready for Payment</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ $approvedUnpaidCount }}
                    </p>
                    <p class="text-xs text-gray-600 mt-1">Ksh{{ number_format($approvedUnpaidTotal, 2) }}</p>
                </div>
                <div class="p-2 bg-blue-100 rounded-lg">
                    <x-icon name="currency-dollar" class="w-6 h-6 text-blue-600" />
                </div>
            </div>
            @if($approvedUnpaidCount > 0)
            <div class="mt-3 pt-3 border-t border-blue-100">
                <x-button flat xs full class="text-blue-600 hover:text-blue-800"
                          @click="$wire.set('status', 'approved')">
                    <x-icon name="arrow-right" class="w-3 h-3 mr-1" />
                    Pay now
                </x-button>
            </div>
            @endif
        </x-card>

        <!-- Current Month -->
        <x-card class="border-l-4 border-l-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600">This Month</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        Ksh{{ number_format($currentMonthTotal, 2) }}
                    </p>
                    <p class="text-xs text-gray-600 mt-1">{{ $currentMonthCount }} expenses</p>
                </div>
                <div class="p-2 bg-green-100 rounded-lg">
                    <x-icon name="calendar" class="w-6 h-6 text-green-600" />
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-green-100">
                <span class="text-xs text-green-600">
                    {{ now()->format('F Y') }}
                </span>
            </div>
        </x-card>

        <!-- Last Month -->
        <x-card class="border-l-4 border-l-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-600">Last Month</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        Ksh{{ number_format($lastMonthTotal, 2) }}
                    </p>
                    <p class="text-xs text-gray-600 mt-1">For comparison</p>
                </div>
                <div class="p-2 bg-purple-100 rounded-lg">
                    <x-icon name="chart-bar" class="w-6 h-6 text-purple-600" />
                </div>
            </div>
        </x-card>
    </div>

    <!-- Quick Action Buttons -->
    <div class="flex flex-wrap gap-3 mb-6">
        <x-button 
            primary 
            :icon="$showForm ? 'x-mark' : 'plus-circle'"
            wire:click="$toggle('showForm')"
            :label="$showForm ? 'Close Form' : 'Record New Expense'"
        />
        
        <x-button 
            secondary 
            icon="document-arrow-down"
            wire:click="exportMonthlyReport"
            label="Export CSV"
        />
    </div>

    <!-- Expense Form (Inline - Shows below button) -->
    @if($showForm || $editingId)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6 transition-all duration-300" id="expense-form">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <x-icon :name="$editingId ? 'pencil-square' : 'plus-circle'" class="w-6 h-6 text-blue-600" />
                {{ $editingId ? '✏️ Edit Expense' : '➕ Record New Expense' }}
            </h2>
            
            @if($editingId)
            <x-button flat icon="x-mark" wire:click="resetForm" label="Cancel" />
            @else
            <x-button flat icon="x-mark" wire:click="$set('showForm', false)" title="Close" />
            @endif
        </div>

        <form wire:submit.prevent="saveExpense" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Expense Number & Date -->
                <div>
                    <x-input
                        label="Expense Number"
                        wire:model="expense_number"
                        readonly
                        class="bg-gray-50"
                    />
                </div>
                <div>
                    <x-datetime-picker
                        label="Expense Date *"
                        wire:model="expense_date"
                        without-time
                        required
                    />
                </div>
            </div>

            <!-- Amount & Category -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input
                        label="Amount (Ksh) *"
                        wire:model="amount"
                        type="number"
                        step="0.01"
                        min="0.01"
                        required
                        prefix="Ksh"
                        placeholder="0.00"
                    />
                </div>
                <div>
                    <x-select
                        label="Category *"
                        wire:model="expense_category_id"
                        :options="$categories"
                        option-label="name"
                        option-value="id"
                        placeholder="Select category"
                        required
                    />
                </div>
            </div>

            <!-- Description -->
            <div>
                <x-textarea
                    label="Description *"
                    wire:model="description"
                    placeholder="e.g., Purchase of communion wine, Sunday service refreshments..."
                    required
                    rows="3"
                />
            </div>

            <!-- Payment Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <x-input
                        label="Paid To *"
                        wire:model="paid_to"
                        placeholder="e.g., Supermarket, John Doe"
                        required
                    />
                </div>
                <div>
                    <x-select
                        label="Payment Method *"
                        wire:model="payment_method"
                        :options="collect($paymentMethods)->map(fn($label, $value) => ['label' => $label, 'value' => $value])->values()"
                        option-label="label"
                        option-value="value"
                        placeholder="Select method"
                        required
                    />
                </div>
                <div>
                    <x-input
                        label="Reference Number"
                        wire:model="reference_number"
                        placeholder="MPESA code, invoice #"
                    />
                </div>
            </div>

            <!-- Receipt & Notes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start space-x-3 p-4 bg-gray-50 rounded-lg">
                    <x-checkbox
                        label="Receipt Available"
                        wire:model="receipt_available"
                    />
                    <div>
                        <p class="text-sm font-medium text-gray-900">Receipt Available</p>
                        <p class="text-xs text-gray-500">Check if you have the physical receipt</p>
                    </div>
                </div>
                <div>
                    <x-textarea
                        label="Notes (Optional)"
                        wire:model="notes"
                        placeholder="Additional notes..."
                        rows="3"
                    />
                </div>
            </div>

            <!-- Total Preview -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-blue-700 flex items-center gap-2">
                        <x-icon name="information-circle" class="w-4 h-4" />
                        Expense Summary
                    </span>
                    <span class="text-xl font-bold text-blue-900">
                        Ksh{{ number_format($amount, 2) }}
                    </span>
                </div>
                <div class="text-xs text-blue-600 mt-2 grid grid-cols-2 gap-2">
                    <div>Category: {{ $categories->find($expense_category_id)->name ?? 'Not selected' }}</div>
                    <div>Method: {{ $paymentMethods[$payment_method] ?? 'Not selected' }}</div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <x-button 
                    primary 
                    :icon="$editingId ? 'check-circle' : 'plus-circle'"
                    type="submit"
                    :label="$editingId ? 'Update Expense' : 'Save Expense'"
                    spinner
                    class="w-full md:w-auto"
                />
            </div>
        </form>
    </div>
    @endif

    <!-- Workflow Sections -->
    <!-- Pending Expenses -->
    @if($pendingCount > 0 && !$status)
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-3 h-3 rounded-full bg-yellow-500 mr-3"></div>
                <h3 class="text-lg font-bold text-gray-900">Step 1: Review Pending Expenses</h3>
            </div>
            <x-badge yellow rounded>
                {{ $pendingCount }} pending
            </x-badge>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($expenses->where('status', 'pending')->take(6) as $expense)
            <x-card class="border border-yellow-200 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <span class="font-medium text-gray-900">
                        {{ $expense->expense_date->format('D, M j') }}
                    </span>
                    <x-badge yellow rounded>
                        Pending
                    </x-badge>
                </div>
                
                <div class="space-y-2">
                    <div class="text-sm text-gray-600 line-clamp-2">{{ $expense->description }}</div>
                    <div class="text-xs text-gray-500">Paid to: {{ $expense->paid_to }}</div>
                    
                    <div class="flex items-center justify-between pt-2 border-t border-yellow-100">
                        <span class="text-sm font-medium text-gray-700">Amount:</span>
                        <span class="font-bold text-gray-900">
                            Ksh{{ number_format($expense->amount, 2) }}
                        </span>
                    </div>
                </div>
                
                <div class="mt-4 flex items-center justify-end gap-2">
                    <x-button 
                        icon="check-circle"
                        positive xs
                        wire:click="quickApprove({{ $expense->id }})"
                        title="Approve"
                    />
                    <x-button 
                        icon="x-circle"
                        negative xs
                        wire:click="startRejection({{ $expense->id }})"
                        title="Reject"
                    />
                    <x-button 
                        icon="eye"
                        flat xs
                        wire:click="viewDetails({{ $expense->id }})"
                        title="View"
                    />
                </div>
            </x-card>
            @endforeach
        </div>
        
        @if($pendingCount > 6)
        <div class="mt-4 text-center">
            <x-button 
                flat 
                icon="arrow-right"
                wire:click="$set('status', 'pending')"
                label="View all {{ $pendingCount }} pending"
                class="text-yellow-600 hover:text-yellow-800"
            />
        </div>
        @endif
    </div>
    @endif

    <!-- Approved Expenses (Ready for Payment) -->
    @php
        $approvedExpenses = $expenses->where('status', 'approved');
        $approvedCount = $approvedExpenses->count();
    @endphp
    @if($approvedCount > 0 && !$status)
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-3 h-3 rounded-full bg-blue-500 mr-3"></div>
                <h3 class="text-lg font-bold text-gray-900">Step 2: Process Payments</h3>
            </div>
            <x-badge blue rounded>
                {{ $approvedCount }} ready
            </x-badge>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($approvedExpenses->take(6) as $expense)
            <x-card class="border border-blue-200 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <span class="font-medium text-gray-900">
                        {{ $expense->expense_date->format('D, M j') }}
                    </span>
                    <x-badge blue rounded>
                        Approved
                    </x-badge>
                </div>
                
                <div class="space-y-2">
                    <div class="text-sm text-gray-600 line-clamp-2">{{ $expense->description }}</div>
                    <div class="text-xs text-gray-500">Method: {{ ucfirst($expense->payment_method) }}</div>
                    
                    <div class="flex items-center justify-between pt-2 border-t border-blue-100">
                        <span class="text-sm font-medium text-gray-700">To Pay:</span>
                        <span class="font-bold text-gray-900">
                            Ksh{{ number_format($expense->amount, 2) }}
                        </span>
                    </div>
                </div>
                
                <div class="mt-4">
                    <x-button 
                        icon="currency-dollar"
                        positive xs full
                        wire:click="startPayment({{ $expense->id }})"
                        label="Mark as Paid"
                    />
                </div>
            </x-card>
            @endforeach
        </div>
        
        @if($approvedCount > 6)
        <div class="mt-4 text-center">
            <x-button 
                flat 
                icon="arrow-right"
                wire:click="$set('status', 'approved')"
                label="View all {{ $approvedCount }} approved"
                class="text-blue-600 hover:text-blue-800"
            />
        </div>
        @endif
    </div>
    @endif

    <!-- Search and Filters -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="flex items-center space-x-3">
            <!-- Record Count -->
            <div class="text-sm text-gray-600 bg-gray-50 px-3 py-1.5 rounded-lg">
                {{ $expenses->total() }} total expenses
            </div>
        </div>
        
        <!-- Search Box -->
        <div class="w-full md:w-64">
            <x-input
                wire:model.live.debounce.300ms="search"
                icon="magnifying-glass"
                placeholder="Search expenses..."
            />
        </div>
    </div>

    <!-- Simplified Filters -->
    <x-card class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Status Filter -->
            <div>
                <x-select
                    wire:model.live="status"
                    label="Status"
                    :options="[
                        ['value' => '', 'label' => 'All Status'],
                        ['value' => 'pending', 'label' => 'Pending'],
                        ['value' => 'approved', 'label' => 'Approved'],
                        ['value' => 'paid', 'label' => 'Paid'],
                        ['value' => 'rejected', 'label' => 'Rejected'],
                        ['value' => 'cancelled', 'label' => 'Cancelled'],
                    ]"
                    option-value="value"
                    option-label="label"
                />
            </div>

            <!-- Category Filter -->
            <div>
                <x-select
                    wire:model.live="category_id"
                    label="Category"
                    :options="$categories->map(fn($cat) => ['value' => $cat->id, 'label' => $cat->name])->prepend(['value' => '', 'label' => 'All Categories'])"
                    option-value="value"
                    option-label="label"
                />
            </div>

            <!-- Month Filter -->
            <div>
                <x-select
                    wire:model.live="month"
                    label="Month"
                    :options="$months"
                    option-value="value"
                    option-label="label"
                />
            </div>

            <!-- Items Per Page -->
            <div>
                <x-native-select
                    wire:model.live="perPage"
                    label="Show"
                >
                    <option value="10">10 per page</option>
                    <option value="15">15 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                </x-native-select>
            </div>
        </div>
        
        <!-- Clear Filters -->
        @if($search || $status || $category_id || $month)
        <div class="mt-4 pt-4 border-t border-gray-100">
            <x-button 
                flat 
                icon="x-mark"
                wire:click="clearFilters"
                label="Clear All Filters"
            />
        </div>
        @endif
    </x-card>

    <!-- Loading Indicator -->
    <div wire:loading wire:target="search, status, category_id, month, perPage" class="mb-4">
        <div class="flex items-center justify-center p-8">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600"></div>
            <span class="ml-4 text-gray-600">Loading expenses...</span>
        </div>
    </div>

    <!-- Expenses Table -->
    <x-card class="overflow-hidden" wire:loading.remove wire:target="search, status, category_id, month, perPage">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Details</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
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
                                <div class="text-sm font-medium text-gray-900">
                                    {{ Str::limit($expense->description, 50) }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    <x-icon name="user" class="w-3 h-3 inline mr-1" />
                                    {{ $expense->paid_to }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    <x-icon name="tag" class="w-3 h-3 inline mr-1" />
                                    {{ $expense->category->name ?? 'N/A' }}
                                </div>
                            </div>
                        </td>

                        <!-- Amount -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-lg font-bold text-gray-900">
                                Ksh{{ number_format($expense->amount, 2) }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ ucfirst($expense->payment_method) }}
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pending' => 'yellow',
                                    'approved' => 'blue',
                                    'paid' => 'green',
                                    'rejected' => 'red',
                                    'cancelled' => 'gray',
                                ];
                            @endphp
                            <x-badge :color="$statusColors[$expense->status] ?? 'gray'" rounded>
                                {{ ucfirst($expense->status) }}
                            </x-badge>
                            
                            @if($expense->approved_by && !$expense->approved_by_2 && $expense->amount > 10000)
                            <div class="mt-1 text-xs text-yellow-600 flex items-center">
                                <x-icon name="clock" class="w-3 h-3 mr-1" />
                                Waiting committee
                            </div>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-1">
                                <!-- View -->
                                <x-button
                                    icon="eye"
                                    flat xs rounded
                                    wire:click="viewDetails({{ $expense->id }})"
                                    title="View Details"
                                />
                                
                                <!-- Status-based Actions -->
                                @if($expense->status === 'pending')
                                    <!-- Approve -->
                                    <x-button
                                        icon="check-circle"
                                        positive xs rounded
                                        wire:click="quickApprove({{ $expense->id }})"
                                        title="Approve"
                                    />
                                    <!-- Reject -->
                                    <x-button
                                        icon="x-circle"
                                        negative xs rounded
                                        wire:click="startRejection({{ $expense->id }})"
                                        title="Reject"
                                    />
                                    <!-- Edit -->
                                    <x-button
                                        icon="pencil-square"
                                        secondary xs rounded
                                        wire:click="editExpense({{ $expense->id }})"
                                        title="Edit"
                                    />
                                @elseif($expense->status === 'approved')
                                    <!-- Mark as Paid -->
                                    <x-button
                                        icon="currency-dollar"
                                        positive xs rounded
                                        wire:click="startPayment({{ $expense->id }})"
                                        title="Mark as Paid"
                                    />
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <x-icon name="document-text" class="w-12 h-12 mx-auto mb-3" />
                                <p class="text-lg font-medium text-gray-500">No expenses found</p>
                                <x-button 
                                    primary 
                                    icon="plus-circle"
                                    wire:click="$set('showForm', true)"
                                    label="Record First Expense"
                                    class="mt-3"
                                />
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($expenses->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $expenses->links() }}
        </div>
        @endif
    </x-card>

    <!-- Monthly Breakdown -->
    @if($monthlyTotals->count() > 0)
    <x-card class="mt-8">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <x-icon name="chart-bar" class="w-5 h-5" />
            Monthly Expense Trends
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($monthlyTotals as $monthData)
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow transition">
                <div class="text-sm font-medium text-gray-500 truncate">
                    {{ $monthData['month'] }}
                </div>
                <div class="text-xl font-bold text-gray-900 mt-1 truncate">
                    Ksh{{ number_format($monthData['total'], 2) }}
                </div>
                <div class="text-xs text-gray-400 mt-1">
                    @php
                        $expensesCount = App\Models\Expense::forCurrentTenant()
                            ->whereYear('expense_date', Carbon\Carbon::parse($monthData['month'])->year)
                            ->whereMonth('expense_date', Carbon\Carbon::parse($monthData['month'])->month)
                            ->whereIn('status', ['approved', 'paid'])
                            ->count();
                    @endphp
                    {{ $expensesCount }} {{ Str::plural('expense', $expensesCount) }}
                </div>
            </div>
            @endforeach
        </div>
    </x-card>
    @endif

    <!-- Approval Modal (for amounts over 10,000) -->
    <x-modal wire:model.defer="approvingId">
        <x-card title="Dual Approval Required">
            <div class="space-y-4">
                <p class="text-sm text-gray-600">
                    This expense exceeds Ksh 10,000 and requires dual approval.
                    Please select your role:
                </p>
                
                <div class="space-y-2">
                    <x-button
                        full
                        wire:click="approveAsFirst"
                        label="I am the Treasurer (First Approver)"
                        icon="user-circle"
                        positive
                    />
                    <x-button
                        full
                        wire:click="approveAsSecond"
                        label="I am a Committee Member (Second Approver)"
                        icon="user-group"
                        secondary
                    />
                </div>
                
                <div class="pt-4 border-t border-gray-200">
                    <x-button
                        full
                        flat
                        label="Cancel"
                        wire:click="$set('approvingId', null)"
                    />
                </div>
            </div>
        </x-card>
    </x-modal>

    <!-- Rejection Modal -->
    <x-modal wire:model.defer="rejectingId">
        <x-card title="Reject Expense">
            <form wire:submit.prevent="rejectExpense">
                <div class="space-y-4">
                    <p class="text-sm text-gray-600">Please provide a reason for rejecting this expense:</p>
                    
                    <x-textarea
                        label="Rejection Reason"
                        wire:model="rejection_reason"
                        placeholder="Example: Expense not supported by receipt, amount exceeds budget..."
                        required
                        rows="3"
                    />
                </div>

                <x-slot name="footer">
                    <div class="flex justify-end gap-3">
                        <x-button flat label="Cancel" wire:click="$set('rejectingId', null)" />
                        <x-button negative type="submit" label="Reject Expense" spinner />
                    </div>
                </x-slot>
            </form>
        </x-card>
    </x-modal>

    <!-- Payment Modal -->
    <x-modal wire:model.defer="payingId">
        <x-card title="Mark as Paid">
            <form wire:submit.prevent="markAsPaid">
                <div class="space-y-4">
                    <p class="text-sm text-gray-600">
                        Confirm that this expense has been paid.
                    </p>
                    
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <div class="text-sm text-gray-700">
                            <div class="font-medium">Expense Details:</div>
                            <div class="mt-1 text-gray-600">
                                @if($payingId)
                                    @php $expense = App\Models\Expense::find($payingId); @endphp
                                    @if($expense)
                                        {{ $expense->description }}<br>
                                        Amount: Ksh{{ number_format($expense->amount, 2) }}<br>
                                        Paid to: {{ $expense->paid_to }}
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <x-slot name="footer">
                    <div class="flex justify-end gap-3">
                        <x-button flat label="Cancel" wire:click="$set('payingId', null)" />
                        <x-button positive type="submit" label="Mark as Paid" spinner />
                    </div>
                </x-slot>
            </form>
        </x-card>
    </x-modal>
</div>






