<?php

namespace App\Livewire\ChurchAdminDashboard;

use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EventProgrammeEdit extends Component
{
    // Public properties to hold the event ID and form data
    public Event $event;
    public $name;
    public $description;
    public $location;
    public $start_at;
    public $end_at;
    public $capacity; // Assuming this field exists

    /**
     * Mount method runs when the component is initialized with a model.
     * @param Event $event The event model passed from the route.
     */
    public function mount(Event $event)
    {
        // 1. Authorization Check (Use Spatie permission here)
        if (!Auth::user()->can('update events')) {
            abort(403, 'Unauthorized to edit events.');
        }

        // 2. Ensure event belongs to the current tenant
        if ($event->tenant_id !== Auth::user()->tenant_id) {
            abort(404); // Or 403, depending on your security preference
        }

        $this->event = $event;
        
        // 3. Populate form fields
        $this->name = $event->name;
        $this->description = $event->description;
        $this->location = $event->location;
        // Format dates for input type="datetime-local"
        $this->start_at = $event->start_at->format('Y-m-d\TH:i');
        $this->end_at = $event->end_at->format('Y-m-d\TH:i');
        $this->capacity = $event->capacity;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'capacity' => 'nullable|integer|min:1',
        ];
    }

    /**
     * Handles the form submission to update the event.
     */
    public function updateEvent()
    {
        // Final authorization check before saving
        if (!Auth::user()->can('update events')) {
            session()->flash('error', 'Permission denied.');
            return;
        }

        $this->validate();

        $this->event->update([
            'name' => $this->name,
            'description' => $this->description,
            'location' => $this->location,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'capacity' => $this->capacity,
        ]);

        session()->flash('success', 'Event updated successfully!');
        
        // Redirect back to the index view after successful update
        return $this->redirect(route('church.events.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.church-admin-dashboard.event-programmes-edit');
           
    }
}