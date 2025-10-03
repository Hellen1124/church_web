
<div class="p-6 space-y-6">
    <!-- Navbar -->
    @include('livewire.dashboard.partials.nav-bar')

    <!-- Stats Cards -->
    @include('livewire.dashboard.partials.stats-cards', [
        'stats' => $stats
    ])

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Upcoming Events -->
        @include('livewire.dashboard.partials.upcoming-events', [
            'title'        => 'Upcoming Events',
            'items'        => $events,
            'labelField'   => 'title',
            'dateField'    => 'date',
            'idField'      => 'id',
            'routeName'    => 'events.show',
            'emptyMessage' => 'No upcoming events.',
        ])

        <!-- Recent Activities -->
        @include('livewire.dashboard.partials.recent-activities', [
            'title'        => 'Recent Activities',
            'activities'   => $activities,
            'emptyMessage' => 'No recent activity recorded.',
        ])
    </div>
</div>
