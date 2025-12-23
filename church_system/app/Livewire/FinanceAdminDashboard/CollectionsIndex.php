<?php

namespace App\Livewire\FinanceAdminDashboard;



use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SundayCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class CollectionsIndex extends Component
{
    use WithPagination;

    // Search and filters
    public $search = '';
    public $status = '';
    public $month = '';
    public $year = '';
    public $perPage = 10;
    public $sortField = 'collection_date';
    public $sortDirection = 'desc';
    
    // Form properties
    public $showForm = false;
    public $editingId = null;
    public $verifyingId = null;
    public $bankingId = null;
    
    // Collection fields
    public $collection_date;
    public $first_service_amount = 0;
    public $second_service_amount = 0;
    public $children_service_amount = 0;
    public $mobile_mpesa_amount = 0;
    public $counted_by;
    public $notes = '';
    
    // Verification and banking
    public $bank_deposit_date;
    public $bank_slip_number = '';
    
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

    protected $listeners = ['refresh-table' => '$refresh'];

    public function mount()
    {
        // Auto-fill counted_by with treasurer's name
        $this->counted_by = Auth::user()->name;
        $this->collection_date = now()->format('Y-m-d');
        
        // Load initial statistics
        $this->loadStatistics();
    }
    
    public function resetForm()
    {
        $this->editingId = null;
        $this->verifyingId = null;
        $this->bankingId = null;
        
        $this->collection_date = now()->format('Y-m-d');
        $this->first_service_amount = 0;
        $this->second_service_amount = 0;
        $this->children_service_amount = 0;
        $this->mobile_mpesa_amount = 0;
        $this->counted_by = Auth::user()->name;
        $this->notes = '';
        $this->bank_deposit_date = now()->format('Y-m-d');
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
    
    // ================= SIMPLIFIED SINGLE VERIFICATION =================
    
    /**
     * Save or update a collection
     */
    public function save()
    {
        $this->validate();

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
            'total_amount' => $totalAmount,
        ];

        if ($this->editingId) {
            $collection = SundayCollection::forCurrentTenant()->findOrFail($this->editingId);
            
            // Treasurer can only edit if status is pending or counted
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
            // New collection - always pending when created by treasurer
            $data['status'] = 'pending';
            SundayCollection::create($data);
            $message = 'Collection recorded successfully!';
        }

        $this->resetForm();
        $this->showForm = false;
        $this->loadStatistics();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $message
        ]);
        
        $this->dispatch('refresh-table');
    }
    
    /**
     * Edit a collection
     */
    public function edit($id)
    {
        $collection = SundayCollection::forCurrentTenant()->findOrFail($id);
        
        // Treasurer can only edit if status is pending or counted
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
    
    /**
     * Mark a pending collection as counted
     */
    public function markAsCounted($id)
    {
        $collection = SundayCollection::forCurrentTenant()->findOrFail($id);
        
        if ($collection->status === 'pending') {
            $collection->update([
                'status' => 'counted',
                
            ]);
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Marked as counted! Ready for verification.'
            ]);
            
            $this->dispatch('refresh-table');
        } else {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Only pending collections can be marked as counted.'
            ]);
        }
    }
    
    /**
     * SIMPLIFIED: Single verification - treasurer can verify any counted collection
     */
    public function verifyCollection($id)
{
    try {
        $collection = SundayCollection::forCurrentTenant()->findOrFail($id);
        
        if ($collection->status === 'counted') {
            // Get the numeric user ID from the User object
            $userId = Auth::user()->id;
            
            // Debug log
            Log::info('Verifying collection', [
                'collection_id' => $id,
                'user_id' => $userId,
                'user_phone' => Auth::user()->phone,
                'auth_id' => Auth::id(),
            ]);
            
            $collection->update([
                'status' => 'verified',
                'verified_by' => $userId,  // ← This MUST be numeric ID
                'verified_by_2' => null,
            ]);
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Collection verified successfully! Ready for banking.'
            ]);
            
            $this->dispatch('refresh-table');
        }
    } catch (\Exception $e) {
        Log::error('Verify collection failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        
        $this->dispatch('notify', [
            'type' => 'error',
            'message' => 'Verification failed: ' . $e->getMessage()
        ]);
    }
}
    /**
     * Start banking process (for verified collections)
     */
    public function startBanking($id)
    {
        $collection = SundayCollection::forCurrentTenant()->findOrFail($id);
        
        // Simplified: can bank any verified collection (single verification is enough)
        if ($collection->status === 'verified') {
            $this->bankingId = $id;
            $this->bank_deposit_date = now()->format('Y-m-d');
        } else {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Only verified collections can be banked.'
            ]);
        }
    }
    
    /**
     * Mark collection as banked
     */
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
    }
    
    /**
     * Cancel a collection
     */
    public function cancel($id)
    {
        $collection = SundayCollection::forCurrentTenant()->findOrFail($id);
        
        // Can cancel only pending or counted collections
        if (!in_array($collection->status, ['pending', 'counted'])) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Can only cancel pending or counted collections.'
            ]);
            return;
        }

        $collection->update([
            'status' => 'cancelled',
            'notes' => ($collection->notes ?? '') . "\n[CANCELLED by Treasurer " . Auth::user()->name . " on " . now()->format('Y-m-d H:i') . "]"
        ]);
        
        $this->loadStatistics();
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Collection cancelled!'
        ]);
        
        $this->dispatch('refresh-table');
    }
    
    /**
     * Duplicate a collection
     */
    public function duplicateCollection($id)
    {
        $original = SundayCollection::forCurrentTenant()->findOrFail($id);
        
        $duplicate = $original->replicate();
        $duplicate->status = 'pending';
        $duplicate->verified_by = null;
        $duplicate->verified_by_2 = null;
        $duplicate->bank_deposit_date = null;
        $duplicate->bank_slip_number = null;
        $duplicate->bank_deposit_amount = 0;
        $duplicate->counted_by = Auth::user()->name;
        $duplicate->created_at = now();
        $duplicate->updated_at = now();
        $duplicate->save();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Collection duplicated successfully! You can now edit it.'
        ]);
        
        $this->dispatch('refresh-table');
    }
    
    // ================= HELPER METHODS =================
    
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
            
            fputcsv($file, ['Date', '1st Service', '2nd Service', 'Children', 'M-Pesa', 'Total', 'Status', 'Counted By', 'Verified By', 'Banked Date', 'Notes']);
            
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
                    $collection->firstVerifier->name ?? ($collection->verified_by ? 'Treasurer' : ''),
                    $collection->bank_deposit_date ? $collection->bank_deposit_date->format('Y-m-d') : '',
                    $collection->notes
                ]);
            }
            
            fclose($file);
        }, 'treasurer-collections-' . now()->format('Y-m-d') . '.csv');
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
    
    // SIMPLIFIED: Get collections by status (no dual verification checks)
    public function getPendingCollectionsProperty()
    {
        return SundayCollection::forCurrentTenant()
            ->pending()
            ->orderBy('collection_date', 'desc')
            ->get();
    }
    
    public function getCountedCollectionsProperty()
    {
        return SundayCollection::forCurrentTenant()
            ->counted()
            ->orderBy('collection_date', 'desc')
            ->get();
    }
    
    public function getVerifiedCollectionsProperty()
    {
        return SundayCollection::forCurrentTenant()
            ->verified()
            ->whereNull('bank_deposit_date')  // Not yet banked
            ->orderBy('collection_date', 'desc')
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
        return view('livewire.finance-admin-dashboard.collections-index', [
            'collections' => $this->collections,
            'monthlyBreakdown' => $this->monthlyBreakdown,
            'pendingCollections' => $this->pendingCollections,
            'countedCollections' => $this->countedCollections,
            'verifiedCollections' => $this->verifiedCollections,
        ]);
    }
}