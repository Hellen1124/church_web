<nav class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-md border-b border-amber-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- 🌿 Left: Logo + Brand --}}
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center shadow-inner group-hover:bg-amber-200 transition">
                    <i class="fa fa-church text-amber-700 text-lg"></i>
                </div>
                <span class="hidden sm:block text-lg font-semibold text-stone-800 group-hover:text-amber-700 transition">
                    {{ config('app.name', 'Church System') }}
                </span>
            </a>

            {{-- 🔍 Center: Search Bar --}}
            <div class="hidden md:flex flex-1 justify-center px-8">
                <div class="relative w-full max-w-md">
                    <input type="text"
                        placeholder="Search members, churches, or events..."
                        class="w-full pl-10 pr-4 py-2 text-sm rounded-lg border border-amber-100
                               bg-amber-50/50 placeholder-stone-400 focus:ring-2 focus:ring-amber-400
                               focus:border-amber-400 text-stone-700 shadow-sm transition duration-200">
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-amber-500" xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1116.65 16.65z" />
                    </svg>
                </div>
            </div>

            {{-- 🌸 Right: User Actions --}}
            <div class="flex items-center space-x-2 sm:space-x-4">

                {{-- Notifications --}}
                <button title="Notifications"
                    class="relative p-2 rounded-full text-stone-700 hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-400 transition">
                    <i class="fa fa-bell text-amber-700"></i>
                    <span class="absolute -top-0.5 right-0 bg-rose-500 text-white text-[10px] font-bold px-1.5 rounded-full ring-2 ring-white">3</span>
                </button>

                {{-- 👤 User Menu --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false"
                        class="flex items-center space-x-2 rounded-full focus:outline-none focus:ring-2 focus:ring-amber-400 p-1.5 transition">
                        <img src="{{ Auth::user()->profile_photo_url ?? asset('images/avatar.jpg') }}"
                             alt="User Avatar"
                             class="h-9 w-9 rounded-full object-cover border border-amber-100 shadow-sm">
                        <div class="hidden md:block text-left leading-tight">
                            <p class="text-sm font-semibold text-stone-800">{{ Auth::user()->first_name ?? Auth::user()->name }}</p>
                            <p class="text-xs text-stone-500 capitalize">{{ Auth::user()->roles->first()->name ?? 'User' }}</p>
                        </div>
                        <i class="fa fa-chevron-down text-xs text-stone-400"></i>
                    </button>

                    {{-- Dropdown --}}
                    <div x-show="open" x-transition
                        class="absolute right-0 mt-2 w-52 bg-white border border-amber-100 rounded-xl shadow-lg ring-1 ring-black/5 origin-top-right z-50">
                        <div class="py-1">
                            <a href="{{ route('system-admin.profile.show') }}" class="flex items-center px-4 py-2 text-sm text-stone-700 hover:bg-amber-50 hover:text-amber-700 transition">
                                <i class="fa fa-user-circle me-3 text-amber-600"></i> Profile
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-stone-700 hover:bg-amber-50 hover:text-amber-700 transition">
                                <i class="fa fa-cog me-3 text-amber-600"></i> Settings
                            </a>
                            <div class="border-t border-amber-100 my-1"></div>
                            <form method="POST" action="#">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center px-4 py-2 text-sm text-rose-700 hover:bg-rose-50 transition">
                                    <i class="fa fa-sign-out-alt me-3 text-rose-600"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- 📱 Mobile Menu --}}
                <button class="md:hidden p-2 rounded-full text-stone-700 hover:bg-amber-100 transition">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</nav>


