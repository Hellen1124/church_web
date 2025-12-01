<?php

namespace App\Livewire\ChurchAdminDashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DashboardIndex extends Component
{
    public $tenant;

    public function mount()
    {
        // This works because you already have: public function tenant() in User model
        $this->tenant = Auth::user()->tenant;

        // Optional debug (remove later)
        // dd(Auth::user()->tenant_id, $this->tenant?->church_name);
    }

    public function render()
    {
        if (!$this->tenant) {
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
            'totalMembers'       => $this->tenant->members()->count(),
            'newThisMonth'       => $this->tenant->members()
                                        ->whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count(),

            'totalOfferingToday' => $this->tenant->offerings()
                                        ->whereDate('created_at', today())
                                        ->sum('amount') ?? 0,

            'totalOfferingMonth' => $this->tenant->offerings()
                                        ->whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->sum('amount') ?? 0,

            'upcomingEvents' => $this->tenant->events()
                                ->where('start_at', '>=', now())    // ← CHANGED
                                ->orderBy('start_at', 'asc')        // ← CHANGED
                                ->take(5)
                                ->get(),

            'recentOfferings'    => $this->tenant->offerings()
                                        ->with('member')
                                        ->latest()
                                        ->take(5)
                                        ->get(),
        ];

        return view('livewire.church-admin-dashboard.dashboard-index', $data + [
            'tenant' => $this->tenant
        ]);
    }
}
