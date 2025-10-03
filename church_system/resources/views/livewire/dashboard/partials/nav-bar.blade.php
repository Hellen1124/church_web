<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <!-- Left: Logo / Title -->
    <div class="flex items-center space-x-3">
        <img src="{{ asset('images/church-logo.png') }}" alt="Logo" class="h-8 w-8">
        <span class="text-xl font-bold text-gray-800">Church Management</span>
    </div>

    <!-- Center: (Optional Search Bar) -->
    <div class="hidden md:block flex-1 px-6">
        <input type="text" 
               placeholder="Search members, events, donations..." 
               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring focus:ring-blue-300">
    </div>

    <!-- Right: Notifications + User -->
    <div class="flex items-center space-x-4">
        <!-- Notifications -->
        <button class="relative">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15 17h5l-1.405-1.405M19 9a7 7 0 10-14 0v5l-1.405 1.405M13 21h-2a2 2 0 002 2 2 2 0 002-2z"/>
            </svg>
            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs px-1 rounded-full">3</span>
        </button>

        <!-- User Dropdown -->
        <div class="relative">
            <button class="flex items-center space-x-2 focus:outline-none">
                <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.png') }}" 
                     alt="User" class="h-8 w-8 rounded-full">
                <span class="text-gray-700">{{ Auth::user()->name }}</span>
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden group-hover:block">
                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                <a href="{{ route('settings') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
