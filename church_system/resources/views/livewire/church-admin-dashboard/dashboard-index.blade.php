<div class="min-h-screen bg-gray-100 font-sans">

    {{--
        ====================================================
        1. VARIABLE FALLBACKS & HELPER FUNCTIONS
        ====================================================
    --}}
    @php
        // Ensure all required variables have a fallback
        $totalMembers = $totalMembers ?? 0;
        $newThisMonth = $newThisMonth ?? 0;
        $totalOfferingToday = $totalOfferingToday ?? 0; // Renamed to totalCollectionToday in context
        $totalOfferingMonth = $totalOfferingMonth ?? 0; // Renamed to totalCollectionMonth in context
        $upcomingEvents = $upcomingEvents ?? collect();
        $recentOfferings = $recentOfferings ?? collect();
        $tenantName = $tenant?->church_name ?? 'Your Church';
        $userName = auth()->user()->first_name ?? 'User';

        // Helper function for KES currency formatting (REPLACED NGN)
        $formatCurrency = fn($amount) => 'KSh ' . number_format($amount); // KES Formatting

        // Custom KPI Card Renderer (inlined for this example)
        $renderKpiCard = function($icon, $title, $value, $trend) use ($formatCurrency, $totalOfferingMonth, $totalOfferingToday, $newThisMonth) {
            $isMoney = str_contains($title, 'Collection') || str_contains($title, 'Expense');
            $color = $isMoney ? 'emerald' : 'amber';
            $baseValue = $value;

            // Trend Logic
            $trendInfo = '';
            if ($title === 'Total Members') {
                $trendInfo = "<span class='text-green-600 font-bold'>+{$newThisMonth}</span> this month";
            } elseif ($title === 'Today\'s Collection') {
                $trendInfo = ((float)$totalOfferingToday > 0) ? "<span class='text-green-600'>Active today</span>" : "Record required";
            } elseif ($title === 'Monthly Collection') {
                // Demo target KSh 500k (REPLACED NGN 500k target)
                $progress = min(100, ceil($totalOfferingMonth / 500000 * 100));
                $trendInfo = "<div class='w-full bg-gray-200 rounded-full h-1.5 mt-1'><div class='h-1.5 rounded-full bg-{$color}-500' style='width: {$progress}%'></div></div>";
            } elseif ($title === 'Upcoming Events') {
                $trendInfo = "Next 30 days";
            }

            // Final Card Structure
            return "
                <div class='bg-white rounded-2xl p-6 shadow-xl border-t-4 border-{$color}-400 transition hover:shadow-2xl'>
                    <div class='flex items-center space-x-3'>
                        <div class='p-2 rounded-lg bg-{$color}-100 text-{$color}-600'>
                            <x-lucide-{$icon} class='w-5 h-5' />
                        </div>
                        <p class='text-sm font-semibold text-gray-500 uppercase'>{$title}</p>
                    </div>
                    <p class='text-3xl font-extrabold text-gray-900 mt-3'>{$baseValue}</p>
                    <div class='text-xs text-gray-500 mt-2'>{$trendInfo}</div>
                </div>
            ";
        };
    @endphp

    {{--
        ====================================================
        2. HEADER / HERO SECTION
        ====================================================
    --}}
    <div class="bg-amber-500/90 shadow-2xl border-b-4 border-amber-600">
        <div class="max-w-7xl mx-auto px-6 py-12 lg:py-16">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight">
                Hello, <span class="text-amber-100">{{ $userName }}!</span>
            </h1>
            <p class="text-xl mt-3 flex items-center gap-3 text-amber-100 font-medium">
                <x-lucide-landmark class="w-7 h-7 text-white" />
                {{ $tenantName }} Central Hub
                <span class="hidden sm:inline mx-2">•</span>
                <span class="block sm:inline text-sm font-light text-amber-200">{{ now()->format('l, j F Y') }}</span>
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">

        {{--
            ====================================================
            3. KPI CARDS - Condensed, Focused Metrics
            ====================================================
        --}}
        <div class="mb-14">
            <h2 class="text-2xl font-extrabold text-gray-800 mb-6 border-b-2 border-amber-50 pb-2">Central Metrics</h2>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- 1. Members (Amber Focus) --}}
                {!! $renderKpiCard('users-round', 'Total Members', number_format($totalMembers), 'Members') !!}

                {{-- 2. Today's Collection (Emerald Focus) --}}
                {!! $renderKpiCard('hand-coins', 'Today\'s Collection', $formatCurrency($totalOfferingToday), 'Today\'s Collection') !!}

                {{-- 3. Monthly Collection (Emerald Focus) --}}
                {!! $renderKpiCard('piggy-bank', 'Monthly Collection', $formatCurrency($totalOfferingMonth), 'Monthly Collection') !!}

                {{-- 4. Upcoming Events (Amber Focus) --}}
                {!! $renderKpiCard('calendar-heart', 'Upcoming Events', $upcomingEvents->count(), 'Upcoming Events') !!}

            </div>
        </div>

        {{--
            ====================================================
            4. QUICK ACTIONS - THE CENTRAL ACTION HUB
            ====================================================
        --}}
        <div class="mt-16 mb-20 bg-amber-50 p-8 rounded-3xl shadow-inner border border-amber-200">
            <h3 class="text-3xl font-extrabold text-gray-800 text-center mb-10">
                <i class="fas fa-bolt text-amber-600 mr-2"></i> Quick Action Hub
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

                {{-- ACTION: Add Member (Amber) --}}
                <a href="{{ route('church.members.create') }}"
                    class="group bg-white p-6 rounded-2xl text-center shadow-lg border border-amber-100 hover:shadow-xl hover:bg-amber-50 transform hover:scale-[1.02] transition duration-300 ease-in-out">
                    <div class="inline-block p-4 rounded-full bg-amber-100 text-amber-600 mb-4 transition-colors group-hover:bg-amber-600 group-hover:text-white">
                        <x-lucide-user-plus class="w-8 h-8" />
                    </div>
                    <p class="font-bold text-lg text-gray-800">Add Member</p>
                    <p class="text-sm text-gray-500 mt-1">Onboard a new member</p>
                </a>

                {{-- ACTION: New Event (Amber) --}}
                <a href="{{ route('church.events.create') }}"
                    class="group bg-white p-6 rounded-2xl text-center shadow-lg border border-amber-100 hover:shadow-xl hover:bg-amber-50 transform hover:scale-[1.02] transition duration-300 ease-in-out">
                    <div class="inline-block p-4 rounded-full bg-amber-100 text-amber-600 mb-4 transition-colors group-hover:bg-amber-600 group-hover:text-white">
                        <x-lucide-calendar-plus class="w-8 h-8" />
                    </div>
                    <p class="font-bold text-lg text-gray-800">New Event</p>
                    <p class="text-sm text-gray-500 mt-1">Schedule service/meeting</p>
                </a>

                {{-- ACTION: Record Sunday Collection (Emerald/Money Focus) --}}
                <a href="#"
                    class="group bg-white p-6 rounded-2xl text-center shadow-lg border border-emerald-100 hover:shadow-xl hover:bg-emerald-50 transform hover:scale-[1.02] transition duration-300 ease-in-out">
                    <div class="inline-block p-4 rounded-full bg-emerald-100 text-emerald-600 mb-4 transition-colors group-hover:bg-emerald-600 group-hover:text-white">
                        <x-lucide-gift class="w-8 h-8" />
                    </div>
                    <p class="font-bold text-lg text-gray-800">Record Collection</p>
                    <p class="text-sm text-gray-500 mt-1">Log Tithes & Offerings</p>
                </a>

                {{-- ACTION: Take Attendance (Gray/Utility Focus) --}}
                <a href="#"
                    class="group bg-white p-6 rounded-2xl text-center shadow-lg border border-gray-100 hover:shadow-xl hover:bg-gray-50 transform hover:scale-[1.02] transition duration-300 ease-in-out">
                    <div class="inline-block p-4 rounded-full bg-gray-200 text-gray-600 mb-4 transition-colors group-hover:bg-gray-600 group-hover:text-white">
                        <x-lucide-check-square class="w-8 h-8" />
                    </div>
                    <p class="font-bold text-lg text-gray-800">Take Attendance</p>
                    <p class="text-sm text-gray-500 mt-1">Track presence</p>
                </a>
            </div>
        </div>

        {{--
            ====================================================
            5. MAIN CONTENT PANELS (Events & Collections)
            ====================================================
        --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-16">

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                    <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-100">
                        <h2 class="text-3xl font-extrabold text-gray-800 flex items-center gap-3">
                            <x-lucide-calendar-heart class="w-8 h-8 text-amber-600" />
                            Next Worship Opportunities
                        </h2>
                        <a href="{{ route('church.events.index') }}" class="text-amber-600 hover:text-amber-700 font-semibold text-sm flex items-center gap-1 transition">
                            View Full Calendar <x-lucide-arrow-right class="w-4 h-4" />
                        </a>
                    </div>

                    {{-- Events List --}}
                    <div class="space-y-4">
                        @forelse($upcomingEvents as $event)
                            <a href="#" class="block">
                                <div class="flex items-start gap-4 p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-amber-50 transition-all duration-200 group">
                                    {{-- Date Block --}}
                                    <div class="flex-shrink-0 bg-amber-600 text-white font-bold w-12 h-12 rounded-lg flex flex-col items-center justify-center shadow-md group-hover:shadow-lg transition">
                                        <div class="text-xl leading-none">{{ $event->start_at->format('d') }}</div>
                                        <div class="text-xs uppercase tracking-wider">{{ $event->start_at->format('M') }}</div>
                                    </div>

                                    {{-- Event Details --}}
                                    <div class="flex-1 min-w-0">
                                        <p class="font-extrabold text-gray-900 text-lg leading-snug group-hover:text-amber-800 transition truncate">{{ $event->title }}</p>
                                        <p class="text-sm text-gray-600 mt-0.5">
                                            {{ $event->start_at->format('D, j M • g:i A') }}
                                            @if($event->location)
                                                <span class="font-semibold text-gray-500"> | {{ $event->location }}</span>
                                            @endif
                                        </p>
                                    </div>

                                    {{-- Time Remaining Badge --}}
                                    <span class="flex-shrink-0 text-xs bg-gray-200 text-gray-600 px-3 py-1 rounded-full font-medium self-start">
                                        {{ $event->start_at->diffForHumans() }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-10 text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                <x-lucide-calendar-x-2 class="w-16 h-16 mx-auto mb-4 text-gray-300" />
                                <p class="text-lg font-semibold text-gray-600">No Events Scheduled</p>
                                <p class="text-sm mt-1 text-gray-500">Start planning your next fellowship meeting!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                    <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-100">
                        <h2 class="text-2xl font-extrabold text-gray-800 flex items-center gap-3">
                            <x-lucide-heart-handshake class="w-8 h-8 text-emerald-600" />
                            Recent Collections
                        </h2>
                        <a href="#" class="text-emerald-600 hover:text-emerald-700 font-semibold text-sm flex items-center gap-1">
                            All Records <x-lucide-arrow-right class="w-4 h-4" />
                        </a>
                    </div>

                    {{-- Collections List --}}
                    <div class="space-y-3">
                        @forelse($recentOfferings as $collection)
                            <div class="flex justify-between items-center py-3 px-4 rounded-lg hover:bg-emerald-50 transition border-l-4 border-emerald-300">
                                <div>
                                    <p class="font-bold text-gray-800 text-base leading-tight">{{ $collection->member?->full_name ?? 'Anonymous Gift' }}</p>
                                    {{-- NOTE: You may need to access a type field here if available, e.g., $collection->type --}}
                                    <p class="text-xs text-gray-500 mt-0.5">Collection • {{ $collection->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="font-extrabold text-emerald-700 text-xl flex-shrink-0">
                                    KSh {{ number_format($collection->amount) }} {{-- REPLACED ₦ --}}
                                </p>
                            </div>
                        @empty
                            <div class="text-center py-10 text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                <x-lucide-gift class="w-16 h-16 mx-auto mb-4 text-gray-300" />
                                <p class="text-lg font-semibold text-gray-600">No Recent Collections</p>
                                <p class="text-sm italic mt-1 text-emerald-700">Log your first Sunday Collection!</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8 pt-4 border-t border-gray-100 text-center">
                        <p class="text-sm text-gray-500 font-light italic">
                            Tracking every gift is essential for stewardship.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>