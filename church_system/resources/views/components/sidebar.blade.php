@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $role = $user?->getRoleNames()->first();
    $isAdmin = $user && $user->hasRole('Church Admin');
    $isTreasurer = $role === 'Treasurer';
    $isSecretary = $role === 'Secretary';
@endphp

<aside 
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 
           bg-gradient-to-b from-amber-50 via-stone-50 to-stone-100 
           border-r border-amber-100 shadow-[0_0_10px_rgba(87,59,20,0.08)] 
           flex flex-col transition-all duration-300 ease-in-out"
>
    <div class="flex-1 overflow-y-auto">
        
        {{-- 🌿 HEADER --}}
       

        {{-- 🌻 NAVIGATION --}}
        <nav class="flex flex-col p-3 space-y-1">

            {{-- CORE --}}
            <p class="text-xs font-semibold uppercase text-stone-500 mt-3 mb-2 px-2">Core</p>
            @include('partials.sidebar-link', ['route' => 'dashboard', 'icon' => 'fa-chart-line', 'label' => 'Dashboard'])

            @if ($isAdmin || $isSecretary)
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-users', 'label' => 'Members Directory'])
            @endif

            @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-calendar-alt', 'label' => 'Events & Programs'])

            {{-- 💰 Finance --}}
            @if ($isTreasurer || $isAdmin)
                <div class="border-t border-amber-100 my-2"></div>
                <p class="text-xs font-semibold uppercase text-stone-500 mt-2 mb-1 px-2">Finance</p>

                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-hand-holding-usd', 'label' => 'Offerings & Tithes'])
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-receipt', 'label' => 'Expenses'])
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-file-invoice-dollar', 'label' => 'Reports'])
            @endif

            {{-- 🧩 Operations --}}
            @if ($isAdmin)
                <div class="border-t border-amber-100 my-2"></div>
                <p class="text-xs font-semibold uppercase text-stone-500 mt-2 mb-1 px-2">Operations</p>

                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-layer-group', 'label' => 'Departments'])
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-calendar-check', 'label' => 'Attendance'])
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-sms', 'label' => 'Messaging'])
            @endif

            {{-- 📘 Documentation --}}
            @if ($isSecretary)
                <div class="border-t border-amber-100 my-2"></div>
                <p class="text-xs font-semibold uppercase text-stone-500 mt-2 mb-1 px-2">Documentation</p>

                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-book-open', 'label' => 'Meeting Minutes'])
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-envelope-open-text', 'label' => 'Letters'])
            @endif

            {{-- 🛠️ System --}}
            @if($user && $user->hasRole('super-admin'))
                <div class="border-t border-amber-100 my-2"></div>
                <p class="text-xs font-semibold uppercase text-stone-500 mt-2 mb-1 px-2">System</p>

                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-building', 'label' => 'Churches'])
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-user-shield', 'label' => 'Users & Roles'])
                @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-database', 'label' => 'Logs'])
            @endif

            {{-- ⚙️ Account --}}
            <div class="border-t border-amber-100 my-2"></div>
            <p class="text-xs font-semibold uppercase text-stone-500 mt-2 mb-1 px-2">Account</p>

            @include('partials.sidebar-link', ['route' => '#', 'icon' => 'fa-user-circle', 'label' => 'Profile Settings'])

            <form method="POST" action="#" class="mt-4">
                @csrf
                <button class="flex items-center w-full px-2 py-2 text-sm font-medium text-rose-700 
                               hover:bg-rose-50 hover:text-rose-800 rounded-lg 
                               transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-rose-300">
                    <i class="fa fa-sign-out-alt w-5 me-2"></i> Logout
                </button>
            </form>
        </nav>
    </div>
</aside>

