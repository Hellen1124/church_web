<?php

namespace App\Livewire\FinanceAdminDashboard;

use Livewire\Component;
use App\Models\SundayCollection;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\WithPagination;



class DashboardIndex extends Component
{
    public $currentMonthCollections = 0;
    public $currentMonthExpenses = 0;
    public $pendingApprovals = 0;
    public $pendingDeposits = 0;
    public $netBalance = 0;
    public $weeklyTrend = [];
    public $topExpenseCategories = [];
    public $recentTransactions = [];
    
    public $tenantId;
    
    protected $listeners = ['refreshDashboard' => '$refresh'];

    public function mount()
    {
        $user = auth()->user();
        
        if (!$user->tenant) {
            $this->dispatch('show-toast', type: 'error', message: 'You are not assigned to any church.');
            return;
        }
        
        $this->tenantId = $user->tenant->id;
        $this->loadStats();
    }

    public function loadStats()
    {
        if (!$this->tenantId) return;
        
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        // 1. Current Month Collections
        $this->currentMonthCollections = SundayCollection::where('tenant_id', $this->tenantId)
            ->whereMonth('collection_date', $currentMonth)
            ->whereYear('collection_date', $currentYear)
            ->sum('total_amount');
        
        // 2. Current Month Expenses (Approved only)
        $this->currentMonthExpenses = Expense::where('tenant_id', $this->tenantId)
            ->whereMonth('expense_date', $currentMonth)
            ->whereYear('expense_date', $currentYear)
            ->where('status', 'approved')
            ->sum('amount');
        
        // 3. Net Balance for the month
        $this->netBalance = $this->currentMonthCollections - $this->currentMonthExpenses;
        
        // 4. Pending Approvals (Treasurer's main job)
        $this->pendingApprovals = Expense::where('tenant_id', $this->tenantId)
            ->where('status', 'pending')
            ->count();
        
        // 5. Pending Bank Deposits (Treasurer's responsibility)
        $this->pendingDeposits = SundayCollection::where('tenant_id', $this->tenantId)
            ->where('status', 'counted')
            ->whereNull('bank_deposit_date')
            ->count();
        
        // 6. Weekly Trend (Last 4 weeks)
        $this->weeklyTrend = $this->getWeeklyTrend();
        
        // 7. Top Expense Categories this month
        $this->topExpenseCategories = $this->getTopExpenseCategories($currentMonth, $currentYear);
        
        // 8. Recent Critical Transactions (Mixed collections & expenses)
        $this->recentTransactions = $this->getRecentTransactions();
    }

    private function getWeeklyTrend()
    {
        $trend = [];
        
        for ($i = 3; $i >= 0; $i--) {
            $weekStart = Carbon::now()->subWeeks($i)->startOfWeek();
            $weekEnd = Carbon::now()->subWeeks($i)->endOfWeek();
            
            $weekCollections = SundayCollection::where('tenant_id', $this->tenantId)
                ->whereBetween('collection_date', [$weekStart, $weekEnd])
                ->sum('total_amount');
                
            $weekExpenses = Expense::where('tenant_id', $this->tenantId)
                ->whereBetween('expense_date', [$weekStart, $weekEnd])
                ->where('status', 'approved')
                ->sum('amount');
                
            $trend[] = [
                'week' => 'Week ' . (4 - $i),
                'date_range' => $weekStart->format('M d') . ' - ' . $weekEnd->format('M d'),
                'collections' => $weekCollections,
                'expenses' => $weekExpenses,
                'net' => $weekCollections - $weekExpenses
            ];
        }
        
        return $trend;
    }

    private function getTopExpenseCategories($month, $year)
    {
        return Expense::where('tenant_id', $this->tenantId)
            ->whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->where('status', 'approved')
            ->with('category')
            ->select('expense_category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('expense_category_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->category->name ?? 'Uncategorized',
                    'amount' => $item->total,
                    'percentage' => $this->currentMonthExpenses > 0 ? ($item->total / $this->currentMonthExpenses) * 100 : 0
                ];
            });
    }

    private function getRecentTransactions()
    {
        // Get last 5 collections
        $recentCollections = SundayCollection::where('tenant_id', $this->tenantId)
            ->orderBy('collection_date', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($collection) {
                return [
                    'type' => 'collection',
                    'date' => $collection->collection_date,
                    'description' => 'Sunday Collection',
                    'amount' => $collection->total_amount,
                    'status' => $collection->status,
                    'icon' => 'church',
                    'color' => 'emerald'
                ];
            });
        
        // Get last 5 pending expenses (treasurer needs to see these)
        $recentExpenses = Expense::where('tenant_id', $this->tenantId)
            ->whereIn('status', ['pending', 'partially_approved'])
            ->orderBy('expense_date', 'desc')
            ->limit(2)
            ->get()
            ->map(function ($expense) {
                return [
                    'type' => 'expense',
                    'date' => $expense->expense_date,
                    'description' => $expense->description,
                    'amount' => $expense->amount,
                    'status' => $expense->status,
                    'icon' => 'receipt',
                    'color' => $expense->status === 'pending' ? 'amber' : 'purple'
                ];
            });
        
        // Merge and sort by date
        return $recentCollections->merge($recentExpenses)
            ->sortByDesc('date')
            ->values()
            ->all();
    }

    public function refreshStats()
    {
        $this->loadStats();
    }

    public function getYearToDateStatsProperty()
    {
        if (!$this->tenantId) return [];
        
        $currentYear = Carbon::now()->year;
        
        $ytdCollections = SundayCollection::where('tenant_id', $this->tenantId)
            ->whereYear('collection_date', $currentYear)
            ->sum('total_amount');
            
        $ytdExpenses = Expense::where('tenant_id', $this->tenantId)
            ->whereYear('expense_date', $currentYear)
            ->where('status', 'approved')
            ->sum('amount');
        
        return [
            'collections' => $ytdCollections,
            'expenses' => $ytdExpenses,
            'balance' => $ytdCollections - $ytdExpenses,
            'health' => $ytdExpenses > 0 ? ($ytdCollections / $ytdExpenses) * 100 : 100
        ];
    }

    public function render()
    {
        if (!auth()->user()->tenant) {
            return view('livewire.finance-admin-dashboard.dashboard-error');
        }
        
        return view('livewire.finance-admin-dashboard.dashboard-index', [
            'ytdStats' => $this->yearToDateStats
        ]);
    }
}