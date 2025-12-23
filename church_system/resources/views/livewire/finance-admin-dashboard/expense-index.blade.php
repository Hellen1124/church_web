<div class="p-6 space-y-6">

    {{-- Key Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card class="bg-yellow-50">
            <x-slot name="title">Pending Expenses</x-slot>
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-lg font-semibold">{{ number_format($pendingTotal, 2) }}</div>
            </div>
            <div class="text-sm text-gray-500">{{ $pendingCount }} pending</div>
        </x-card>

        <x-card class="bg-blue-50">
            <x-slot name="title">Approved Unpaid</x-slot>
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m1 4a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-lg font-semibold">{{ number_format($approvedUnpaidTotal, 2) }}</div>
            </div>
        </x-card>

        <x-card class="bg-green-50">
            <x-slot name="title">Current Month Total</x-slot>
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.5 0-2 .5-2 2s.5 2 2 2s2 .5 2 2s-.5 2-2 2m0-8v12" />
                </svg>
                <div class="text-lg font-semibold">{{ number_format($currentMonthTotal, 2) }}</div>
            </div>
        </x-card>
    </div>

    {{-- Filters --}}
    <div class="flex flex-col md:flex-row md:items-end gap-4">
        <x-input
            placeholder="Search by description or paid to..."
            wire:model.defer="search"
            icon="magnifying-glass"
            class="flex-1"
        />

        <x-select
            placeholder="Status"
            :options="[
                ['label' => 'Pending', 'value' => 'pending'],
                ['label' => 'Approved', 'value' => 'approved'],
                ['label' => 'Paid', 'value' => 'paid'],
                ['label' => 'Rejected', 'value' => 'rejected']
            ]"
            wire:model.defer="status"
        />

        <x-select
            placeholder="Month"
            :options="$months->map(fn($m) => ['label' => $m['label'], 'value' => $m['value']])->toArray()"
            wire:model.defer="month"
        />

        <x-button label="Filter" icon="funnel" wire:click="$refresh" primary />
    </div>

    {{-- Actions --}}
    <div class="flex justify-between items-center mt-4">
        <x-button label="New Expense" icon="plus-circle" primary wire:click="$set('showForm', true)" />
        <x-button label="Export Monthly Report" icon="document-arrow-down" wire:click="exportMonthlyReport" />
    </div>

    {{-- Expenses Table --}}
    <div class="overflow-x-auto mt-4">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Paid To</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Payment Method</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($expenses as $expense)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $expense->expense_date->format('M d, Y') }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $expense->category->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $expense->description }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ number_format($expense->amount, 2) }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $expense->paid_to }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ ucfirst(str_replace('_', ' ', $expense->payment_method)) }}</td>
                        <td class="px-4 py-2 text-sm">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                @if($expense->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($expense->status === 'approved') bg-blue-100 text-blue-800
                                @elseif($expense->status === 'paid') bg-green-100 text-green-800
                                @elseif($expense->status === 'rejected') bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($expense->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-sm flex gap-1">
                            <x-button icon="eye" wire:click="viewDetails({{ $expense->id }})" flat squared sm />
                            @if($expense->status === 'pending')
                                <x-button icon="pencil" wire:click="editExpense({{ $expense->id }})" flat squared sm />
                                <x-button icon="trash" wire:click="deleteExpense({{ $expense->id }})" negative flat squared sm />
                                <x-button icon="check" wire:click="quickApprove({{ $expense->id }})" info flat squared sm />
                                <x-button icon="x-mark" wire:click="quickReject({{ $expense->id }})" warning flat squared sm />
                            @elseif($expense->status === 'approved')
                                <x-button icon="currency-dollar" wire:click="startPayment({{ $expense->id }})" primary flat squared sm />
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500">No expenses found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $expenses->links() }}
    </div>

    {{-- Expense Form Modal --}}
    <x-dialog
        blur
        wire:model.defer="showForm"
        max-width="md"
        title="{{ $editingId ? 'Edit Expense' : 'New Expense' }}"
    >
        <div class="space-y-4">
            <x-input label="Date" type="date" wire:model.defer="expense_date" required />
            <x-input label="Amount" type="number" step="0.01" wire:model.defer="amount" required />
            <x-select
                label="Category"
                :options="$categories->map(fn($c) => ['label' => $c->name, 'value' => $c->id])->toArray()"
                wire:model.defer="expense_category_id"
                required
            />
            <x-input label="Description" wire:model.defer="description" required />
            <x-input label="Paid To" wire:model.defer="paid_to" required />
            <x-select
                label="Payment Method"
                :options="collect($paymentMethods)->map(fn($label, $key) => ['label' => $label, 'value' => $key])->toArray()"
                wire:model.defer="payment_method"
                required
            />
            <x-checkbox label="Receipt Available" wire:model.defer="receipt_available" />
        </div>

        <x-slot name="footer">
            <x-button label="Cancel" flat wire:click="$set('showForm', false)" />
            <x-button label="{{ $editingId ? 'Update' : 'Save' }}" primary wire:click="saveExpense" />
        </x-slot>
    </x-dialog>

    {{-- Payment Modal --}}
    <x-dialog
        blur
        wire:model.defer="payingId"
        max-width="sm"
        title="Record Payment"
    >
        <x-input label="Payment Date" type="date" wire:model.defer="payment_date" required />
        <x-slot name="footer">
            <x-button label="Cancel" flat wire:click="$set('payingId', null)" />
            <x-button label="Mark as Paid" primary wire:click="markAsPaid" />
        </x-slot>
    </x-dialog>

</div>








