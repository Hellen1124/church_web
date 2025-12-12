<?php

namespace App\Http\Controllers\ChurchAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class FinancialReportController extends Controller
{
    /**
     * Display a listing of the financial reports.
     */
   public function index()
    {
        return view('churchadmin.financialreports.index');
    }

    // Additional methods (create, store, show, edit, update, destroy) can be added here as needed.
   
    

    // app/Http/Controllers/FinancialReportController.php

public function downloadPdf($month, $year)
{
    // Re-use your exact same Livewire logic without triggering Livewire's JSON response
    $report = new \App\Livewire\ChurchAdminDashboard\FinancialReportIndex();

    $report->reportMonth = (int)$month;
    $report->reportYear  = (int)$year;
    $report->generateReport(); // This fills currentReport & priorReport exactly like before

    $monthName = Carbon::create($year, $month)->format('F Y');
    $priorMonthName = Carbon::create($year, $month)->subMonth()->format('F Y');

    $pdf = Pdf::loadView('churchadmin.reports.monthly-financial-pdf', [
        'currentReport'   => $report->currentReport,
        'priorReport'     => $report->priorReport,
        'monthName'       => $monthName,
        'priorMonthName' => $priorMonthName,
    ]);

    $fileName = 'Financial_Report_' . str_replace(' ', '_', $monthName) . '.pdf';

    return $pdf->download($fileName);
}
    
}