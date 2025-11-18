<div class="p-6 font-sans bg-gradient-to-br from-amber-50 via-white to-gray-100 min-h-screen">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between border-b border-gray-300 pb-5 mb-8">
        <div class="flex items-center gap-4">
            <i data-lucide="layout" class="w-10 h-10 text-amber-600"></i>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Super Admin Dashboard</h1>
                <p class="text-sm text-gray-600">Monitor tenants, users, and system operations.</p>
            </div>
        </div>

        <div class="flex gap-3 mt-4 md:mt-0">
            <!-- Dev Tools Button -->
            <button type="button" wire:click="openDeveloperSettings"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition text-sm font-medium shadow-sm">
                <i data-lucide="terminal" class="w-5 h-5"></i> Dev Tools
            </button>

            <!-- Sync Data Button -->
            <button type="button" wire:click="syncData" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition text-sm font-medium shadow-sm disabled:opacity-50">
                <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                <span wire:loading.remove>Sync Data</span>
                <span wire:loading>Syncing...</span>
            </button>
        </div>
    </div>

    {{-- SYSTEM HEALTH --}}
<div class="flex items-center justify-between border-b border-gray-300 pb-4 mb-8">
    <div class="flex items-center gap-3">
        
        {{-- BLINKING DOT --}}
        <div class="relative">
            <div class="w-3 h-3 bg-emerald-500 rounded-full animate-ping absolute"></div>
            <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
        </div>

        {{-- STATUS BADGE --}}
        <x-badge
            :label="$systemHealthStatus"
            :color="str_contains(strtolower($systemHealthStatus), 'ok') ? 'success' : 'error'"
            squared
        />
        
        <span class="text-gray-700 text-sm font-medium">System Status</span>
    </div>

    <span class="text-xs text-gray-500">Last updated: 2 minutes ago</span>
</div>

    {{-- DASHBOARD METRICS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
        <div class="p-6 bg-white/70 backdrop-blur-sm border border-amber-200 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-3">
                <div class="p-3 bg-amber-100 rounded-full">
                    <i data-lucide="building" class="w-7 h-7 text-amber-600"></i>
                </div>
                <x-badge flat positive label="+3.4%" class="text-xs font-semibold" />
            </div>
            <p class="text-sm font-medium text-gray-700">Total Tenants</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($tenantsCount) }}</p>
        </div>

        <div class="p-6 bg-white/70 backdrop-blur-sm border border-emerald-200 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-3">
                <div class="p-3 bg-emerald-100 rounded-full">
                    <i data-lucide="user-check" class="w-7 h-7 text-emerald-600"></i>
                </div>
                <x-badge flat positive label="0.2%" class="text-xs font-semibold" />
            </div>
            <p class="text-sm font-medium text-gray-700">Active Tenants</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($activeTenants) }}</p>
        </div>

        <div class="p-6 bg-white/70 backdrop-blur-sm border border-red-200 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-3">
                <div class="p-3 bg-red-100 rounded-full">
                    <i data-lucide="user-x" class="w-7 h-7 text-red-600"></i>
                </div>
                <x-badge flat negative label="1.5%" class="text-xs font-semibold" />
            </div>
            <p class="text-sm font-medium text-gray-700">Inactive Tenants</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($inactiveTenants) }}</p>
        </div>

        <div class="p-6 bg-white/70 backdrop-blur-sm border border-indigo-200 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-3">
                <div class="p-3 bg-indigo-100 rounded-full">
                    <i data-lucide="users" class="w-7 h-7 text-indigo-600"></i>
                </div>
                <x-badge flat positive label="+8.1%" class="text-xs font-semibold" />
            </div>
            <p class="text-sm font-medium text-gray-700">Total Users</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($totalUsers) }}</p>
        </div>
    </div>

   {{-- SYSTEM VITALS --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">

    <!-- Total Members -->
    <div class="p-6 bg-white/70 backdrop-blur-sm border border-blue-200 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between mb-3">
            <div class="p-3 bg-blue-100 rounded-full">
                <i data-lucide="user" class="w-7 h-7 text-blue-600"></i>
            </div>
        </div>
        <p class="text-sm font-medium text-gray-700">Total Members</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($totalMembers) }}</p>
    </div>

    <!-- System Uptime -->
    <div class="p-6 bg-white/70 backdrop-blur-sm border border-teal-200 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between mb-3">
            <div class="p-3 bg-teal-100 rounded-full">
                <i data-lucide="clock" class="w-7 h-7 text-teal-600"></i>
            </div>
        </div>
        <p class="text-sm font-medium text-gray-700">System Uptime</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $systemUptime }}</p>
    </div>

    <!-- Last Backup -->
    <div class="p-6 bg-white/70 backdrop-blur-sm border border-purple-200 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between mb-3">
            <div class="p-3 bg-purple-100 rounded-full">
                <i data-lucide="database" class="w-7 h-7 text-purple-600"></i>
            </div>
        </div>
        <p class="text-sm font-medium text-gray-700">Last Backup</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $lastBackup }}</p>
    </div>

    <!-- Pending Migrations (Special Red Style) -->
    <div class="p-6 bg-red-50/80 backdrop-blur-sm border border-red-300 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
         :class="$pendingMigrations > 0 ? 'animate-pulse' : ''">
        <div class="flex items-center justify-between mb-3">
            <div class="p-3 bg-red-100 rounded-full">
                <i data-lucide="alert-triangle" class="w-7 h-7 text-red-600"></i>
            </div>
        </div>
        <p class="text-sm font-medium text-red-700">Pending Migrations</p>
        <p class="text-3xl font-extrabold text-red-700 mt-1">{{ $pendingMigrations }}</p>
    </div>

</div>

    {{-- CHARTS --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <div class="bg-white/70 backdrop-blur-sm border border-gray-300 rounded-xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tenant Growth (Last 12 Months)</h3>
            <div x-data x-init="new ApexCharts($refs.tenantChart, { chart: { type: 'area', height: 280, toolbar: { show: false } }, colors: ['#f59e0b'], series: [{ name: 'New Tenants', data: @js($tenantGrowthData) }], xaxis: { categories: @js($tenantGrowthLabels) }, stroke: { curve: 'smooth', width: 2 } }).render();">
                <div x-ref="tenantChart"></div>
            </div>
        </div>

        <div class="bg-white/70 backdrop-blur-sm border border-gray-300 rounded-xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Weekly User Logins</h3>
            <div x-data x-init="new ApexCharts($refs.loginChart, { chart: { type: 'bar', height: 280, toolbar: { show: false } }, colors: ['#ea580c'], plotOptions: { bar: { borderRadius: 6, columnWidth: '60%' } }, series: [{ name: 'Logins', data: @js($userActivityData) }], xaxis: { categories: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] } }).render();">
                <div x-ref="loginChart"></div>
            </div>
        </div>
    </div>

    {{-- ACTION CENTER --}}
    <div x-data="{ open: false }" class="mt-10 border border-amber-300 rounded-xl bg-white/60 backdrop-blur-sm shadow-md">
        <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-3 text-left text-gray-800 font-semibold hover:bg-amber-50/50 rounded-t-xl transition">
            <div class="flex items-center gap-2">
                <i data-lucide="settings" class="w-5 h-5 text-amber-600"></i>
                <span>Action Center</span>
            </div>
            <i data-lucide="chevron-down" class="w-5 h-5 text-gray-600 transition" x-bind:class="{ 'rotate-180': open }"></i>
        </button>

        <div x-show="open" x-collapse class="p-5 border-t border-amber-200 flex flex-wrap gap-3">
            <button type="button" wire:click="runMigrations"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                <i data-lucide="database" class="w-5 h-5"></i> Run Migrations
            </button>

            <button type="button" wire:click="runBackup"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition text-sm font-medium">
                <i data-lucide="save" class="w-5 h-5"></i> Run Backup
            </button>

            <button type="button" wire:click="clearCache"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-medium">
                <i data-lucide="trash-2" class="w-5 h-5"></i> Clear Cache
            </button>
        </div>
    </div>

    @if ($devOutput)
        <div class="mt-8 bg-gray-900/90 backdrop-blur-sm text-green-400 font-mono text-xs rounded-xl p-5 border border-gray-700">
            <h4 class="text-white font-bold mb-2 border-b border-gray-600 pb-1">Developer Output Log</h4>
            <pre class="whitespace-pre-wrap text-xs">{{ $devOutput }}</pre>
        </div>
    @endif

</div>

@push('scripts')
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script>
    function initLucide() {
        if (window.lucide) lucide.createIcons();
    }
    document.addEventListener('DOMContentLoaded', initLucide);
    document.addEventListener('livewire:load', initLucide);
    document.addEventListener('livewire:update', initLucide);
</script>
@endpush

