<?php

namespace App\Livewire\FinanceAdminDashboard;


use App\Models\Expense;
use App\Models\ExpenseCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class ExpenseIndex extends Component
{
    use WithPagination;

    // Simple filters - treasurer focused
    public $search = '';
    public $status = 'pending';  // Default shows what needs attention
    public $month = '';
    public $perPage = 15;

    // Form properties
    public $showForm = false;
    public $editingId = null;
    public $payingId = null;

    // Essential expense fields only
    public $expense_date;
    public $amount = 0;
    public $expense_category_id;
    public $description = '';
    public $paid_to = '';
    public $payment_method = 'cash';
    public $receipt_available = false;

    // Payment field
    public $payment_date;

    // Key statistics for treasurer
    public $pendingTotal = 0;
    public $approvedUnpaidTotal = 0;
    public $currentMonthTotal = 0;
    public $pendingCount = 0;

    // Church-specific payment methods
    protected $paymentMethods = [
        'cash' => 'Cash',
        'mpesa' => 'M-Pesa',
        'bank_transfer' => 'Bank Transfer',
        'cheque' => 'Cheque',
    ];

    protected $rules = [
        'expense_date' => 'required|date',
        'amount' => 'required|numeric|min:0.01',
        'expense_category_id' => 'required|exists:expense_categories,id',
        'description' => 'required|string|max:255',
        'paid_to' => 'required|string|max:255',
        'payment_method' => 'required|string',
        'receipt_available' => 'boolean',
    ];

    public function mount()
    {
        $this->expense_date = now()->format('Y-m-d');
        $this->payment_date = now()->format('Y-m-d');
        $this->month = now()->format('Y-m');
        $this->loadStatistics();
    }

    /**
     * Load key statistics for treasurer dashboard
     */
    public function loadStatistics()
    {
        // Count and total of pending expenses
        $pending = Expense::forCurrentTenant()
            ->where('status', 'pending')
            ->selectRaw('COUNT(*) as count, SUM(amount) as total')
            ->first();
        
        $this->pendingCount = $pending->count ?? 0;
        $this->pendingTotal = $pending->total ?? 0;

        // Approved but not yet paid
        $approved = Expense::forCurrentTenant()
            ->where('status', 'approved')
            ->sum('amount');
        
        $this->approvedUnpaidTotal = $approved ?? 0;

        // Current month total (approved + paid)
        $currentMonth = Expense::forCurrentTenant()
            ->whereIn('status', ['approved', 'paid'])
            ->whereMonth('expense_date', now()->month)
            ->whereYear('expense_date', now()->year)
            ->sum('amount');
        
        $this->currentMonthTotal = $currentMonth ?? 0;
    }

    /**
     * Reset form for new expense
     */
    public function resetForm()
    {
        $this->reset([
            'editingId', 'payingId', 'amount', 'expense_category_id',
            'description', 'paid_to', 'payment_method', 'receipt_available'
        ]);
        
        $this->expense_date = now()->format('Y-m-d');
        $this->amount = 0;
    }

    /**
     * Save or update expense
     */
    public function saveExpense()
    {
        $this->validate();

        $data = [
            'expense_date' => $this->expense_date,
            'amount' => $this->amount,
            'expense_category_id' => $this->expense_category_id,
            'description' => $this->description,
            'paid_to' => $this->paid_to,
            'payment_method' => $this->payment_method,
            'receipt_available' => $this->receipt_available,
            'status' => 'pending',
        ];

        if ($this->editingId) {
            $expense = Expense::forCurrentTenant()->findOrFail($this->editingId);
            
            // Can only edit pending expenses
            if ($expense->status !== 'pending') {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Can only edit pending expenses.'
                ]);
                return;
            }
            
            $expense->update($data);
            $message = 'Expense updated!';
        } else {
            Expense::create($data);
            $message = 'Expense recorded!';
        }

        $this->resetForm();
        $this->showForm = false;
        $this->loadStatistics();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $message
        ]);
    }

    /**
     * Quick approve - single click
     */
    public function quickApprove($id)
    {
        $expense = Expense::forCurrentTenant()->findOrFail($id);
        
        if ($expense->status !== 'pending') {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Only pending expenses can be approved.'
            ]);
            return;
        }

        $expense->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $this->loadStatistics();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Expense approved!'
        ]);
    }

    /**
     * Quick reject - single click
     */
    public function quickReject($id)
    {
        $expense = Expense::forCurrentTenant()->findOrFail($id);
        
        if ($expense->status !== 'pending') {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Only pending expenses can be rejected.'
            ]);
            return;
        }

        $expense->update([
            'status' => 'rejected',
            'notes' => ($expense->notes ?? '') . "\n[REJECTED by Treasurer on " . now()->format('Y-m-d') . "]"
        ]);

        $this->loadStatistics();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Expense rejected!'
        ]);
    }

    /**
     * Start payment process
     */
    public function startPayment($id)
    {
        $expense = Expense::forCurrentTenant()->findOrFail($id);
        
        if ($expense->status !== 'approved') {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Only approved expenses can be paid.'
            ]);
            return;
        }
        
        $this->payingId = $id;
        $this->payment_date = now()->format('Y-m-d');
    }

    /**
     * Mark expense as paid
     */
    public function markAsPaid()
    {
        $this->validate([
            'payment_date' => 'required|date',
        ]);

        $expense = Expense::forCurrentTenant()->findOrFail($this->payingId);
        
        $expense->update([
            'status' => 'paid',
            'payment_date' => $this->payment_date,
        ]);
        
        $this->payingId = null;
        $this->payment_date = now()->format('Y-m-d');
        $this->loadStatistics();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Payment recorded!'
        ]);
    }

    /**
     * View expense details (modal)
     */
    public function viewDetails($id)
    {
        $expense = Expense::forCurrentTenant()->with('category')->findOrFail($id);
        $this->dispatch('show-expense-details', expense: $expense);
    }

    /**
     * Edit expense
     */
    public function editExpense($id)
    {
        $expense = Expense::forCurrentTenant()->findOrFail($id);
        
        if ($expense->status !== 'pending') {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Can only edit pending expenses.'
            ]);
            return;
        }

        $this->editingId = $id;
        $this->expense_date = $expense->expense_date->format('Y-m-d');
        $this->amount = $expense->amount;
        $this->expense_category_id = $expense->expense_category_id;
        $this->description = $expense->description;
        $this->paid_to = $expense->paid_to;
        $this->payment_method = $expense->payment_method;
        $this->receipt_available = $expense->receipt_available;
        $this->showForm = true;
    }

    /**
     * Delete pending expense
     */
    public function deleteExpense($id)
    {
        $expense = Expense::forCurrentTenant()->findOrFail($id);
        
        if ($expense->status !== 'pending') {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Can only delete pending expenses.'
            ]);
            return;
        }

        $expense->delete();
        $this->loadStatistics();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Expense deleted!'
        ]);
    }

    /**
     * Export monthly report
     */
    public function exportMonthlyReport()
    {
        [$year, $month] = explode('-', $this->month);
        
        $expenses = Expense::forCurrentTenant()
            ->with('category')
            ->whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month)
            ->get();
        
        $monthName = Carbon::createFromDate($year, $month, 1)->format('F Y');
        
        return response()->streamDownload(function () use ($expenses, $monthName) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ["Church Expenses - {$monthName}"]);
            fputcsv($file, ['']); // Empty row
            fputcsv($file, ['Date', 'Category', 'Description', 'Amount', 'Paid To', 'Payment Method', 'Status', 'Receipt']);
            
            foreach ($expenses as $expense) {
                fputcsv($file, [
                    $expense->expense_date->format('m/d/Y'),
                    $expense->category->name ?? 'N/A',
                    $expense->description,
                    number_format($expense->amount, 2),
                    $expense->paid_to,
                    ucfirst(str_replace('_', ' ', $expense->payment_method)),
                    ucfirst($expense->status),
                    $expense->receipt_available ? 'Yes' : 'No'
                ]);
            }
            
            fputcsv($file, ['']); // Empty row
            
            // Add totals
            $pending = $expenses->where('status', 'pending')->sum('amount');
            $approved = $expenses->where('status', 'approved')->sum('amount');
            $paid = $expenses->where('status', 'paid')->sum('amount');
            
            fputcsv($file, ['PENDING TOTAL:', '', '', number_format($pending, 2)]);
            fputcsv($file, ['APPROVED (unpaid):', '', '', number_format($approved, 2)]);
            fputcsv($file, ['PAID TOTAL:', '', '', number_format($paid, 2)]);
            fputcsv($file, ['MONTH TOTAL:', '', '', number_format($expenses->sum('amount'), 2)]);
            
            fclose($file);
        }, "church-expenses-{$monthName}.csv");
    }

    /**
     * Get monthly totals for chart
     */
    public function getMonthlyTotalsProperty()
    {
        return Expense::forCurrentTenant()
            ->selectRaw('YEAR(expense_date) as year, MONTH(expense_date) as month, SUM(amount) as total')
            ->whereIn('status', ['approved', 'paid'])
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get()
            ->map(function ($item) {
                return [
                    'month' => Carbon::createFromDate($item->year, $item->month, 1)->format('M Y'),
                    'total' => $item->total
                ];
            });
    }

    /**
     * Get category totals for current month
     */
    public function getCategoryTotalsProperty()
    {
        return Expense::forCurrentTenant()
            ->selectRaw('expense_category_id, SUM(amount) as total')
            ->with('category')
            ->whereIn('status', ['approved', 'paid'])
            ->whereMonth('expense_date', now()->month)
            ->whereYear('expense_date', now()->year)
            ->groupBy('expense_category_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Get filtered expenses
     */
    public function getExpensesProperty()
    {
        $query = Expense::forCurrentTenant()
            ->with('category')
            ->orderBy('expense_date', 'desc');

        // Status filter
        if ($this->status) {
            $query->where('status', $this->status);
        } else {
            // Default: show all except rejected/cancelled
            $query->whereNotIn('status', ['rejected', 'cancelled']);
        }

        // Month filter
        if ($this->month) {
            [$year, $month] = explode('-', $this->month);
            $query->whereYear('expense_date', $year)
                  ->whereMonth('expense_date', $month);
        }

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                  ->orWhere('paid_to', 'like', '%' . $this->search . '%');
            });
        }

        return $query->paginate($this->perPage);
    }

    /**
     * Get categories dropdown
     */
    public function getCategoriesProperty()
    {
        return ExpenseCategory::forCurrentTenant()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    /**
     * Get months for filter
     */
    public function getMonthsProperty()
    {
        $months = collect();
        
        // Last 6 months
        for ($i = 0; $i < 6; $i++) {
            $date = now()->subMonths($i);
            $months->push([
                'value' => $date->format('Y-m'),
                'label' => $date->format('F Y')
            ]);
        }
        
        return $months;
    }

    public function render()
    {
        return view('livewire.finance-admin-dashboard.expense-index', [
            'expenses' => $this->expenses,
            'categories' => $this->categories,
            'months' => $this->months,
            'paymentMethods' => $this->paymentMethods,
            'monthlyTotals' => $this->monthlyTotals,
            'categoryTotals' => $this->categoryTotals,
        ]);
    }
}
