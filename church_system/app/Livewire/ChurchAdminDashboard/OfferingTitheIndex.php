<?php

namespace App\Livewire\ChurchAdminDashboard;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


class OfferingTitheIndex extends Component
{
    use WithPagination;

    // --- Search & Filter Properties ---
    public $search = '';
    public $filterType = ''; // e.g., 'Tithe', 'Offering', 'Missions'
    public $startDate = null;
    public $endDate = null;

    // --- Deletion Property ---
    protected $offeringToDelete;

    // --- Query String Setup ---
    protected $queryString = [
        'search' => ['except' => ''],
        'filterType' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // --- Deletion Methods ---

    public function confirmOfferingDeletion(int $offeringId)
    {
        // Permission check (assuming Spatie permissions)
        if (!Auth::user()->can('delete offerings')) {
            $this->notification()->error('Permission Denied', 'You cannot delete financial records.');
            return;
        }

        try {
            $offering = Offering::where('tenant_id', Auth::user()->tenant_id)
                                ->findOrFail($offeringId);
        } catch (\Exception $e) {
            $this->notification()->error('Error', 'Record not found.');
            return;
        }

        $this->dialog()->confirm([
            'title'       => 'DELETE FINANCIAL RECORD?',
            'description' => "This will permanently delete the contribution of {$offering->amount} recorded on {$offering->recorded_at->format('Y-m-d')}. This cannot be undone.",
            'icon'        => 'error', 
            'accept'      => [
                'label'  => 'Yes, Delete',
                'method' => 'deleteOffering', 
                'params' => [$offeringId],
                'color'  => 'negative',
            ],
            'reject' => [
                'label'  => 'Cancel',
                'color'  => 'secondary',
            ],
        ]);
    }

    public function deleteOffering(int $offeringId)
    {
        if (!Auth::user()->can('delete offerings')) {
            $this->notification()->error('Permission Denied', 'You cannot delete financial records.');
            return;
        }

        try {
            $offering = Offering::where('tenant_id', Auth::user()->tenant_id)
                                ->findOrFail($offeringId);
            $offering->delete();
            $this->notification()->success('Success!', 'The financial record has been deleted.');
        } catch (\Exception $e) {
            $this->notification()->error('Failed', 'Could not delete the record.');
        }
    }


    // --- Render Method ---

    public function render()
    {
        $offerings = Offering::where('tenant_id', Auth::user()->tenant_id)
            ->when($this->search, function ($query) {
                // Search by notes or contributor name (assuming relationship)
                $query->where('notes', 'like', '%' . $this->search . '%')
                      // Add a search relationship here if offerings are linked to a members table
                      // ->orWhereHas('member', fn ($q) => $q->where('name', 'like', '%' . $this->search . '%'));
                      ;
            })
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->startDate, function ($query) {
                $query->whereDate('recorded_at', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                // Add one day to include the full end date
                $query->whereDate('recorded_at', '<=', $this->endDate);
            })
            ->orderBy('recorded_at', 'desc')
            ->paginate(15);

        // Define available types for the filter dropdown
        $availableTypes = ['Tithe', 'Offering', 'Building Fund', 'Missions'];

        return view('livewire.church-admin-dashboard.offering-tithe-index', [
            'offerings' => $offerings,
            'availableTypes' => $availableTypes,
        ]);
    }
}
