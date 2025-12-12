<?php


namespace App\Livewire\ChurchAdminDashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SundayCollection;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SundayCollectionIndex extends Component
{
    use WithPagination;

    // Properties for form
    public $collection_date;
    public $first_service_amount = 0;
    public $second_service_amount = 0;
    public $children_service_amount = 0;
    public $mobile_mpesa_amount = 0;
    public $counted_by;
    public $notes;
    
    // Properties for editing
    public $editingId = null;
    public $verifyingId = null;
    public $bankingId = null;
    
    // Verification properties
    public $verified_by;
    public $verified_by_2;
    public $bank_deposit_date;
    public $bank_slip_number;
    
    // Search and filter
    public $search = '';
    public $status = '';
    public $month;
    public $year;
    public $perPage = 15;
    public $sortField = 'collection_date';
    public $sortDirection = 'desc';
    
    // UI properties
    public $showForm = true;
    public $chartType = 'bar';
    
    // Statistics
    public $currentMonthTotal = 0;
    public $lastMonthTotal = 0;
    public $weeklyAverage = 0;

    protected $rules = [
        'collection_date' => 'required|date',
        'first_service_amount' => 'required|numeric|min:0',
        'second_service_amount' => 'required|numeric|min:0',
        'children_service_amount' => 'required|numeric|min:0',
        'mobile_mpesa_amount' => 'required|numeric|min:0',
        'counted_by' => 'required|string|max:100',
        'notes' => 'nullable|string|max:500',
    ];

    // Listeners for Livewire events
    protected $listeners = ['refresh-table' => '$refresh'];

  public function mount()
{
    // FIX: If session doesn't have tenant_id but user does, set it
    if (!session()->has('tenant_id') && auth()->check() && auth()->user()->tenant_id) {
        session()->put('tenant_id', auth()->user()->tenant_id);
    }
    
    // Rest of your mount code...
    $this->resetForm();
    $this->loadStatistics();
    $this->counted_by = auth()->user()->name;
    $this->collection_date = now()->format('Y-m-d');
}
    public function resetForm()
    {
        $this->editingId = null;
        $this->verifyingId = null;
        $this->bankingId = null;
        
        $this->collection_date = '';
        $this->first_service_amount = 0;
        $this->second_service_amount = 0;
        $this->children_service_amount = 0;
        $this->mobile_mpesa_amount = 0;
        $this->counted_by = '';
        $this->notes = '';
        $this->verified_by = '';
        $this->verified_by_2 = '';
        $this->bank_deposit_date = '';
        $this->bank_slip_number = '';
    }

    public function loadStatistics()
    {
        $this->currentMonthTotal = SundayCollection::forCurrentTenant()
            ->thisMonth()
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $this->lastMonthTotal = SundayCollection::forCurrentTenant()
            ->lastMonth()
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $this->weeklyAverage = SundayCollection::forCurrentTenant()
            ->where('status', '!=', 'cancelled')
            ->where('collection_date', '>=', now()->subWeeks(4))
            ->average('total_amount') ?? 0;
    }

    public function save()
{
    $this->validate();

    // Calculate total amount
    $totalAmount = $this->first_service_amount + 
                   $this->second_service_amount + 
                   $this->children_service_amount + 
                   $this->mobile_mpesa_amount;

    $data = [
        'collection_date' => $this->collection_date,
        'first_service_amount' => $this->first_service_amount,
        'second_service_amount' => $this->second_service_amount,
        'children_service_amount' => $this->children_service_amount,
        'mobile_mpesa_amount' => $this->mobile_mpesa_amount,
        'counted_by' => $this->counted_by,
        'notes' => $this->notes,
        'status' => 'counted',
        'total_amount' => $totalAmount, // ADD THIS LINE
    ];

    if ($this->editingId) {
        $collection = SundayCollection::forCurrentTenant()->findOrFail($this->editingId);
        
        // Only allow editing if status is pending or counted
        if (!in_array($collection->status, ['pending', 'counted'])) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Cannot edit a verified or banked collection.'
            ]);
            return;
        }
        
        $collection->update($data);
        $message = 'Collection updated successfully!';
    } else {
        SundayCollection::create($data);
        $message = 'Collection recorded successfully!';
    }

    $this->resetForm();
    $this->loadStatistics();
    
    $this->dispatch('notify', [
        'type' => 'success',
        'message' => $message
    ]);
    
    $this->dispatch('refresh-table');
}
    public function edit($id)
    {
        $collection = SundayCollection::forCurrentTenant()->findOrFail($id);
        
        // Only allow editing if status is pending or counted
        if (!in_array($collection->status, ['pending', 'counted'])) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Cannot edit a verified or banked collection.'
            ]);
            return;
        }

        $this->editingId = $id;
        $this->collection_date = $collection->collection_date->format('Y-m-d');
        $this->first_service_amount = $collection->first_service_amount;
        $this->second_service_amount = $collection->second_service_amount;
        $this->children_service_amount = $collection->children_service_amount;
        $this->mobile_mpesa_amount = $collection->mobile_mpesa_amount;
        $this->counted_by = $collection->counted_by;
        $this->notes = $collection->notes;
        $this->showForm = true;
        
        $this->dispatch('scroll-to-form');
    }

    public function delete($id)
    {
        $collection = SundayCollection::forCurrentTenant()->findOrFail($id);
        
        // Only allow deletion if status is pending
        if ($collection->status !== 'pending') {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Can only delete pending collections.'
            ]);
            return;
        }

        $collection->delete();
        
        $this->loadStatistics();
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Collection deleted successfully!'
        ]);
        
        $this->dispatch('refresh-table');
    }

    public function markAsCounted($id)
    {
        $collection = SundayCollection::forCurrentTenant()->findOrFail($id);
        
        if ($collection->status === 'pending') {
            $collection->update([
                'status' => 'counted',
                'counted_by' => Auth::user()->name
            ]);
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Marked as counted!'
            ]);
            
            $this->dispatch('refresh-table');
        }
    }

    public function startVerify($id)
    {
        $collection = SundayCollection::forCurrentTenant()->findOrFail($id);
        
        if ($collection->status === 'counted') {
            $this->verifyingId = $id;
            $this->dispatch('open-verification-modal');
        }
    }

    public function verifyFirst()
    {
        $this->validate([
            'verified_by' => 'required|string|max:100'
        ]);

        $collection = SundayCollection::forCurrentTenant()->findOrFail($this->verifyingId);
        $collection->verified_by = Auth::user()->id;
        
        if ($collection->verified_by_2) {
            $collection->status = 'verified';
        }
        
        $collection->save();
        
        $this->verifyingId = null;
        $this->verified_by = '';
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'First verification completed!'
        ]);
        
        $this->dispatch('refresh-table');
        $this->dispatch('close-modal');
    }

    public function verifySecond()
    {
        $this->validate([
            'verified_by_2' => 'required|string|max:100'
        ]);

        $collection = SundayCollection::forCurrentTenant()->findOrFail($this->verifyingId);
        $collection->verified_by_2 = Auth::user()->id;
        
        if ($collection->verified_by) {
            $collection->status = 'verified';
        }
        
        $collection->save();
        
        $this->verifyingId = null;
        $this->verified_by_2 = '';
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Second verification completed! Collection is now verified!'
        ]);
        
        $this->dispatch('refresh-table');
        $this->dispatch('close-modal');
    }

    public function startBanking($id)
    {
        $collection = SundayCollection::forCurrentTenant()->findOrFail($id);
        
        if ($collection->status === 'verified') {
            $this->bankingId = $id;
            $this->bank_deposit_date = now()->format('Y-m-d');
            $this->dispatch('open-banking-modal');
        }
    }

    public function markAsBanked()
    {
        $this->validate([
            'bank_deposit_date' => 'required|date',
            'bank_slip_number' => 'nullable|string|max:50'
        ]);

        $collection = SundayCollection::forCurrentTenant()->findOrFail($this->bankingId);
        $collection->update([
            'status' => 'banked',
            'bank_deposit_date' => $this->bank_deposit_date,
            'bank_slip_number' => $this->bank_slip_number,
            'bank_deposit_amount' => $collection->total_amount
        ]);
        
        $this->bankingId = null;
        $this->bank_deposit_date = '';
        $this->bank_slip_number = '';
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Marked as bank deposited!'
        ]);
        
        $this->dispatch('refresh-table');
        $this->dispatch('close-modal');
    }

    public function cancel($id)
    {
        $collection = SundayCollection::forCurrentTenant()->findOrFail($id);
        
        if (!in_array($collection->status, ['pending', 'counted'])) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Can only cancel pending or counted collections.'
            ]);
            return;
        }

        $collection->update([
            'status' => 'cancelled',
            'notes' => $collection->notes . "\n[CANCELLED by " . Auth::user()->name . " on " . now()->format('Y-m-d H:i') . "]"
        ]);
        
        $this->loadStatistics();
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Collection cancelled!'
        ]);
        
        $this->dispatch('refresh-table');
    }

    // New methods for enhanced functionality
    public function clearFilters()
    {
        $this->reset(['search', 'status', 'month', 'year']);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'desc';
        }
    }

    public function export()
    {
        $collections = $this->getCollectionsQuery()->get();
        
        return response()->streamDownload(function () use ($collections) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['Date', '1st Service', '2nd Service', 'Children', 'M-Pesa', 'Total', 'Status', 'Counted By', 'Notes']);
            
            foreach ($collections as $collection) {
                fputcsv($file, [
                    $collection->collection_date->format('Y-m-d'),
                    $collection->first_service_amount,
                    $collection->second_service_amount,
                    $collection->children_service_amount,
                    $collection->mobile_mpesa_amount,
                    $collection->total_amount,
                    ucfirst($collection->status),
                    $collection->counted_by,
                    $collection->notes
                ]);
            }
            
            fclose($file);
        }, 'sunday-collections-' . now()->format('Y-m-d') . '.csv');
    }

    public function duplicateCollection($id)
    {
        $original = SundayCollection::forCurrentTenant()->findOrFail($id);
        
        $duplicate = $original->replicate();
        $duplicate->status = 'pending';
        $duplicate->created_at = now();
        $duplicate->updated_at = now();
        $duplicate->save();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Collection duplicated successfully!'
        ]);
        
        $this->dispatch('refresh-table');
    }

    public function updatedChartType()
    {
        $this->dispatch('chart-type-changed');
    }

    public function getCollectionsQuery()
    {
        $query = SundayCollection::forCurrentTenant()
            ->with(['firstVerifier', 'secondVerifier'])
            ->orderBy($this->sortField, $this->sortDirection);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('counted_by', 'like', '%' . $this->search . '%')
                  ->orWhere('notes', 'like', '%' . $this->search . '%')
                  ->orWhere('bank_slip_number', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->month) {
            $query->whereMonth('collection_date', $this->month);
        }

        if ($this->year) {
            $query->whereYear('collection_date', $this->year);
        }

        return $query;
    }

    public function getCollectionsProperty()
    {
        return $this->getCollectionsQuery()->paginate($this->perPage);
    }

    public function getMonthlyBreakdownProperty()
    {
        return SundayCollection::forCurrentTenant()
            ->selectRaw('YEAR(collection_date) as year, MONTH(collection_date) as month, SUM(total_amount) as total')
            ->where('status', '!=', 'cancelled')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();
    }

    public function getTotalPhysicalCash($collection)
    {
        return $collection->first_service_amount + 
               $collection->second_service_amount + 
               $collection->children_service_amount;
    }

    public function render()
    {
        return view('livewire.church-admin-dashboard.sunday-collection-index', [
            'collections' => $this->collections,
            'monthlyBreakdown' => $this->monthlyBreakdown,
        ]);
    }
}
