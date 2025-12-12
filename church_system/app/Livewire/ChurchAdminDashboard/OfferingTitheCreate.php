<?php


namespace App\Livewire\ChurchAdminDashboard;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // <- this must be here
use App\Models\Offering;




class OfferingTitheCreate extends Component
{
    // Form fields
    public $amount;
    public $type = 'Tithe';
    public $payment_method = 'Cash';
    public $notes;
    public $recorded_at;

    // Options
    public $types = ['Tithe', 'Offering', 'Building Fund', 'Missions', 'Seed', 'Others'];
    public $paymentMethods = ['Cash', 'Cheque', 'Online Transfer', 'Mobile Money', 'POS'];

    public function mount()
    {
        $this->recorded_at = now()->format('Y-m-d');
    }

    // Validation
    protected function rules()
    {
        return [
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|string|in:' . implode(',', $this->types),
            'payment_method' => 'required|string|in:' . implode(',', $this->paymentMethods),
            'notes' => 'nullable|string|max:500',
            'recorded_at' => 'required|date|before_or_equal:today',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        // Add tenant_id; created_by is handled by TracksUserActions
        $validated['tenant_id'] = Auth::user()->tenant_id;

        try {
            Offering::create($validated);
            return redirect()->route('church.offerings.index');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Offering creation failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            // Flash generic error
            session()->flash('error', 'Failed to save contribution.');
        }
    }

    public function render()
    {
        return view('livewire.church-admin-dashboard.offering-tithe-create');
    }
}



