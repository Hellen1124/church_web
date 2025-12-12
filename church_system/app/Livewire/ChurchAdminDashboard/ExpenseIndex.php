<?php



namespace App\Livewire\ChurchAdminDashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Auth;

class ExpenseIndex extends Component
{
    use WithPagination;

    // Form properties
    public $expense_date;
    public $expense_number;
    public $amount = 0;
    public $expense_category_id;
    public $description;
    public $paid_to;
    public $payment_method = 'cash';
    public $reference_number;
    public $receipt_available = false;
    public $notes;
    
    // Editing properties
    public $editingId = null;
    public $approvingId = null;
    public $payingId = null;
    
    // Approval properties
    public $approver_name;
    public $second_approver_name;
    
    // Payment properties
    public $payment_date;
    public $payment_reference;
    
    // Search and filter
    public $search = '';
    public $status = '';
    public $category_id = '';
    public $month;
    public $year;
    public $perPage = 15;
    
    // UI properties
    public $showForm = true;
    
    // Statistics
    public $currentMonthTotal = 0;
    public $lastMonthTotal = 0;
    public $pendingTotal = 0;
    public $approvedTotal = 0;

    // Payment methods
    public $paymentMethods = [
        'cash' => 'Cash',
        'mpesa' => 'M-Pesa',
        'bank_transfer' => 'Bank Transfer',
        'cheque' => 'Cheque',
        'credit_card' => 'Credit Card'
    ];

    protected $rules = [
        'expense_date' => 'required|date',
        'amount' => 'required|numeric|min:0',
        'expense_category_id' => 'required|exists:expense_categories,id',
        'description' => 'required|string|max:255',
        'paid_to' => 'required|string|max:100',
        'payment_method' => 'required|string',
        'reference_number' => 'nullable|string|max:50',
        'receipt_available' => 'boolean',
        'notes' => 'nullable|string|max:500',
    ];

    protected $listeners = ['refresh-table' => '$refresh'];

    public function mount()
    {
        $this->resetForm();
        $this->loadStatistics();
        $this->expense_date = now()->format('Y-m-d');
        $this->generateExpenseNumber();
    }

    public function generateExpenseNumber()
    {
        $prefix = 'EXP-' . date('Y') . '-';
        $lastExpense = Expense::forCurrentTenant()
            ->where('expense_number', 'like', $prefix . '%')
            ->orderBy('expense_number', 'desc')
            ->first();
        
        if ($lastExpense) {
            $lastNumber = (int) str_replace($prefix, '', $lastExpense->expense_number);
            $this->expense_number = $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $this->expense_number = $prefix . '0001';
        }
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->approvingId = null;
        $this->payingId = null;
        
        $this->expense_date = '';
        $this->amount = 0;
        $this->expense_category_id = '';
        $this->description = '';
        $this->paid_to = '';
        $this->payment_method = 'cash';
        $this->reference_number = '';
        $this->receipt_available = false;
        $this->notes = '';
        $this->approver_name = '';
        $this->second_approver_name = '';
        $this->payment_date = '';
        $this->payment_reference = '';
        
        $this->generateExpenseNumber();
    }

    public function loadStatistics()
    {
        // Current month total
        $this->currentMonthTotal = Expense::forCurrentTenant()
            ->thisMonth()
            ->whereIn('status', ['approved', 'paid'])
            ->sum('amount');

        // Last month total
        $this->lastMonthTotal = Expense::forCurrentTenant()
            ->lastMonth()
            ->whereIn('status', ['approved', 'paid'])
            ->sum('amount');

        // Pending total
        $this->pendingTotal = Expense::forCurrentTenant()
            ->pending()
            ->sum('amount');

        // Approved total
        $this->approvedTotal = Expense::forCurrentTenant()
            ->approved()
            ->sum('amount');
    }

    public function save()
    {
        $this->validate();

        $data = [
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
            
            // Only allow editing if status is pending
            if ($expense->status !== 'pending') {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Cannot edit an approved or paid expense.'
                ]);
                return;
            }
            
            $expense->update($data);
            $message = 'Expense updated successfully!';
        } else {
            Expense::create($data);
            $message = 'Expense recorded successfully!';
        }

        $this->resetForm();
        $this->loadStatistics();
        $this->showForm = false;
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $message
        ]);
        
        $this->dispatch('refresh-table');
    }

    public function edit($id)
    {
        $expense = Expense::forCurrentTenant()->with('category')->findOrFail($id);
        
        // Only allow editing if status is pending
        if ($expense->status !== 'pending') {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Cannot edit an approved or paid expense.'
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

    public function delete($id)
    {
        $expense = Expense::forCurrentTenant()->findOrFail($id);
        
        // Only allow deletion if status is pending
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
            'message' => 'Expense deleted successfully!'
        ]);
        
        $this->dispatch('refresh-table');
    }

    public function startApproval($id)
    {
        $expense = Expense::forCurrentTenant()->findOrFail($id);
        
        if ($expense->status === 'pending') {
            $this->approvingId = $id;
            $this->dispatch('open-approval-modal');
        }
    }

    public function approveFirst()
    {
        $expense = Expense::forCurrentTenant()->findOrFail($this->approvingId);
        
        $expense->update([
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        
        // If already has second approver, mark as approved
        if ($expense->approved_by_2) {
            $expense->update(['status' => 'approved']);
        }
        
        $this->approvingId = null;
        $this->loadStatistics();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'First approval completed!'
        ]);
        
        $this->dispatch('refresh-table');
        $this->dispatch('close-modal');
    }

    public function approveSecond()
    {
        $expense = Expense::forCurrentTenant()->findOrFail($this->approvingId);
        
        $expense->update([
            'approved_by_2' => Auth::id(),
        ]);
        
        // If already has first approver, mark as approved
        if ($expense->approved_by) {
            $expense->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]);
        }
        
        $this->approvingId = null;
        $this->loadStatistics();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Second approval completed! Expense is now approved!'
        ]);
        
        $this->dispatch('refresh-table');
        $this->dispatch('close-modal');
    }

    public function startPayment($id)
    {
        $expense = Expense::forCurrentTenant()->findOrFail($id);
        
        if ($expense->status === 'approved') {
            $this->payingId = $id;
            $this->payment_date = now()->format('Y-m-d');
            $this->dispatch('open-payment-modal');
        }
    }

    public function markAsPaid()
    {
        $this->validate([
            'payment_date' => 'required|date',
            'payment_reference' => 'nullable|string|max:50'
        ]);

        $expense = Expense::forCurrentTenant()->findOrFail($this->payingId);
        $expense->update([
            'status' => 'paid',
            'payment_reference' => $this->payment_reference,
            'paid_at' => $this->payment_date,
        ]);
        
        $this->payingId = null;
        $this->payment_date = '';
        $this->payment_reference = '';
        
        $this->loadStatistics();
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Marked as paid!'
        ]);
        
        $this->dispatch('refresh-table');
        $this->dispatch('close-modal');
    }

    public function reject($id)
    {
        $expense = Expense::forCurrentTenant()->findOrFail($id);
        
        if ($expense->status === 'pending') {
            $expense->update([
                'status' => 'rejected',
                'notes' => $expense->notes . "\n[REJECTED by " . Auth::user()->name . " on " . now()->format('Y-m-d H:i') . "]"
            ]);
            
            $this->loadStatistics();
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Expense rejected!'
            ]);
            
            $this->dispatch('refresh-table');
        }
    }

    public function cancel($id)
    {
        $expense = Expense::forCurrentTenant()->findOrFail($id);
        
        if (in_array($expense->status, ['pending', 'approved'])) {
            $expense->update([
                'status' => 'cancelled',
                'notes' => $expense->notes . "\n[CANCELLED by " . Auth::user()->name . " on " . now()->format('Y-m-d H:i') . "]"
            ]);
            
            $this->loadStatistics();
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Expense cancelled!'
            ]);
            
            $this->dispatch('refresh-table');
        }
    }

    public function clearFilters()
    {
        $this->reset(['search', 'status', 'category_id', 'month', 'year']);
    }

    public function export()
    {
        $expenses = $this->getExpensesQuery()->get();
        
        return response()->streamDownload(function () use ($expenses) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['Date', 'Expense No', 'Category', 'Description', 'Amount', 'Paid To', 'Status', 'Payment Method', 'Reference']);
            
            foreach ($expenses as $expense) {
                fputcsv($file, [
                    $expense->expense_date->format('Y-m-d'),
                    $expense->expense_number,
                    $expense->category->name ?? 'N/A',
                    $expense->description,
                    $expense->amount,
                    $expense->paid_to,
                    ucfirst($expense->status),
                    $expense->payment_method,
                    $expense->reference_number
                ]);
            }
            
            fclose($file);
        }, 'church-expenses-' . now()->format('Y-m-d') . '.csv');
    }

    public function getExpensesQuery()
    {
        $query = Expense::forCurrentTenant()
            ->with(['category', 'approver', 'secondApprover'])
            ->orderBy('expense_date', 'desc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('expense_number', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('paid_to', 'like', '%' . $this->search . '%')
                  ->orWhere('reference_number', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->category_id) {
            $query->where('expense_category_id', $this->category_id);
        }

        if ($this->month) {
            $query->whereMonth('expense_date', $this->month);
        }

        if ($this->year) {
            $query->whereYear('expense_date', $this->year);
        }

        return $query;
    }

    public function getExpensesProperty()
    {
        return $this->getExpensesQuery()->paginate($this->perPage);
    }

    public function getCategoriesProperty()
    {
        return ExpenseCategory::forCurrentTenant()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function getMonthlyBreakdownProperty()
    {
        return Expense::forCurrentTenant()
            ->selectRaw('YEAR(expense_date) as year, MONTH(expense_date) as month, SUM(amount) as total')
            ->whereIn('status', ['approved', 'paid'])
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();
    }

    public function getTopCategoriesProperty()
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

    public function render()
    {
        return view('livewire.church-admin-dashboard.expense-index', [
            'expenses' => $this->expenses,
            'categories' => $this->categories,
            'monthlyBreakdown' => $this->monthlyBreakdown,
            'topCategories' => $this->topCategories,
        ]);
    }
}
