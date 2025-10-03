<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
class Home extends Component
{
    public $stats = [];
    public $events = [];
    public $activities = [];

    public function mount()
    {
        // ===== Stats Data =====
        $membersCount        = \App\Models\Member::count();
        $donationsThisMonth  = \App\Models\Donation::whereMonth('created_at', now()->month)->sum('amount');
        $upcomingEventsCount = \App\Models\Event::where('date', '>=', now())->count();
        $volunteersCount     = \App\Models\Volunteer::count();

        $this->stats = [
            [
                'title' => 'Members',
                'value' => $membersCount,
                'color' => 'text-blue-600',
                'note'  => 'Total registered members',
            ],
            [
                'title' => 'Donations',
                'value' => '$' . number_format($donationsThisMonth, 2),
                'color' => 'text-green-600',
                'note'  => 'This month',
            ],
            [
                'title' => 'Upcoming Events',
                'value' => $upcomingEventsCount,
                'color' => 'text-purple-600',
                'note'  => 'Scheduled this month',
            ],
            [
                'title' => 'Volunteers',
                'value' => $volunteersCount,
                'color' => 'text-orange-600',
                'note'  => 'Active helpers',
            ],
        ];

        // ===== Events Data =====
        $this->events = \App\Models\Event::where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->take(5)
            ->get()
            ->toArray(); // array for partial dynamic fields

         // ===== Activities Data =====
            $this->activities = \App\Models\Activity::latest()
        ->take(5)
        ->get()
        ->toArray(); // convert to array for consistency
    }

    public function render()
    {
        return view('livewire.dashboard.home');
    }
}


   

