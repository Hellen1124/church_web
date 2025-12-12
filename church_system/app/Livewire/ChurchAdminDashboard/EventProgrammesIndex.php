<?php

namespace App\Livewire\ChurchAdminDashboard;

use Livewire\Component;
use App\Models\Event;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class EventProgrammesIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showPastEvents = false;
    public $perPage = 10;

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmEventDeletion($eventId)
    {
        if (!Auth::user()->can('delete events')) {
            $this->dispatch('notify', [
                'title' => 'Permission Denied',
                'description' => 'You are not allowed to delete events.',
                'icon' => 'error'
            ]);
            return;
        }

        try {
            $event = Event::where('tenant_id', Auth::user()->tenant_id)
                ->findOrFail($eventId);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'title' => 'Error',
                'description' => 'Event not found or not accessible.',
                'icon' => 'error'
            ]);
            return;
        }

        // New WireUI v2 dialog
        $this->dispatch('dialog.confirm', [
            'title'       => 'Permanently Delete Event?',
            'description' => "This will delete '{$event->name}'. This action cannot be undone.",
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Yes, Delete It',
                'method' => 'deleteEvent',
                'params' => [$eventId],
            ],
            'reject' => [
                'label' => 'Cancel'
            ],
        ]);
    }

    public function deleteEvent($eventId)
    {
        if (!Auth::user()->can('delete events')) {
            $this->dispatch('notify', [
                'title' => 'Permission Denied',
                'description' => 'You are not allowed to delete events.',
                'icon' => 'error'
            ]);
            return;
        }

        try {
            $event = Event::where('tenant_id', Auth::user()->tenant_id)
                ->findOrFail($eventId);

            $event->delete();

            $this->dispatch('notify', [
                'title' => 'Deleted',
                'description' => "Event '{$event->name}' deleted successfully.",
                'icon' => 'success'
            ]);

            $this->resetPage();
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'title' => 'Failed',
                'description' => 'Could not delete event.',
                'icon' => 'error'
            ]);
        }
    }

    public function render()
    {
        $query = Event::where('tenant_id', Auth::user()->tenant_id)
            ->orderBy('start_at', 'asc');

        if (!$this->showPastEvents) {
            $query->where('end_at', '>=', now());
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%")
                    ->orWhere('location', 'like', "%{$this->search}%");
            });
        }

        return view('livewire.church-admin-dashboard.event-programmes-index', [
            'events' => $query->paginate($this->perPage),
        ]);
    }
}
