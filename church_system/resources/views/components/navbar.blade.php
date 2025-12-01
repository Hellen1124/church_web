<nav class="fixed inset-x-0 top-0 z-50 bg-white/90 backdrop-blur-lg border-b border-amber-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Left: Logo + Brand -->
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center shadow-inner group-hover:from-amber-200 group-hover:to-orange-200 transition-all duration-300">
                    <x-lucide-landmark class="w-6 h-6 text-amber-700" />
                </div>
                <span class="hidden sm:block text-xl font-bold text-stone-800 group-hover:text-amber-700 transition">
                    {{ config('app.name', 'Church System') }}
                </span>
            </a>

            <!-- Center: Search Bar (hidden on mobile, visible md+) -->
            <div class="hidden md:flex flex-1 justify-center px-8">
                <div class="relative w-full max-w-md">
                    <x-lucide-search class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-amber-600" />
                    <input type="text"
                           placeholder="Search members, events, offerings..."
                           class="w-full pl-11 pr-5 py-2.5 text-sm rounded-xl border border-amber-200 bg-amber-50/70 placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition shadow-sm">
                </div>
            </div>

            <!-- Right: Actions -->
            <div class="flex items-center gap-3">

                <!-- Mobile Search Icon (only visible on mobile) -->
                <button class="md:hidden p-2.5 rounded-full hover:bg-amber-100 transition">
                    <x-lucide-search class="w-5 h-5 text-amber-700" />
                </button>

                <!-- Notifications -->
                <div class="relative">
                    <button class="relative p-2.5 rounded-full hover:bg-amber-100 transition group">
                        <x-lucide-bell class="w-5.5 h-5.5 text-amber-700 group-hover:text-amber-800" />
                        <span class="absolute -top-1 -right-1 bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ring-2 ring-white animate-pulse">
                            3
                        </span>
                    </button>
                </div>

                <!-- User Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false"
                            class="flex items-center gap-3 rounded-full p-1.5 hover:bg-amber-50 focus:outline-none focus:ring-2 focus:ring-amber-400 transition">
                        
                        <!-- Avatar -->
                        <img src="{{ Auth::user()->profile_photo_url ?? asset('images/avatar.jpg') }}"
                             alt="Profile"
                             class="w-9 h-9 rounded-full object-cover ring-2 ring-amber-200 shadow-sm">

                        <!-- Name + Role (hidden on small screens) -->
                        <div class="hidden lg:block text-left leading-tight">
                            <p class="text-sm font-semibold text-stone-800">{{ Auth::user()->first_name }}</p>
                            <p class="text-xs text-stone-500 capitalize">{{ Auth::user()->roles->first()->name ?? 'Member' }}</p>
                        </div>

                        <!-- Chevron -->
                        <x-lucide-chevron-down class="w-4 h-4 text-stone-500" />
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-amber-100 ring-1 ring-black/5 overflow-hidden">

                        <div class="py-2">
                            <a href="{{ route('system-admin.profile.show') }}"
                               class="flex items-center gap-3 px-5 py-3 text-sm text-stone-700 hover:bg-amber-50 hover:text-amber-700 transition">
                                <x-lucide-user-circle class="w-5 h-5 text-amber-600" />
                                My Profile
                            </a>
                            <a href="#"
                               class="flex items-center gap-3 px-5 py-3 text-sm text-stone-700 hover:bg-amber-50 hover:text-amber-700 transition">
                                <x-lucide-settings class="w-5 h-5 text-amber-600" />
                                Settings
                            </a>
                        </div>

                        <div class="border-t border-amber-100"></div>

                        <div class="py-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center gap-3 px-5 py-3 text-sm text-rose-700 hover:bg-rose-50 transition">
                                    <x-lucide-log-out class="w-5 h-5 text-rose-600" />
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="md:hidden p-2.5 rounded-full hover:bg-amber-100 transition">
                    <x-lucide-menu class="w-6 h-6 text-amber-700" />
                </button>
            </div>
        </div>
    </div>
</nav>


