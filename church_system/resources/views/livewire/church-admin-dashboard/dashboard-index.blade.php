<div>
    @php
        $totalMembers       = $totalMembers ?? 0;
        $newThisMonth       = $newThisMonth ?? 0;
        $totalOfferingToday = $totalOfferingToday ?? 0;
        $totalOfferingMonth = $totalOfferingMonth ?? 0;
        $upcomingEvents     = $upcomingEvents ?? collect();
        $recentOfferings    = $recentOfferings ?? collect();
    @endphp

    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-amber-100">

        <!-- HERO SECTION – Warm & Welcoming -->
        <div class="bg-gradient-to-r from-amber-600 via-orange-600 to-amber-700 shadow-2xl">
            <div class="max-w-7xl mx-auto px-6 py-20">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                    <div class="text-white text-center lg:text-left">
                        <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight leading-tight">
                            Welcome back,<br>
                            <span class="text-amber-200">{{ auth()->user()->first_name }}!</span>
                        </h1>
                        <p class="text-xl mt-6 flex items-center justify-center lg:justify-start gap-4 font-medium text-amber-100">
                            <x-lucide-landmark class="w-10 h-10 text-amber-300" />
                            {{ $tenant?->church_name ?? 'Your Church' }}
                            <span class="hidden sm:inline mx-2">•</span>
                            <span class="block sm:inline">{{ now()->format('l, j F Y') }}</span>
                        </p>
                    </div>

                    <!-- Souls in Fellowship Card -->
                    <div class="bg-white/25 backdrop-blur-lg border border-white/30 rounded-3xl p-10 text-center shadow-2xl transform hover:scale-105 transition duration-500">
                        <p class="text-amber-100 text-sm uppercase tracking-widest opacity-90">Souls in Fellowship</p>
                        <p class="text-8xl font-black text-white mt-4">{{ number_format($totalMembers) }}</p>
                        <p class="text-amber-200 text-lg mt-5 font-semibold flex items-center justify-center gap-2">
                            <x-lucide-trending-up class="w-6 h-6" />
                            +{{ $newThisMonth }} new this month
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-14 -mt-12 relative z-10">

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-14">
                <x-stat-card icon="users-round"     color="amber"   title="Total Members"      :value="$totalMembers"       subtitle="+{{ $newThisMonth }} this month" />
                <x-stat-card icon="hand-coins"      color="emerald" title="Today's Offering"   value="₦{{ number_format($totalOfferingToday) }}" />
                <x-stat-card icon="piggy-bank"      color="orange"  title="Monthly Offering"   value="₦{{ number_format($totalOfferingMonth) }}" />
                <x-stat-card icon="calendar-heart"  color="purple"  title="Upcoming Events"    :value="$upcomingEvents->count()" subtitle="Next 30 days" />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Upcoming Events -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-3xl shadow-xl border border-amber-100/60 p-8">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-3xl font-bold text-amber-900 flex items-center gap-4">
                                <x-lucide-calendar-heart class="w-11 h-11 text-amber-600" />
                                Upcoming Events
                            </h2>
                            <a href="{{ route('church.events.index') }}" class="text-amber-600 hover:text-amber-700 font-semibold text-sm flex items-center gap-2 transition">
                                View all <x-lucide-arrow-right class="w-5 h-5" />
                            </a>
                        </div>

                        @forelse($upcomingEvents as $event)
                            <div class="flex items-center gap-6 p-6 bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl mb-5 hover:from-amber-100 hover:to-orange-100 transition-all duration-300 group">
                                <div class="bg-amber-600 text-white font-bold w-16 h-16 rounded-xl flex flex-col items-center justify-center shadow-lg">
                                    <div class="text-2xl leading-none">{{ $event->start_at->format('d') }}</div>
                                    <div class="text-xs uppercase tracking-wider">{{ $event->start_at->format('M') }}</div>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-gray-900 text-lg group-hover:text-amber-800 transition">{{ $event->title }}</p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $event->start_at->format('D, j M • g:i A') }}
                                        @if($event->location) • {{ $event->location }} @endif
                                    </p>
                                </div>
                                <span class="text-xs bg-amber-700 text-white px-4 py-2 rounded-full font-medium">
                                    {{ $event->start_at->diffForHumans() }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-16 text-gray-500">
                                <x-lucide-calendar-x-2 class="w-20 h-20 mx-auto mb-5 text-gray-300" />
                                <p class="text-lg font-medium">No upcoming events</p>
                                <p class="text-sm mt-2">Time to plan something beautiful for the flock!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Offerings -->
                <div>
                    <div class="bg-white rounded-3xl shadow-xl border border-emerald-100/60 p-8">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-2xl font-bold text-emerald-800 flex items-center gap-4">
                                <x-lucide-heart-handshake class="w-11 h-11 text-emerald-600" />
                                Recent Offerings
                            </h2>
                            <a href="#" class="text-emerald-600 hover:text-emerald-700 font-semibold text-sm flex items-center gap-1">
                                All <x-lucide-arrow-right class="w-5 h-5" />
                            </a>
                        </div>

                        @forelse($recentOfferings as $offering)
                            <div class="flex justify-between items-center p-6 bg-emerald-50 rounded-2xl mb-5 hover:bg-emerald-100 transition">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $offering->member?->full_name ?? 'Anonymous' }}</p>
                                    <p class="text-xs text-gray-600 mt-1">{{ $offering->created_at->format('j M, Y • g:i A') }}</p>
                                </div>
                                <p class="font-bold text-emerald-700 text-xl">₦{{ number_format($offering->amount) }}</p>
                            </div>
                        @empty
                            <div class="text-center py-16 text-gray-500">
                                <x-lucide-gift class="w-20 h-20 mx-auto mb-5 text-gray-300" />
                                <p class="text-lg font-medium">No offerings yet</p>
                                <p class="text-sm italic mt-3 text-emerald-700">"The Lord loves a cheerful giver" – 2 Cor 9:7</p>
                            </div>
                        @endforelse

                        <div class="mt-8 pt-6 border-t border-emerald-100 text-center">
                            <p class="text-sm text-emerald-700 font-medium italic">
                                “Give, and it will be given to you…” – Luke 6:38
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-20">
                <h3 class="text-3xl font-bold text-center text-gray-800 mb-10">Quick Actions</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-7">
                    <a href="{{ route('church.members.create') }}"
                       class="group bg-gradient-to-br from-blue-600 to-blue-700 text-white p-9 rounded-3xl text-center shadow-xl hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300">
                        <x-lucide-user-plus class="w-16 h-16 mx-auto mb-4 group-hover:scale-110 transition" />
                        <p class="font-bold text-xl">Add Member</p>
                    </a>

                    <a href="{{ route('church.events.create') }}"
                       class="group bg-gradient-to-br from-purple-600 to-purple-700 text-white p-9 rounded-3xl text-center shadow-xl hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300">
                        <x-lucide-calendar-plus class="w-16 h-16 mx-auto mb-4 group-hover:scale-110 transition" />
                        <p class="font-bold text-xl">New Event</p>
                    </a>

                    <a href="#"
                       class="group bg-gradient-to-br from-emerald-600 to-emerald-700 text-white p-9 rounded-3xl text-center shadow-xl hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300">
                        <x-lucide-gift class="w-16 h-16 mx-auto mb-4 group-hover:scale-110 transition" />
                        <p class="font-bold text-xl">Record Offering</p>
                    </a>

                    <a href="#"
                       class="group bg-gradient-to-br from-orange-600 to-orange-700 text-white p-9 rounded-3xl text-center shadow-xl hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300">
                        <x-lucide-check-square class="w-16 h-16 mx-auto mb-4 group-hover:scale-110 transition" />
                        <p class="font-bold text-xl">Take Attendance</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
