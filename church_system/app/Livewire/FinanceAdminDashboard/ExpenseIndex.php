<?php


namespace App\Livewire\FinanceAdminDashboard;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExpenseIndex extends Component
{
    use WithPagination;

    // ==================== FILTERS ====================
    public $search = '';
    public $status = '';
    public $month = '';
    public $category_id = '';
    public $perPage = 15;
    
    // ==================== FORM PROPERTIES ====================
    public $showForm = false;
    public $editingId = null;
    public $approvingId = null;
    public $payingId = null;
    public $rejectingId = null;
    
    // ==================== EXPENSE FIELDS ====================
    public $expense_date;
    public $expense_number;
    public $amount = 0;
    public $expense_category_id;
    public $description = '';
    public $paid_to = '';
    public $payment_method = 'cash';
    public $reference_number = '';
    public $receipt_available = false;
    public $notes = '';
    
    // ==================== REJECTION FIELD ====================
    public $rejection_reason = '';
    
    // ==================== STATISTICS ====================
    public $pendingTotal = 0;
    public $pendingCount = 0;
    public $approvedUnpaidTotal = 0;
    public $approvedUnpaidCount = 0;
    public $currentMonthTotal = 0;
    public $currentMonthCount = 0;
    public $lastMonthTotal = 0;
    
    // ==================== PAYMENT METHODS ====================
    protected $paymentMethods = [
        'cash' => 'Cash',
        'mpesa' => 'M-Pesa',
        'bank_transfer' => 'Bank Transfer',
        'cheque' => 'Cheque',
        'other' => 'Other',
    ];

    // ==================== VALIDATION RULES ====================
    protected $rules = [
        'expense_date' => 'required|date',
        'amount' => 'required|numeric|min:0.01',
        'expense_category_id' => 'required|exists:expense_categories,id',
        'description' => 'required|string|max:500',
        'paid_to' => 'required|string|max:255',
        'payment_method' => 'required|string',
        'reference_number' => 'nullable|string|max:100',
        'receipt_available' => 'boolean',
        'notes' => 'nullable|string|max:1000',
    ];

    // ==================== INITIALIZATION ====================
    public function mount()
    {
        $this->expense_date = now()->format('Y-m-d');
        $this->month = now()->format('Y-m');
        $this->generateExpenseNumber();
        $this->loadTreasurerStatistics();
    }

    // ==================== TREASURER STATISTICS ====================
    public function loadTreasurerStatistics()
    {
        // Pending expenses - using YOUR scope: ->pending()
        $pending = Expense::forCurrentTenant()
            ->pending()
            ->selectRaw('COUNT(*) as count, SUM(amount) as total')
            ->first();
        
        $this->pendingCount = $pending->count ?? 0;
        $this->pendingTotal = $pending->total ?? 0;

        // Approved but unpaid (ready for payment)
        $approvedUnpaid = Expense::forCurrentTenant()
            ->approved()
            ->selectRaw('COUNT(*) as count, SUM(amount) as total')
            ->first();
        
        $this->approvedUnpaidCount = $approvedUnpaid->count ?? 0;
        $this->approvedUnpaidTotal = $approvedUnpaid->total ?? 0;

        // Current month approved/paid using YOUR scope: ->thisMonth()
        $currentMonth = Expense::forCurrentTenant()
            ->whereIn('status', ['approved', 'paid'])
            ->thisMonth()
            ->selectRaw('COUNT(*) as count, SUM(amount) as total')
            ->first();
        
        $this->currentMonthCount = $currentMonth->count ?? 0;
        $this->currentMonthTotal = $currentMonth->total ?? 0;

        // Last month total using YOUR scope: ->lastMonth()
        $lastMonth = Expense::forCurrentTenant()
            ->whereIn('status', ['approved', 'paid'])
            ->lastMonth()
            ->sum('amount');
        
        $this->lastMonthTotal = $lastMonth ?? 0;
    }

    // ==================== EXPENSE NUMBER GENERATION ====================
    private function generateExpenseNumber()
    {
        $prefix = 'CHR-' . date('Ym') . '-';
        $lastExpense = Expense::forCurrentTenant()
            ->where('expense_number', 'like', $prefix . '%')
            ->orderBy('expense_number', 'desc')
            ->first();
        
        if ($lastExpense) {
            $lastNumber = intval(str_replace($prefix, '', $lastExpense->expense_number));
            $this->expense_number = $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $this->expense_number = $prefix . '0001';
        }
    }

    // ==================== TREASURER APPROVAL METHODS ====================
    
    /**
     * Quick single-click approval (for amounts under 10,000)
     */
    /**
 * Approve expense (single approval flow)
 */
public function quickApprove($id)
{
    $expense = Expense::forCurrentTenant()->findOrFail($id);
    
    if ($expense->status !== 'pending') {
        $this->dispatch('notify', [
            'type' => 'error',
            'message' => 'This expense is no longer pending approval.'
        ]);
        return;
    }
    
    // Get the authenticated user's ID
    $userId = Auth::user()->id; // Use this instead of Auth::id()
    
    // If Auth::user()->id still returns phone, check your User model
    // Make sure your users table has a proper integer ID column
    $expense->update([
        'status' => 'approved',
        'approved_by' => $userId, // This should be integer user ID
        'approved_at' => now(),
        'updated_by' => $userId,
    ]);
    
    $this->loadTreasurerStatistics();
    
    $this->dispatch('notify', [
        'type' => 'success',
        'message' => 'Expense approved successfully!'
    ]);
}
    
    /**
     * First approval by treasurer (for dual approval flow - amounts over 10,000)
     */
    public function approveAsFirst()
    {
        $expense = Expense::forCurrentTenant()->findOrFail($this->approvingId);
        
        $expense->update([
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        
        $this->approvingId = null;
        $this->loadTreasurerStatistics();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Treasurer approved. Waiting for committee member approval.'
        ]);
    }
    
    /**
     * Second approval by committee member
     */
    public function approveAsSecond()
    {
        $expense = Expense::forCurrentTenant()->findOrFail($this->approvingId);
        
        $expense->update([
            'approved_by_2' => Auth::id(),
            'status' => 'approved',
        ]);
        
        $this->approvingId = null;
        $this->loadTreasurerStatistics();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Expense fully approved and ready for payment.'
        ]);
    }
    
    /**
     * Start rejection process
     */
    public function startRejection($id)
    {
        $this->rejectingId = $id;
        $this->rejection_reason = '';
        $this->dispatch('show-rejection-modal');
    }
    
    /**
     * Reject expense with reason
     */
    public function rejectExpense()
    {
        $this->validate([
            'rejection_reason' => 'required|string|min:10|max:500',
        ]);
        
        $expense = Expense::forCurrentTenant()->findOrFail($this->rejectingId);
        
        $expense->update([
            'status' => 'rejected',
            'notes' => ($expense->notes ?? '') . "\n[REJECTED by Treasurer on " . now()->format('Y-m-d') . "]\nReason: " . $this->rejection_reason,
        ]);
        
        $this->rejectingId = null;
        $this->rejection_reason = '';
        $this->loadTreasurerStatistics();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Expense rejected successfully.'
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
        $this->dispatch('show-payment-modal');
    }
    
    /**
     * Mark expense as paid
     */
    public function markAsPaid()
    {
        $expense = Expense::forCurrentTenant()->findOrFail($this->payingId);
        
        $expense->update([
            'status' => 'paid',
        ]);
        
        $this->payingId = null;
        $this->loadTreasurerStatistics();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Payment recorded successfully!'
        ]);
    }
    
    // ==================== CRUD OPERATIONS ====================
    
    /**
     * Save or update expense
     */
    public function saveExpense()
    {
        $this->validate();
        
        $data = [
            'tenant_id' => auth()->user()->current_tenant_id,
            'expense_date' => $this->expense_date,
            'expense_number' => $this->expense_number,
            'amount' => $this->amount,
            'expense_category_id' => $this->expense_category_id,
            'description' => $this->description,
            'paid_to' => $this->paid_to,
            'payment_method' => $this->payment_method,
            'reference_number' => $this->reference_number,
            'receipt_available' => $this->receipt_available,
            'notes' => $this->notes,
            'status' => 'pending',
        ];
        
        if ($this->editingId) {
            $expense = Expense::forCurrentTenant()->findOrFail($this->editingId);
            
            if ($expense->status !== 'pending') {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Can only edit pending expenses.'
                ]);
                return;
            }
            
            $expense->update($data);
            $message = 'Expense updated successfully!';
        } else {
            Expense::create($data);
            $this->generateExpenseNumber();
            $message = 'Expense recorded successfully!';
        }
        
        $this->resetForm();
        $this->showForm = false;
        $this->loadTreasurerStatistics();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $message
        ]);
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
        $this->expense_number = $expense->expense_number;
        $this->amount = $expense->amount;
        $this->expense_category_id = $expense->expense_category_id;
        $this->description = $expense->description;
        $this->paid_to = $expense->paid_to;
        $this->payment_method = $expense->payment_method;
        $this->reference_number = $expense->reference_number;
        $this->receipt_available = $expense->receipt_available;
        $this->notes = $expense->notes;
        $this->showForm = true;
        
        $this->dispatch('scroll-to-form');
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
        
        if (confirm('Are you sure you want to delete this expense?')) {
            $expense->delete();
            $this->loadTreasurerStatistics();
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Expense deleted successfully!'
            ]);
        }
    }
    
    /**
     * View expense details
     */
    public function viewDetails($id)
    {
        $expense = Expense::forCurrentTenant()->with(['category', 'approver', 'secondApprover'])->findOrFail($id);
        $this->dispatch('show-expense-details', expense: $expense);
    }
    
    /**
     * Reset form
     */
    public function resetForm()
    {
        $this->reset([
            'editingId', 'approvingId', 'payingId', 'rejectingId',
            'amount', 'expense_category_id', 'description', 'paid_to',
            'payment_method', 'reference_number', 'receipt_available', 'notes',
            'rejection_reason'
        ]);
        
        $this->expense_date = now()->format('Y-m-d');
        $this->amount = 0;
        if (!$this->editingId) {
            $this->generateExpenseNumber();
        }
    }
    
    /**
     * Clear all filters
     */
    public function clearFilters()
    {
        $this->reset(['search', 'status', 'month', 'category_id']);
        $this->resetPage();
    }
    
    /**
     * Export monthly report
     */
    public function exportMonthlyReport()
    {
        [$year, $month] = $this->month ? explode('-', $this->month) : [now()->year, now()->month];
        
        $expenses = Expense::forCurrentTenant()
            ->with('category')
            ->whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month)
            ->get();
        
        $monthName = Carbon::createFromDate($year, $month, 1)->format('F Y');
        
        return response()->streamDownload(function () use ($expenses, $monthName) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ["Church Treasurer Report - {$monthName}"]);
            fputcsv($file, ['Generated: ' . now()->format('Y-m-d H:i:s')]);
            fputcsv($file, ['Generated by: ' . auth()->user()->name]);
            fputcsv($file, ['']);
            
            fputcsv($file, ['Date', 'Expense #', 'Category', 'Description', 'Amount', 'Paid To', 'Status', 'Approved By', 'Approved At']);
            
            foreach ($expenses as $expense) {
                fputcsv($file, [
                    $expense->expense_date->format('m/d/Y'),
                    $expense->expense_number,
                    $expense->category->name ?? 'N/A',
                    $expense->description,
                    number_format($expense->amount, 2),
                    $expense->paid_to,
                    ucfirst($expense->status),
                    $expense->approver->name ?? ($expense->approved_by_2 ? 'Committee Member' : 'Pending'),
                    $expense->approved_at ? $expense->approved_at->format('m/d/Y') : 'Not Approved'
                ]);
            }
            
            fclose($file);
        }, "church-treasurer-report-{$monthName}.csv");
    }
    
    // ==================== COMPUTED PROPERTIES ====================
    
    /**
     * Get filtered expenses for treasurer
     */
    public function getExpensesProperty()
    {
        $query = Expense::forCurrentTenant()
            ->with(['category', 'approver'])
            ->orderBy('expense_date', 'desc');
        
        // Status filter
        if ($this->status) {
            $query->where('status', $this->status);
        } else {
            // Default: Show expenses needing treasurer attention
            $query->whereIn('status', ['pending', 'approved']);
        }
        
        // Month filter - using YOUR ForMonthYear scope
        if ($this->month) {
            [$year, $month] = explode('-', $this->month);
            $query->forMonthYear($month, $year);
        }
        
        // Category filter
        if ($this->category_id) {
            $query->where('expense_category_id', $this->category_id);
        }
        
        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                  ->orWhere('paid_to', 'like', '%' . $this->search . '%')
                  ->orWhere('expense_number', 'like', '%' . $this->search . '%')
                  ->orWhere('reference_number', 'like', '%' . $this->search . '%');
            });
        }
        
        return $query->paginate($this->perPage);
    }
    
    /**
     * Get category totals for treasurer dashboard
     */
    public function getCategoryTotalsProperty()
    {
        return Expense::forCurrentTenant()
            ->selectRaw('expense_category_id, SUM(amount) as total')
            ->with('category')
            ->whereIn('status', ['approved', 'paid'])
            ->where('expense_date', '>=', now()->subMonths(3))
            ->groupBy('expense_category_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
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
     * Get months for filter dropdown
     */
    public function getMonthsProperty()
    {
        $months = collect();
        
        // Last 12 months
        for ($i = 0; $i < 12; $i++) {
            $date = now()->subMonths($i);
            $months->push([
                'value' => $date->format('Y-m'),
                'label' => $date->format('F Y')
            ]);
        }
        
        return $months;
    }
    
    /**
     * Get categories for dropdown
     */
    public function getCategoriesProperty()
    {
        return ExpenseCategory::forCurrentTenant()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }
    
    // ==================== RENDER ====================
    
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

