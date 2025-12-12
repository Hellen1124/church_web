<?php

namespace App\Livewire\ChurchAdminDashboard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\SundayCollection;
use App\Models\Expense;



class FinancialReportIndex extends Component
{
    // --- Public Properties (for reactivity) ---
    public $reportMonth;
    public $reportYear;
    public $currentReport = ['income' => [], 'expenses' => [], 'net_position' => 0, 'closing_balance' => 0];
    public $priorReport = ['income' => [], 'expenses' => [], 'net_position' => 0, 'closing_balance' => 0];

    // --- Life Cycle Hooks ---
    public function mount()
    {
        // Set default to the current month/year 
        $this->reportMonth = now()->month;
        $this->reportYear = now()->year;
        $this->generateReport();
    }

    // --- Core Logic ---
    public function generateReport()
    {
        $priorDate = Carbon::createFromDate($this->reportYear, $this->reportMonth, 1)->subMonth();

        $this->currentReport = $this->fetchData($this->reportMonth, $this->reportYear);
        $this->priorReport = $this->fetchData($priorDate->month, $priorDate->year);
    }
    
    // Helper method to define the grouping logic (REQUIRED MAPPING)
    private function getExpenseGroupIds(): array
    {
        // !!! REPLACE PLACEHOLDER IDs WITH YOUR ACTUAL EXPENSE CATEGORY IDs !!!
        return [
            'Salaries & Personnel' => [1], 
            'Loans & Insurance' => [2, 3],
            'Facilities & Utilities' => [4, 5, 6],
            'Hospitality & Food' => [7, 8],
            'Ministry & Outreach' => [9, 10, 11, 12],
            'Equipment & Admin' => [13, 14, 15],
        ];
    }

    private function fetchData(int $month, int $year): array
    {
        // 1. --- Income Calculation ---
        $collections = SundayCollection::forMonthYear($month, $year)
            ->banked() 
            ->get();
        $incomeTotal = $collections->sum('total_amount');
        
        $data['income'] = [
            'First Service' => $collections->sum('first_service_amount'),
            'Second Service' => $collections->sum('second_service_amount'),
            'Children Service' => $collections->sum('children_service_amount'),
            'Mobile/Mpesa' => $collections->sum('mobile_mpesa_amount'),
            'total' => (float)$incomeTotal,
        ];
        
        // 2. --- Expense Calculation (Grouped) ---
        $expenseGroupIds = $this->getExpenseGroupIds();

        // Used `whereMonth` and `whereYear` directly as the scope was missing earlier.
        $expenseDetails = Expense::whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->paid() 
            ->select('expense_category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('expense_category_id')
            ->get()
            ->pluck('total', 'expense_category_id')
            ->toArray();

        $expenseTotals = 0;
        $data['expenses'] = [];

        foreach ($expenseGroupIds as $groupName => $categoryIds) {
            $groupTotal = 0;
            foreach ($categoryIds as $id) {
                $groupTotal += (float)($expenseDetails[$id] ?? 0);
            }
            $data['expenses'][$groupName] = $groupTotal;
            $expenseTotals += $groupTotal;
        }
        $data['expenses']['total'] = (float)$expenseTotals;

        // 3. --- Summary Calculation ---
        $data['net_position'] = $data['income']['total'] - $data['expenses']['total'];
        $data['closing_balance'] = $data['net_position']; 
        
        return $data;
    }
    
    // --- Download Functionality (FULLY IMPLEMENTED) ---
    // app/Livewire/FinancialReport.php (inside FinancialReport class)

 // app/Livewire/ChurchAdminDashboard/FinancialReportIndex.php (or FinancialReport.php)


      // Inside your FinancialReportIndex Livewire component
public function downloadPdfReport()
{
    return redirect()->route('church.financialreports.download', [
        'month' => $this->reportMonth,
        'year'  => $this->reportYear,
    ]);
}
    

    public function render()
    {
        $monthName = Carbon::createFromDate($this->reportYear, $this->reportMonth)->format('F Y');
        $priorMonthName = Carbon::createFromDate($this->reportYear, $this->reportMonth)->subMonth()->format('F Y');

        return view('livewire.church-admin-dashboard.financial-report-index', [
            'monthName' => $monthName,
            'priorMonthName' => $priorMonthName,
        ]);
    }
}