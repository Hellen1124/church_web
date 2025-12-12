<?php

namespace App\Livewire\ChurchAdminDashboard;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use illuminate\support\str;
use Livewire\WithPagination;


class EventProgrammesCreate extends Component
{

     // The Event instance being edited (null for creation)
    public ?Event $event = null;
    
    // Properties to bind to the form fields
    public $name = '';
    public $description = '';
    public $location = '';
    public $start_at;
    public $end_at;
    public $capacity = null;
    public $is_public = true;

    // Validation rules matching the model fields
    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'location' => 'required|string|max:255',
        'start_at' => 'required|date',
        'end_at' => 'required|date|after_or_equal:start_at',
        'capacity' => 'nullable|integer|min:1',
        'is_public' => 'required|boolean',
    ];

    /**
     * Initialize the component, checking for an existing event to edit.
     * Use dependency injection for optional Event model binding.
     */
    public function mount(Event $event = null)
    {
        // If an event is passed and exists, we are in Edit mode
        if ($event && $event->exists) {
            $this->event = $event;
            $this->name = $event->name;
            $this->description = $event->description;
            $this->location = $event->location;
            // Format dates for input fields (datetime-local format: YYYY-MM-DDTHH:MM)
            $this->start_at = $event->start_at->format('Y-m-d\TH:i');
            $this->end_at = $event->end_at->format('Y-m-d\TH:i');
            $this->capacity = $event->capacity;
            $this->is_public = $event->is_public;
        } else {
            // Default to creation state
            $this->event = new Event();
            // Default start_at to 1 hour from now, and end_at to 2 hours from now
            $this->start_at = now()->addHour()->format('Y-m-d\TH:i');
            $this->end_at = now()->addHours(2)->format('Y-m-d\TH:i');
        }
    }

    /**
     * Handles saving the event data (Create or Update).
     */
    public function save()
    {
        $this->validate();

        // Prepare common data
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'location' => $this->location,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'capacity' => $this->capacity,
            'is_public' => $this->is_public,
        ];

        if ($this->event->exists) {
            // Update existing event
            $this->event->update($data);
            session()->flash('success', 'Event updated successfully!');
        } else {
            // Create new event
            $data['tenant_id'] = Auth::user()->tenant_id;
            $data['slug'] = Str::slug($this->name . '-' . time()); // Unique slug generation
            $event = Event::create($data);
            
            session()->flash('success', 'Event created successfully!');
            
            // Redirect to the new event's detail page after creation
            return $this->redirect(route('church.events.index', $event->slug), navigate: true);
        }

        // Redirect to the index page after update
        $this->redirect(route('church.events.index'), navigate: true);
    }
    
    public function render()
    {
        return view('livewire.church-admin-dashboard.event-programmes-create');
    }
}
