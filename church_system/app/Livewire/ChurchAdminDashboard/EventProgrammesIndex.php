<?php

namespace App\Livewire\ChurchAdminDashboard;


use Livewire\Component;
use App\Models\Event;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class EventProgrammesIndex extends Component
{
    use WithPagination;

    // --- Component State Properties ---
    public $search = '';
    public $filterType = 'all'; // Placeholder for future filtering by category/type
    public $showPastEvents = false;
    public $perPage = 10;

    protected $paginationTheme = 'tailwind';

    // --- Livewire Component Methods ---

    public function updatingSearch()
    {
        // Reset the page whenever the search query changes
        $this->resetPage();
    }

    public function render()
    {
        // 1. Start with the base query for the current tenant
        // Since only authenticated staff/admins access this system, we filter by tenant_id.
        $query = Event::query()
            // This line ensures data isolation for the current church/tenant
            ->where('tenant_id', Auth::user()->tenant_id)
            ->orderBy('start_at', 'asc');

        // 2. Apply Future/Past Event Filter
        if (!$this->showPastEvents) {
            // Only show events that have not yet ended
            $query->where('end_at', '>=', now());
        }

        // 3. Apply Search Filter (name, description, location)
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('location', 'like', '%' . $this->search . '%');
            });
        }
        
        $events = $query->paginate($this->perPage);

        return view('livewire.church-admin-dashboard.event-programmes-index', [
            'events' => $events,
        ]);
    }
}
