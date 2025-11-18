@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $role = $user?->getRoleNames()->first();
    $isAdmin = $user && $user->hasRole('Church Admin');
    $isTreasurer = $role === 'Treasurer';
    $isSecretary = $role === 'Secretary';
    $isSuperAdmin = $user && $user->hasRole('super-admin');
@endphp

<aside 
    x-data="{ open: true }" 
    class="fixed top-0 left-0 z-40 h-screen pt-16 bg-gradient-to-b from-amber-50 via-stone-50 to-stone-100 
           border-r border-amber-100 shadow-[0_0_10px_rgba(87,59,20,0.08)] 
           transition-all duration-300 ease-in-out"
    :class="open ? 'w-64' : 'w-20'"
>
    <div class="flex flex-col h-full">
        {{-- Logo / Collapse --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-amber-100">
            <div class="flex items-center space-x-2">
                <i class="fa fa-church text-amber-600 text-xl"></i>
                <span x-show="open" class="font-semibold text-amber-900 tracking-tight text-sm">My Church</span>
            </div>
            <button @click="open = !open" class="text-stone-500 hover:text-amber-600 transition">
                <i class="fa" :class="open ? 'fa-chevron-left' : 'fa-chevron-right'"></i>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-2 scrollbar-thin scrollbar-thumb-amber-300 scrollbar-track-amber-50">
            <p x-show="open" class="text-xs font-semibold uppercase text-stone-500 mt-2 mb-1 px-2">Core</p>
            @include('partials.sidebar-link', ['route' => 'dashboard', 'icon' => 'fa-chart-line', 'label' => 'Dashboard'])

            @if ($isAdmin || $isSecretary)
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-users', 'label' => 'Members Directory'])
            @endif

            @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-calendar-alt', 'label' => 'Events & Programs'])

            {{-- Finance --}}
            @if ($isTreasurer || $isAdmin)
                <p x-show="open" class="text-xs font-semibold uppercase text-stone-500 mt-4 mb-1 px-2 border-t border-amber-100 pt-3">Finance</p>
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-hand-holding-usd', 'label' => 'Offerings & Tithes'])
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-receipt', 'label' => 'Expenses'])
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-file-invoice-dollar', 'label' => 'Reports'])
            @endif

            {{-- Operations --}}
            @if ($isAdmin)
                <p x-show="open" class="text-xs font-semibold uppercase text-stone-500 mt-4 mb-1 px-2 border-t border-amber-100 pt-3">Operations</p>
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-layer-group', 'label' => 'Departments'])
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-calendar-check', 'label' => 'Attendance'])
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-comments', 'label' => 'Messaging'])
            @endif

            {{-- Documentation --}}
            @if ($isSecretary)
                <p x-show="open" class="text-xs font-semibold uppercase text-stone-500 mt-4 mb-1 px-2 border-t border-amber-100 pt-3">Documentation</p>
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-book-open', 'label' => 'Meeting Minutes'])
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-envelope-open-text', 'label' => 'Letters'])
            @endif

            {{-- SUPER ADMIN ONLY — GOD MODE ACTIVATED --}}
            @if($isSuperAdmin)
                <p x-show="open" class="text-xs font-bold uppercase text-red-700 mt-6 mb-1 px-2 border-t-2 border-red-200 pt-4 
                    bg-red-50/50 rounded-lg">⚡ SUPER ADMIN ZONE ⚡</p>

                {{-- Users --}}
                @include('partials.sidebar-link', [
                    'route' => 'system-admin.users.index',
                    'icon' => 'fa-users-cog',
                    'label' => 'Users',
                    'badge' => 'All Tenants',
                    'badgeColor' => 'bg-emerald-100 text-emerald-800'
                ])

                {{-- Roles & Permissions --}}
                @include('partials.sidebar-link', [
                    'route' => 'system-admin.rolemanager.index',
                    'icon' => 'fa-user-shield',
                    'label' => 'Roles & Permissions',
                    'badge' => 'Dev Only',
                    'badgeColor' => 'bg-red-100 text-red-800',
                    'iconColor' => 'text-red-600',
                    'hoverBg' => 'hover:bg-red-50'
                ])

                {{-- Churches / Tenants --}}
                @include('partials.sidebar-link', [
                    'route' => 'system-admin.church.index',
                    'icon' => 'fa-building',
                    'label' => 'Churches',
                    'badge' => 'Multi-Tenant',
                    'badgeColor' => 'bg-amber-100 text-amber-800'
                ])

                {{-- Action Center --}}
                @include('partials.sidebar-link', [
                    'route' => 'super-admin.action-center',
                    'icon' => 'fa-bolt',
                    'label' => 'Action Center',
                    'badge' => 'Backup • Migrate',
                    'badgeColor' => 'bg-orange-100 text-orange-800'
                ])

                {{-- Developer Tools --}}
                <div x-data="{ devOpen: false }">
                    <button @click="devOpen = !devOpen"
                            class="flex items-center w-full px-3 py-2.5 text-sm font-medium text-gray-700 
                                   hover:bg-amber-100 rounded-lg transition-all duration-200 group">
                        <i class="fa fa-terminal w-5 text-purple-600"></i>
                        <span x-show="open" class="ml-3">Developer Tools</span>
                        <i x-show="open" class="ml-auto fa" :class="devOpen ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                    </button>

                    <div x-show="devOpen" x-transition x-cloak class="ml-8 space-y-1">
                        @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-code', 'label' => 'Artisan Console'])
                        @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-file-code', 'label' => 'Logs Viewer'])
                        @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-broom', 'label' => 'Cache Clear'])
                        @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-shield-alt', 'label' => 'Gate Bypass'])
                    </div>
                </div>
            @endif
        </nav>

        {{-- Account (Sticky Logout) --}}
        <div class="sticky bottom-0 bg-gradient-to-t from-stone-100 to-amber-50 border-t border-amber-100 px-3 py-4">
            <p x-show="open" class="text-xs font-semibold uppercase text-stone-500 mb-2 px-2">Account</p>
            @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-user-circle', 'label' => 'Profile Settings'])

            <form method="POST" action="#" class="mt-2">
                @csrf
                <button type="submit"
                    class="flex items-center w-full px-2 py-2 text-sm font-medium text-rose-700 
                           hover:bg-rose-50 hover:text-rose-800 rounded-lg 
                           transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-rose-300">
                    <i class="fa fa-sign-out-alt w-5 me-2"></i>
                    <span x-show="open">Logout</span>
                </button>
            </form>

            @if($isSuperAdmin)
                <div x-show="open" class="mt-3 px-2 text-xs text-red-600 font-bold animate-pulse">
                    ROOT ACCESS ACTIVE
                </div>
            @endif
        </div>
    </div>
</aside>

<style>
    .scrollbar-thin {
        scrollbar-width: thin;
        scrollbar-color: #f59e0b #fef3c7;
    }
    .scrollbar-thin::-webkit-scrollbar {
        width: 8px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: #fef3c7;
        border-radius: 4px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #f59e0b;
        border-radius: 4px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #d97706;
    }
</style>