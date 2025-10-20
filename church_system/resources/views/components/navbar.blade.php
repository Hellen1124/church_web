<nav class="bg-gradient-to-r from-amber-50 via-stone-50 to-amber-100 fixed top-0 inset-x-0 z-50 shadow-[0_1px_6px_rgba(120,72,0,0.08)] backdrop-blur-md border-b border-amber-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- 🌿 Left: Logo + Title --}}
            <div class="flex items-center space-x-3">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-2 p-1 rounded-lg hover:bg-amber-100 transition duration-150">
                    
                    <div class="w-12 h-12 rounded-full bg-amber-200 flex items-center justify-center shadow-sm">
                        <i class="fa fa-church text-amber-800 text-lg"></i>
                    </div>

                    <span class="hidden sm:block text-lg font-semibold text-amber-900 tracking-tight">
                        {{ config('app.name', 'My Church') }}
                    </span>
                </a>
            </div>

            {{-- 🔍 Center: Search --}}
            <div class="hidden md:flex flex-1 justify-center items-center px-8">
                <div class="relative w-full max-w-lg">
                    <input type="text"
                           placeholder="Search members, services, or events..."
                           class="w-full pl-10 pr-4 py-2 text-sm rounded-lg border border-amber-200 
                                  bg-stone-50 placeholder-stone-400
                                  focus:ring-2 focus:ring-amber-400 focus:border-amber-400
                                  shadow-sm text-stone-700 transition-all duration-200">
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-amber-500" 
                         xmlns="http://www.w3.org/2000/svg" fill="none" 
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1116.65 16.65z" />
                    </svg>
                </div>
            </div>

            {{-- 🌸 Right: User Actions --}}
            <div class="flex items-center space-x-2 sm:space-x-4">

                {{-- Notifications --}}
                <button title="Notifications" 
                        class="relative p-2 rounded-full text-stone-700 hover:bg-amber-100 
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-400 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         class="h-6 w-6 text-amber-700" fill="none" 
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405M19 9a7 7 0 10-14 0v5l-1.405 1.405M13 21h-2a2 2 0 002 2 2 2 0 002-2z"/>
                    </svg>
                    <span class="absolute -top-0.5 right-0 bg-rose-500 text-white text-[10px] font-bold px-1.5 rounded-full ring-2 ring-stone-50">3</span>
                </button>

                {{-- 👤 User Menu --}}
                <div class="relative" x-data="{ isOpen: false }" @click.outside="isOpen = false">
                    <button @click="isOpen = !isOpen" 
                            class="flex items-center p-1 space-x-2 rounded-lg focus:outline-none 
                                   focus:ring-2 focus:ring-offset-2 focus:ring-amber-400 transition duration-150">
                        <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.png') }}"
                             alt="User Avatar" 
                             class="h-9 w-9 rounded-full object-cover border-2 border-transparent 
                                    hover:border-amber-400 transition duration-150 shadow-sm">
                        <div class="text-left hidden md:block leading-tight">
                            <p class="text-sm font-semibold text-stone-800">
                                {{ Auth::user()->first_name ?? Auth::user()->name }}
                            </p>
                            <p class="text-xs text-stone-500 capitalize">
                                {{ Auth::user()->roles->first()->name ?? 'User' }}
                            </p>
                        </div>
                        <svg class="h-4 w-4 text-stone-500 transition transform"
                             :class="{ 'rotate-180': isOpen }"
                             xmlns="http://www.w3.org/2000/svg" fill="none" 
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div x-show="isOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-3 w-52 bg-white border border-amber-100 rounded-xl shadow-lg z-50 origin-top-right">
                        
                        <div class="py-1">
                            <a href="#" 
                               class="flex items-center px-4 py-2 text-stone-700 hover:bg-amber-50 hover:text-amber-700 text-sm transition">
                                <i class="fa fa-user-circle me-3 text-amber-600"></i> Profile
                            </a>
                            <a href="#" 
                               class="flex items-center px-4 py-2 text-stone-700 hover:bg-amber-50 hover:text-amber-700 text-sm transition">
                                <i class="fa fa-cog me-3 text-amber-600"></i> Settings
                            </a>
                            <div class="border-t border-amber-100 my-1"></div>
                            <form method="POST" action="#">
                                @csrf
                                <button type="submit" 
                                        class="w-full text-left flex items-center px-4 py-2 text-rose-700 hover:bg-rose-50 text-sm transition">
                                    <i class="fa fa-sign-out-alt me-3 text-rose-600"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 📱 Mobile Menu --}}
            <div class="flex items-center md:hidden">
                <button class="text-stone-700 hover:text-stone-900 focus:outline-none p-2 rounded-full hover:bg-amber-100 transition">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" 
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

