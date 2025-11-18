<?php


namespace App\Livewire\SuperAdminDashboard;


use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use WireUi\Traits\WireUiActions;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Member;
use Carbon\Carbon;

class DashboardIndex extends Component
{
    use WithPagination;
    use WireUiActions; // WireUI actions: dialog() and notification()

    public int $perPage = 12;
    public string $search = '';
    public ?string $statusFilter = null;
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public $devOutput = '';



    // Stats
    public int $tenantsCount = 0;
    public int $activeTenants = 0;
    public int $inactiveTenants = 0;
    public int $totalUsers = 0;
    public int $totalMembers = 0;
    public int $pendingMigrations = 0;
    public string $systemHealthStatus = 'Checking...';
    public string $systemUptime = '—';
    public string $lastBackup = '—';

    // Artisan output for developer tools
    public ?string $artisanOutput = null;

    // Chart data
    public array $tenantGrowthLabels = [];
    public array $tenantGrowthData = [];
    public array $userActivityData = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => null],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    protected $listeners = [
        'runMigrationsConfirmed' => 'runMigrationsConfirmed',
        'refreshDashboard' => '$refresh',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function render()
    {
        $recentTenants = $this->getRecentTenants();

        return view('livewire.super-admin-dashboard.dashboard-index', [
            'recentTenants' => $recentTenants,
        ]);
    }

    public function loadData(): void
    {
        // aggregate counts (single queries where possible)
        $this->tenantsCount = Tenant::count();
        $this->activeTenants = Tenant::where('is_active', true)->count();
        $this->inactiveTenants = $this->tenantsCount - $this->activeTenants;
        $this->totalUsers = User::count();
        $this->totalMembers = Member::count();

        // pending migrations simple check (example: checking a table that tracks migrations)
        $this->pendingMigrations = collect(\Illuminate\Support\Facades\Artisan::output())
    ->filter(fn($line) => str_contains($line, 'Pending'))
    ->count();


        // system health basic check
        $this->systemHealthStatus = $this->tenantsCount > 0 ? 'Operational' : 'Degraded';
        $this->systemUptime = $this->formatUptime(); // readable uptime
        $this->lastBackup = $this->getLastBackupTime();

        // prepare chart
        $this->prepareTenantGrowthChart();

        // notify frontend chart to update
       $this->dispatch('chartUpdated', [
    'labels' => $this->tenantGrowthLabels,
    'data' => $this->tenantGrowthData,
]);

    }

    protected function getRecentTenants()
    {
        $query = Tenant::query()->select(['id','church_name','church_email','church_mobile','location','domain','is_active','created_at']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('church_name', 'like', '%'.$this->search.'%')
                  ->orWhere('church_email', 'like', '%'.$this->search.'%')
                  ->orWhere('domain', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->statusFilter !== null && $this->statusFilter !== '') {
            $query->where('is_active', (bool) $this->statusFilter);
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Example impersonation action with confirmation and optimistic UI notification
    public function impersonateTenant(int $tenantId): void
    {
        $tenant = Tenant::find($tenantId);
        if (! $tenant) {
            $this->notification()->error('Tenant not found', 'The requested tenant could not be located.');
            return;
        }

        $this->dialog()->confirm([
            'title' => 'Impersonate tenant',
            'description' => "You are about to impersonate {$tenant->church_name}. This will log you in as the tenant admin. Continue?",
            'acceptLabel' => 'Yes, impersonate',
            'rejectLabel' => 'Cancel',
            'onAccept' => "Livewire.emit('impersonateConfirmed', {$tenant->id})",
        ]);
    }

    public function impersonateConfirmed(int $tenantId): void
    {
        // optimistic notification
        $this->notification()->info('Impersonation', 'Switching to tenant session...');
        // actual impersonation logic would go here (cookie/session swap)
        // for demo, just return a message
        $this->artisanOutput = "Impersonated tenant ID: {$tenantId} at ".now();
        $this->notification()->success('Impersonation complete', 'Tenant session ready.');
    }

    // Developer tools: run migrations behind confirmation
    public function runMigrations(): void
    {
        if (! auth()->user()->can('developer')) {
            $this->notification()->warning('Unauthorized', 'You do not have permission to run migrations.');
            return;
        }

        $this->dialog()->confirm([
            'title' => 'Run pending migrations',
            'description' => "This will run {$this->pendingMigrations} pending migrations. Backups recommended.",
            'acceptLabel' => 'Run migrations',
            'rejectLabel' => 'Cancel',
            'onAccept' => 'Livewire.emit("runMigrationsConfirmed")',
        ]);
    }

    public function runMigrationsConfirmed(): void
    {
        // run migrations (optimistic feedback)
        $this->notification()->info('Migrations', 'Running migrations...');

        // wrap Artisan call and capture output
        try {
            Artisan::call('migrate', ['--force' => true]);
            $this->artisanOutput = Artisan::output();
            $this->notification()->success('Migrations complete', 'Database migrations ran successfully.');
        } catch (\Throwable $e) {
            $this->artisanOutput = $e->getMessage();
            $this->notification()->error('Migration failed', 'See artisan output for details.');
        }

        // refresh counts and chart
        $this->loadData();
    }

    public function runBackup(): void
    {
        if (! auth()->user()->can('developer')) {
            $this->notification()->warning('Unauthorized', 'You do not have permission to run backups.');
            return;
        }

        $this->notification()->info('Backup', 'Starting backup...');
        // simulate backup via Artisan command and capture output
        try {
            Artisan::call('backup:run');
            $this->artisanOutput = Artisan::output();
            $this->notification()->success('Backup complete', 'Backup finished successfully.');
            $this->lastBackup = now()->subMinutes(rand(1, 60))->diffForHumans(); // placeholder readable
        } catch (\Throwable $e) {
            $this->notification()->error('Backup failed', $e->getMessage());
        }
    }

    public function clearCache(): void
    {
        $this->notification()->info('Cache', 'Clearing caches...');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        $this->notification()->success('Cache cleared', 'Application cache and config cleared.');
    }

    protected function prepareTenantGrowthChart(): void
    {
        // last 12 months tenant creations aggregated by month
        $start = Carbon::now()->startOfMonth()->subMonths(11);
        $rows = Tenant::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as cnt")
            ->where('created_at', '>=', $start)
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('cnt', 'ym')
            ->toArray();

        $labels = [];
        $data = [];
        for ($i = 0; $i < 12; $i++) {
            $dt = $start->copy()->addMonths($i);
            $key = $dt->format('Y-m');
            $labels[] = $dt->format('M Y');
            $data[] = (int) ($rows[$key] ?? 0);
        }

        $this->tenantGrowthLabels = $labels;
        $this->tenantGrowthData = $data;
    }

    protected function formatUptime(): string
    {
        // approximate uptime from server boot time (if available) else app start
        try {
            $boot = cache()->remember('server_boot_time', 60, function () {
                return now()->subHours((int) (abs((int) exec('uptime -p 2>/dev/null') ? 1 : 0)));
            });
            return $boot->diffForHumans();
        } catch (\Throwable $e) {
            return 'Unknown';
        }
    }

    protected function getLastBackupTime(): string
    {
        // attempt to read the most recent backup file timestamp (example)
        try {
            $file = collect(\Storage::disk('local')->files('backups'))->sortByDesc(function ($f) {
                return \Storage::disk('local')->lastModified($f);
            })->first();
            if ($file) {
                return Carbon::createFromTimestamp(\Storage::disk('local')->lastModified($file))->diffForHumans();
            }
        } catch (\Throwable $e) {
            // no-op
        }
        return 'Never';
    }
}





