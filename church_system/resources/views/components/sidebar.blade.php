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
<aside x-data="{ open: true }"
       class="fixed top-0 left-0 z-40 h-screen pt-16 bg-white/95 backdrop-blur-sm border-r border-amber-100 shadow-xl transition-all duration-300 flex flex-col"
       :class="open ? 'w-64' : 'w-20'">

    <!-- Header -->
    <div class="flex items-center justify-between px-5 py-5 border-b border-amber-100/80">
        <div class="flex items-center gap-3 overflow-hidden">
            <i data-lucide="church" class="w-9 h-9 text-amber-700"></i>

            <span x-show="open"
                  class="font-black text-lg text-amber-900 leading-tight truncate">
                {{ $isSuperAdmin ? 'System Admin' : ($user->church?->name ?? 'My Church') }}
            </span>
        </div>

        <button @click="open = !open"
                class="p-2 rounded-xl hover:bg-amber-100 transition">
            <i data-lucide="chevrons-left" x-show="open" class="w-5 h-5 text-amber-700"></i>
            <i data-lucide="chevrons-right" x-show="!open" class="w-5 h-5 text-amber-700"></i>
        </button>
    </div>

    <!-- Perfect scrolling -->
    <div class="flex-1 overflow-y-auto overflow-x-hidden scrollbar-thin scrollbar-thumb-amber-400 scrollbar-track-amber-50">
        <nav class="px-3 py-6">
            <ul class="space-y-8">

                <!-- CORE -->
                <li>
                    <p x-show="open"
                       class="text-[11px] font-bold tracking-widest uppercase text-amber-700/70 mb-3 px-2">
                        Core
                    </p>

                    @if($isSuperAdmin)
                        @include('partials.sidebar-link', ['route' => 'admin.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard', 'badge' => 'System'])
                    @else
                        @include('partials.sidebar-link', ['route' => 'church.dashboard', 'icon' => 'home', 'label' => 'Dashboard'])
                    @endif
                </li>

                @if(!$isSuperAdmin)
                    <!-- PEOPLE -->
                    <li>
                        <p x-show="open"
                           class="text-[11px] font-bold tracking-widest uppercase text-amber-700/70 mb-3 px-2 border-t border-amber-200 pt-6">
                            People & Membership
                        </p>

                        @include('partials.sidebar-link', ['route' => 'church.members.index',     'icon' => 'users-round', 'label' => 'Members'])
                        @include('partials.sidebar-link', ['route' => 'church.members.directory', 'icon' => 'book-user',   'label' => 'Directory'])
                    </li>

                    <!-- MINISTRIES -->
                    <li>
                        <p x-show="open"
                           class="text-[11px] font-bold tracking-widest uppercase text-amber-700/70 mb-3 px-2 border-t border-amber-200 pt-6">
                            Ministries
                        </p>

                        @include('partials.sidebar-link', ['route' => 'church.departments.index', 'icon' => 'building-2',      'label' => 'Departments'])
                        @include('partials.sidebar-link', ['route' => 'church.events.index',      'icon' => 'calendar-heart',  'label' => 'Events & Programs'])
                        @include('partials.sidebar-link', ['route' => 'church.attendance.index',  'icon' => 'calendar-check-2','label' => 'Attendance'])
                    </li>

                    <!-- FINANCE -->
                    @if($isChurchAdmin || $isTreasurer)
                    <li>
                        <p x-show="open"
                           class="text-[11px] font-bold tracking-widest uppercase text-emerald-700/80 mb-3 px-2 border-t border-emerald-200 pt-6">
                            Finance
                        </p>

                        <!-- SUNDAY COLLECTIONS -->
                        @include('partials.sidebar-link', [
                            'route' => 'church.offerings.index', 
                            'icon' => 'church',
                            'label' => 'Sunday Collections'
                        ])
                        
                        <!-- EXPENSES -->
                        @include('partials.sidebar-link', [
                            'route' => 'church.expenses.index',
                            'icon' => 'receipt',
                            'label' => 'Expenses'
                        ])
                        
                        <!-- EXPENSE CATEGORIES -->
                        @if($isChurchAdmin)
                        @include('partials.sidebar-link', [
                            'route' => 'church.expense-categories.index',
                            'icon' => 'tags',
                            'label' => 'Expense Categories'
                        ])
                        @endif
                        
                        <!-- FINANCIAL REPORTS -->
                        @include('partials.sidebar-link', [
                            'route' => 'church.financialreports.index',
                            'icon' => 'pie-chart',
                            'label' => 'Financial Reports'
                        ])
                    </li>
                    @endif

                    <!-- ADMIN -->
                    @if($isChurchAdmin)
                    <li>
                        <p x-show="open"
                           class="text-[11px] font-bold tracking-widest uppercase text-amber-700/70 mb-3 px-2 border-t border-amber-200 pt-6">
                            Administration
                        </p>

                        @include('partials.sidebar-link', ['route' => 'church.roles.index',      'icon' => 'shield',     'label' => 'Roles & Permissions'])
                        @include('partials.sidebar-link', ['route' => 'church.settings.general','icon' => 'settings',   'label' => 'Church Settings'])
                        @include('partials.sidebar-link', ['route' => 'church.users.index',      'icon' => 'user-cog',  'label' => 'Manage Users'])
                    </li>
                    @endif
                @endif

                <!-- SUPER ADMIN ZONE -->
                @if($isSuperAdmin)
                <li class="border-t-4 border-rose-400 bg-rose-50/60 rounded-xl -mx-3 px-5 pt-8 pb-2 shadow-inner">
                    <p x-show="open"
                       class="text-[11px] font-black tracking-widest uppercase text-rose-700 mb-4">
                        Super Admin Zone
                    </p>

                    @include('partials.sidebar-link', ['route' => 'system-admin.users.index',       'icon' => 'users-cog',     'label' => 'All Users',        'badge' => 'Tenants'])
                    @include('partials.sidebar-link', ['route' => 'system-admin.rolemanager.index', 'icon' => 'shield-alert',  'label' => 'Roles Manager',    'badge' => 'Dev'])
                    @include('partials.sidebar-link', ['route' => 'system-admin.church.index',      'icon' => 'church',        'label' => 'Churches',         'badge' => 'Multi-Tenant'])
                    @include('partials.sidebar-link', ['route' => 'super-admin.action-center',      'icon' => 'zap',           'label' => 'Action Center',    'badge' => 'Backup • Migrate'])
                </li>
                @endif

                <!-- ACCOUNT -->
                <li class="mt-8 border-t-2 border-amber-300 pt-8">
                    <p x-show="open"
                       class="text-[11px] font-bold tracking-widest uppercase text-amber-700/70 mb-3 px-2">
                        Account
                    </p>

                    @include('partials.sidebar-link', ['route' => 'profile.edit', 'icon' => 'user-circle', 'label' => 'Profile Settings'])

                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-4 px-4 py-3.5 rounded-xl text-rose-700 hover:bg-rose-100 transition font-semibold">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                            <span x-show="open">Logout</span>
                        </button>
                    </form>

                    @if($isSuperAdmin)
                        <div x-show="open"
                             class="mt-6 text-center text-[11px] font-black text-rose-700 bg-rose-100 py-2.5 rounded-xl animate-pulse">
                             ROOT ACCESS ACTIVE
                        </div>
                    @endif
                </li>
            </ul>
        </nav>
    </div>
</aside>
@endif


