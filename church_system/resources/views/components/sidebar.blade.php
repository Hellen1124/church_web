@php
    use Illuminate\Support\Facades\Auth;
    
    $user = Auth::user();
    if (!$user) return;

    // Define role-based access
    $allowedRoles = ['super-admin', 'church-admin', 'church-lead', 'church-treasurer'];
    $hasAllowedRole = $user->hasAnyRole($allowedRoles);
    
    // Role checks
    $isSuperAdmin = $user->hasRole('super-admin');
    $isChurchAdmin = $user->hasRole('church-admin');
    $isTreasurer = $user->hasRole('church-treasurer');
    $isChurchLead = $user->hasRole('church-lead');

    // Determine dashboard based on role
    $dashboardRoute = match(true) {
        $isSuperAdmin => 'admin.dashboard',
        $isTreasurer => 'finance.dashboard',
        $isChurchLead => 'church-lead.dashboard',
        $isChurchAdmin => 'church.dashboard',
        default => 'dashboard'
    };

    $dashboardLabel = match(true) {
        $isSuperAdmin => 'System Dashboard',
        $isTreasurer => 'Finance Dashboard',
        $isChurchLead => 'Leadership Dashboard',
        default => 'Dashboard'
    };
@endphp

@if($hasAllowedRole)
<aside x-data="{ open: true }"
       class="fixed top-0 left-0 z-40 h-screen pt-16 bg-white/95 backdrop-blur-sm border-r border-amber-100 shadow-xl transition-all duration-300 flex flex-col"
       :class="open ? 'w-64' : 'w-20'">

    <!-- Sidebar Header -->
    <div class="flex items-center justify-between px-5 py-5 border-b border-amber-100/80">
        <div class="flex items-center gap-3 overflow-hidden">
            <i data-lucide="church" class="w-9 h-9 text-amber-700 flex-shrink-0"></i>

            <span x-show="open"
                  class="font-black text-lg text-amber-900 leading-tight truncate transition-opacity duration-300">
                @if($isSuperAdmin)
                    System Admin
                @else
                    {{ $user->church?->name ?? 'My Church' }}
                @endif
            </span>
        </div>

        <button @click="open = !open"
                class="p-2 rounded-xl hover:bg-amber-100 transition-all duration-300"
                aria-label="Toggle sidebar">
            <i data-lucide="chevrons-left" x-show="open" class="w-5 h-5 text-amber-700"></i>
            <i data-lucide="chevrons-right" x-show="!open" class="w-5 h-5 text-amber-700"></i>
        </button>
    </div>

    <!-- Navigation Content -->
    <div class="flex-1 overflow-y-auto overflow-x-hidden scrollbar-thin scrollbar-thumb-amber-400 scrollbar-track-amber-50">
        <nav class="px-3 py-6">
            <ul class="space-y-8">

                <!-- CORE SECTION -->
                <li>
                    <p x-show="open"
                       class="text-[11px] font-bold tracking-widest uppercase text-amber-700/70 mb-3 px-2">
                        Core
                    </p>
                    
                    @include('partials.sidebar-link', [
                        'route' => $dashboardRoute,
                        'icon' => 'layout-dashboard',
                        'label' => $dashboardLabel,
                        'badge' => $isSuperAdmin ? 'System' : ($isTreasurer ? 'Finance' : null)
                    ])
                </li>

                <!-- NON-SUPER ADMIN SECTIONS -->
                @if(!$isSuperAdmin)
                    <!-- FINANCE SECTION -->
                    @if($isChurchAdmin || $isTreasurer)
                    <li>
                        <p x-show="open"
                           class="text-[11px] font-bold tracking-widest uppercase text-emerald-700/80 mb-3 px-2 border-t border-emerald-200 pt-6">
                            Finance
                        </p>

                        <!-- Finance Links -->
                        @include('partials.sidebar-link', [
                            'route' => 'finance.collections.index', 
                            'icon' => 'banknote',
                            'label' => 'Sunday Collections'
                        ])
                        
                        @include('partials.sidebar-link', [
                            'route' => 'finance.expenses.index',
                            'icon' => 'receipt',
                            'label' => 'Expenses'
                        ])
                        
                        @if($isChurchAdmin)
                            @include('partials.sidebar-link', [
                                'route' => 'church.expense-categories.index',
                                'icon' => 'tags',
                                'label' => 'Expense Categories'
                            ])
                        @endif
                        
                        @include('partials.sidebar-link', [
                            'route' => 'church.financialreports.index',
                            'icon' => 'pie-chart',
                            'label' => 'Financial Reports'
                        ])
                    </li>
                    @endif

                    <!-- ADMINISTRATION SECTION (Church Admin Only) -->
                    @if($isChurchAdmin)
                    <li>
                        <p x-show="open"
                           class="text-[11px] font-bold tracking-widest uppercase text-blue-700/80 mb-3 px-2 border-t border-blue-200 pt-6">
                            Administration
                        </p>

                        @include('partials.sidebar-link', [
                            'route' => 'church.roles.index',
                            'icon' => 'shield',
                            'label' => 'Roles & Permissions'
                        ])
                        
                        @include('partials.sidebar-link', [
                            'route' => 'church.settings.general',
                            'icon' => 'settings',
                            'label' => 'Church Settings'
                        ])
                        
                        @include('partials.sidebar-link', [
                            'route' => 'church.users.index',
                            'icon' => 'user-cog',
                            'label' => 'Manage Users'
                        ])
                    </li>
                    
                    <!-- PEOPLE SECTION (Non-Treasurer Roles) -->
                    @if(!$isTreasurer)
                    <li>
                        <p x-show="open"
                           class="text-[11px] font-bold tracking-widest uppercase text-purple-700/80 mb-3 px-2 border-t border-purple-200 pt-6">
                            People & Membership
                        </p>

                        @include('partials.sidebar-link', [
                            'route' => 'church.members.index',
                            'icon' => 'users-round',
                            'label' => 'Members'
                        ])
                        
                        @include('partials.sidebar-link', [
                            'route' => 'church.members.directory',
                            'icon' => 'book-user',
                            'label' => 'Directory'
                        ])
                    </li>

                    <!-- MINISTRIES SECTION (Non-Treasurer Roles) -->
                    <li>
                        <p x-show="open"
                           class="text-[11px] font-bold tracking-widest uppercase text-indigo-700/80 mb-3 px-2 border-t border-indigo-200 pt-6">
                            Ministries
                        </p>

                        @include('partials.sidebar-link', [
                            'route' => 'church.departments.index',
                            'icon' => 'building-2',
                            'label' => 'Departments'
                        ])
                        
                        @include('partials.sidebar-link', [
                            'route' => 'church.events.index',
                            'icon' => 'calendar-heart',
                            'label' => 'Events & Programs'
                        ])
                        
                        @include('partials.sidebar-link', [
                            'route' => 'church.attendance.index',
                            'icon' => 'calendar-check-2',
                            'label' => 'Attendance'
                        ])
                    </li>
                    @endif
                    @endif

                    <!-- CHURCH LEAD SECTION -->
                    @if($isChurchLead && !$isChurchAdmin && !$isTreasurer)
                    <li>
                        <p x-show="open"
                           class="text-[11px] font-bold tracking-widest uppercase text-teal-700/80 mb-3 px-2 border-t border-teal-200 pt-6">
                            Leadership
                        </p>

                        @include('partials.sidebar-link', [
                            'route' => 'church-lead.members.index',
                            'icon' => 'users',
                            'label' => 'View Members'
                        ])
                        
                        @include('partials.sidebar-link', [
                            'route' => 'church-lead.events.index',
                            'icon' => 'calendar',
                            'label' => 'Manage Events'
                        ])
                        
                        @include('partials.sidebar-link', [
                            'route' => 'church-lead.reports.index',
                            'icon' => 'bar-chart-3',
                            'label' => 'Ministry Reports'
                        ])
                    </li>
                    @endif
                @endif

                <!-- SUPER ADMIN SECTION -->
                @if($isSuperAdmin)
                <li class="border-t-4 border-rose-400 bg-rose-50/60 rounded-xl -mx-3 px-5 pt-8 pb-2 shadow-inner">
                    <p x-show="open"
                       class="text-[11px] font-black tracking-widest uppercase text-rose-700 mb-4">
                        Super Admin Zone
                    </p>

                    @include('partials.sidebar-link', [
                        'route' => 'system-admin.users.index',
                        'icon' => 'users-cog',
                        'label' => 'All Users',
                        'badge' => 'Tenants'
                    ])
                    
                    @include('partials.sidebar-link', [
                        'route' => 'system-admin.rolemanager.index',
                        'icon' => 'shield-alert',
                        'label' => 'Roles Manager',
                        'badge' => 'Dev'
                    ])
                    
                    @include('partials.sidebar-link', [
                        'route' => 'system-admin.church.index',
                        'icon' => 'church',
                        'label' => 'Churches',
                        'badge' => 'Multi-Tenant'
                    ])
                    
                    @include('partials.sidebar-link', [
                        'route' => 'super-admin.action-center',
                        'icon' => 'zap',
                        'label' => 'Action Center',
                        'badge' => 'Backup • Migrate'
                    ])
                </li>
                @endif

                <!-- ACCOUNT SECTION -->
                <li class="mt-8 border-t-2 border-amber-300 pt-8">
                    <p x-show="open"
                       class="text-[11px] font-bold tracking-widest uppercase text-amber-700/70 mb-3 px-2">
                        Account
                    </p>

                    @include('partials.sidebar-link', [
                        'route' => 'profile.edit',
                        'icon' => 'user-circle',
                        'label' => 'Profile Settings'
                    ])

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-4 px-4 py-3.5 rounded-xl text-rose-700 hover:bg-rose-100 transition-all duration-300 font-semibold"
                                aria-label="Logout">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                            <span x-show="open" class="transition-opacity duration-300">Logout</span>
                        </button>
                    </form>

                    <!-- Super Admin Indicator -->
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

    <!-- Current Role Indicator -->
    @if(!$isSuperAdmin)
    <div x-show="open" 
         class="px-4 py-3 border-t border-amber-100 bg-amber-50/50">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold text-amber-900">
                Current Role:
            </span>
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-200 text-amber-900">
                {{ ucwords(str_replace('-', ' ', $user->getRoleNames()->first())) }}
            </span>
        </div>
    </div>
    @endif
</aside>
@endif


