@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
    if (!$user) return;

    $allowedRoles = ['super-admin', 'church-admin', 'church-lead', 'church-treasurer'];
    $hasAllowedRole = $user->hasAnyRole($allowedRoles);

    $isSuperAdmin   = $user->hasRole('super-admin');
    $isChurchAdmin  = $user->hasRole('church-admin');
    $isTreasurer    = $user->hasRole('church-treasurer');
@endphp

@if($hasAllowedRole)
<aside 
    x-data="{ open: true, devOpen: false }" 
    class="fixed top-0 left-0 z-40 h-screen w-64 pt-16 bg-gradient-to-b from-amber-50 via-stone-50 to-stone-100 
           border-r border-amber-100 shadow-lg transition-all duration-300 ease-in-out"
    :class="open ? 'w-64' : 'w-20'"
>
    <div class="flex flex-col h-full">

        <!-- Header -->
        <div class="flex items-center justify-between px-5 py-4 border-b border-amber-100">
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l3.5 6h5.5l-4.5 4 1.5 6.5-5.5-3.5-5.5 3.5 1.5-6.5-4.5-4h5.5z"/>
                </svg>
                <span x-show="open" class="font-bold text-amber-900 text-lg truncate">
                    {{ $isSuperAdmin ? 'System Admin' : ($user->church?->name ?? 'My Church') }}
                </span>
            </div>
            <button @click="open = !open" class="p-2 rounded-full hover:bg-amber-100 transition">
                <svg x-show="open" class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <svg x-show="!open" class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-8 overflow-y-auto">

            <!-- Core -->
            <div>
                <p x-show="open" class="text-xs font-bold uppercase text-amber-700 mb-3 px-2">Core</p>
                @if($isSuperAdmin)
                    @include('partials.sidebar-link', ['route' => 'admin.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard', 'badge' => 'System Wide', 'badgeColor' => 'bg-red-100 text-red-800'])
                @else
                    @include('partials.sidebar-link', ['route' => 'church.dashboard', 'icon' => 'home', 'label' => 'Dashboard', 'badge' => 'My Church', 'badgeColor' => 'bg-amber-100 text-amber-800'])
                @endif
            </div>

            @if(!$isSuperAdmin)
                <div>
                    <p x-show="open" class="text-xs font-bold uppercase text-amber-700 mb-3 px-2 border-t border-amber-200 pt-6">People & Membership</p>
                    @include('partials.sidebar-link', ['route' => 'church.members.index',        'icon' => 'users-round',      'label' => 'Members'])
                    @include('partials.sidebar-link', ['route' => 'church.members.directory',   'icon' => 'book-user',        'label' => 'Directory'])
                </div>

                <div>
                    <p x-show="open" class="text-xs font-bold uppercase text-amber-700 mb-3 px-2 border-t border-amber-200 pt-6">Ministries</p>
                    @include('partials.sidebar-link', ['route' => 'church.departments.index',   'icon' => 'building-2',       'label' => 'Departments'])
                    @include('partials.sidebar-link', ['route' => 'church.events.index',        'icon' => 'calendar-heart',   'label' => 'Events & Programs'])
                    @include('partials.sidebar-link', ['route' => 'church.attendance.index',    'icon' => 'calendar-check-2', 'label' => 'Attendance'])
                </div>

                @if($isChurchAdmin || $isTreasurer)
                    <div>
                        <p x-show="open" class="text-xs font-bold uppercase text-emerald-700 mb-3 px-2 border-t border-emerald-200 pt-6">Finance</p>
                        @include('partials.sidebar-link', ['route' => 'church.offerings.index', 'icon' => 'hand-coins',      'label' => 'Offerings & Tithes'])
                        @include('partials.sidebar-link', ['route' => 'church.expenses.index',  'icon' => 'receipt',         'label' => 'Expenses'])
                        @include('partials.sidebar-link', ['route' => 'church.finance.reports','icon' => 'file-spreadsheet','label' => 'Financial Reports'])
                    </div>
                @endif

                @if($isChurchAdmin)
                    <div>
                        <p x-show="open" class="text-xs font-bold uppercase text-amber-700 mb-3 px-2 border-t border-amber-200 pt-6">Administration</p>
                        @include('partials.sidebar-link', ['route' => 'church.roles.index',    'icon' => 'shield',         'label' => 'Roles & Permissions'])
                        @include('partials.sidebar-link', ['route' => 'church.settings.general','icon' => 'settings',       'label' => 'Church Settings'])
                        @include('partials.sidebar-link', ['route' => 'church.users.index',     'icon' => 'users-cog',      'label' => 'Manage Users'])
                    </div>
                @endif
            @endif

            @if($isSuperAdmin)
                <div class="mt-8 pt-8 border-t-4 border-rose-300 bg-rose-50/40 rounded-2xl">
                    <p x-show="open" class="text-xs font-black uppercase text-rose-700 mb-5 px-4">Super Admin Zone</p>
                    @include('partials.sidebar-link', ['route' => 'system-admin.users.index',       'icon' => 'users-cog',     'label' => 'All Users',     'badge' => 'Tenants',     'badgeColor' => 'bg-emerald-100 text-emerald-800'])
                    @include('partials.sidebar-link', ['route' => 'system-admin.rolemanager.index', 'icon' => 'shield-alert',  'label' => 'Roles Manager', 'badge' => 'Dev',         'badgeColor' => 'bg-rose-100 text-rose-800'])
                    @include('partials.sidebar-link', ['route' => 'system-admin.church.index',      'icon' => 'church',        'label' => 'Churches',      'badge' => 'Multi-Tenant', 'badgeColor' => 'bg-amber-100 text-amber-800'])
                    @include('partials.sidebar-link', ['route' => 'super-admin.action-center',      'icon' => 'zap',           'label' => 'Action Center', 'badge' => 'Backup • Migrate', 'badgeColor' => 'bg-orange-100 text-orange-800'])
                </div>
            @endif
        </nav>

        <!-- Account -->
        <div class="border-t border-amber-200 bg-gradient-to-t from-amber-50 to-transparent px-4 py-6">
            <p x-show="open" class="text-xs font-bold uppercase text-amber-700 mb-4 px-2">Account</p>
            @include('partials.sidebar-link', ['route' => 'profile.edit', 'icon' => 'user-circle', 'label' => 'Profile Settings'])

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full flex items-center gap-4 px-4 py-3.5 text-rose-700 hover:bg-rose-50 rounded-xl transition font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span x-show="open">Logout</span>
                </button>
            </form>

            @if($isSuperAdmin)
                <div x-show="open" class="mt-5 text-center text-xs font-bold text-rose-700 bg-rose-100 py-2 rounded-lg animate-pulse">
                    ROOT ACCESS ACTIVE
                </div>
            @endif
        </div>
    </div>
</aside>
@endif