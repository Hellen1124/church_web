<?php



namespace App\Livewire\ChurchAdminDashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\SundayCollection;

class DashboardIndex extends Component
{
    public $tenant;

    public function mount()
    {
        // Get the authenticated user's tenant (church) instance
        $this->tenant = Auth::user()->tenant;
    }

    /**
     * Define real-time listeners for Sunday collections.
     * Assumes a 'SundayCollectionCreated' event is broadcast on the private church channel.
     */
    public function getListeners()
    {
        if (!$this->tenant) {
            return [];
        }
        
        return [
            // Listens for collection creation events for the current tenant
            "echo-private:church.{$this->tenant->id},SundayCollectionCreated" => '$refresh',
        ];
    }

    public function render()
    {
        if (!$this->tenant) {
            // Render a fallback view if the user is not linked to a tenant
            return <<<'blade'
                <div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                    <div class="text-center bg-white p-16 rounded-3xl shadow-2xl max-w-md">
                        <i class="fa fa-church text-9xl text-amber-600 mb-8"></i>
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">No Church Assigned</h2>
                        <p class="text-gray-600 text-lg">Your account is not linked to any church yet.</p>
                        <p class="text-sm text-gray-500 mt-6">Please contact the system administrator.</p>
                    </div>
                </div>
            blade;
        }

        $data = [
            // Member Statistics
            'totalMembers'       => $this->tenant->members()->count(),
            'newThisMonth'       => $this->tenant->members()
                                                ->whereMonth('created_at', now()->month)
                                                ->whereYear('created_at', now()->year)
                                                ->count(),

            // Collection Metrics (using SundayCollection model, total_amount, and collection_date)
            'totalOfferingToday' => $this->tenant->sundayCollections()
                                                ->whereDate('collection_date', today())
                                                ->sum('total_amount') ?? 0,

            'totalOfferingMonth' => $this->tenant->sundayCollections()
                                                ->whereMonth('collection_date', now()->month)
                                                ->whereYear('collection_date', now()->year)
                                                ->sum('total_amount') ?? 0,

            // Upcoming Events
            'upcomingEvents' => $this->tenant->events()
                                            ->where('start_at', '>=', now())
                                            ->orderBy('start_at', 'asc')
                                            ->take(5)
                                            ->get(),

            // Recent Collections (using SundayCollection model)
            'recentOfferings'    => $this->tenant->sundayCollections()
                                                ->latest('collection_date')
                                                ->take(5)
                                                ->get(),
        ];

        return view('livewire.church-admin-dashboard.dashboard-index', $data + [
            'tenant' => $this->tenant
        ]);
    }
}