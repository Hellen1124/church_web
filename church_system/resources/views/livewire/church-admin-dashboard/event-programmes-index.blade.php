<div class="p-6 bg-stone-50 min-h-screen">
<div class="max-w-7xl mx-auto space-y-10">

    <!-- Header -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 pb-6 border-b border-amber-100">
        <h2 class="text-4xl font-bold text-amber-900 flex items-center gap-4">
            <x-lucide-calendar-heart class="w-12 h-12 text-amber-600" />
            Events & Programmes
        </h2>

        @can('create events')
            <a href="{{ route('church.events.create') }}"
               class="inline-flex items-center gap-3 bg-amber-600 hover:bg-amber-700 text-white font-medium px-7 py-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <x-lucide-plus class="w-6 h-6" />
                Create New Event
            </a>
        @endcan
    </div>

    <!-- Search & Filters -->
    <div class="bg-white rounded-2xl shadow-lg border border-amber-100/60 p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 items-center">

            <!-- Search -->
            <div class="md:col-span-2 relative">
                <x-lucide-search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                <input wire:model.live.debounce.300ms="search"
                       type="text"
                       placeholder="Search events by name, location, or description..."
                       class="w-full pl-12 pr-5 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition text-base">
            </div>

            <!-- Toggle Past Events -->
            <label class="flex items-center gap-4 cursor-pointer select-none">
                <input wire:model.live="showPastEvents"
                       type="checkbox"
                       class="w-6 h-6 rounded border-gray-300 text-amber-600 focus:ring-amber-500 focus:ring-2">
                <span class="font-medium text-gray-700 flex items-center gap-2">
                    <x-lucide-history class="w-5 h-5" />
                    Show Past Events
                </span>
            </label>
        </div>
    </div>

    <!-- Events List -->
    <div class="space-y-6">
        @forelse ($events as $event)
            <div class="bg-white rounded-2xl shadow-lg border border-amber-100/50 overflow-hidden hover:border-amber-300 hover:shadow-xl transition-all duration-300 group">
                <div class="p-7 flex flex-col lg:flex-row gap-8">

                    <!-- Date Badge -->
                    <div class="flex-shrink-0 text-center">
                        <div class="bg-gradient-to-br {{ $event->end_at->isPast() ? 'from-red-100 to-pink-100' : 'from-amber-100 to-orange-100' }} 
                                     rounded-2xl px-6 py-4 shadow-md">
                            <p class="text-xs font-bold uppercase tracking-wider text-{{ $event->end_at->isPast() ? 'red-700' : 'amber-800' }}">
                                {{ $event->start_at->isoFormat('ddd') }}
                            </p>
                            <p class="text-4xl font-black text-{{ $event->end_at->isPast() ? 'red-600' : 'amber-700' }} mt-1">
                                {{ $event->start_at->format('j') }}
                            </p>
                            <p class="text-sm font-semibold text-{{ $event->end_at->isPast() ? 'red-700' : 'amber-800' }}">
                                {{ $event->start_at->isoFormat('MMM YYYY') }}
                            </p>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="text-lg font-bold text-gray-800">
                                {{ $event->start_at->format('g:i A') }}
                            </p>
                            @if(!$event->start_at->isSameDay($event->end_at) || $event->start_at->notEqualTo($event->end_at))
                                <p class="text-sm text-gray-500">→ {{ $event->end_at->format('g:i A') }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Event Details -->
                    <div class="flex-grow space-y-3">
                        <h3 class="text-2xl font-bold text-gray-900 group-hover:text-amber-700 transition">
                            <a href="#" class="hover:underline">
                                {{ $event->name }}
                            </a>
                        </h3>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                            @if($event->location)
                                <span class="flex items-center gap-2">
                                    <x-lucide-map-pin class="w-4 h-4 text-amber-600" />
                                    {{ $event->location }}
                                </span>
                            @endif

                            @if($event->capacity)
                                <span class="flex items-center gap-2">
                                    <x-lucide-users class="w-4 h-4 text-amber-600" />
                                    {{ number_format($event->capacity) }} seats
                                </span>
                            @endif
                        </div>

                        @if($event->description)
                            <p class="text-gray-700 leading-relaxed mt-2">
                                {{ str($event->description)->limit(180) }}
                            </p>
                        @endif
                    </div>

                    <!-- Action Buttons and Status -->
                    <div class="flex-shrink-0 flex flex-col md:flex-row-reverse md:justify-end md:items-start gap-4 mt-4 lg:mt-0">
                        
                        {{-- Action Group --}}
                        <div class="flex flex-col sm:flex-row md:flex-col lg:flex-row gap-3">
                            
                           {{-- Edit Icon --}}
@can('update events')
    <a href="{{ route('church.events.edit', $event) }}"
       class="p-2 text-amber-500 hover:text-amber-600 bg-amber-100 hover:bg-amber-200 rounded-full shadow-md transition transform hover:scale-110"
       aria-label="Edit Event"
       title="Edit Event">
        <x-lucide-edit class="w-5 h-5" />
    </a>
@endcan

{{-- Delete Icon (Using WireUI Dialog for Confirmation) --}}
@can('delete events')
    <button wire:click="confirmEventDeletion({{ $event->id }})"
        class="p-2 text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 rounded-full shadow-md transition transform hover:scale-110"
        title="Delete Event"
        aria-label="Delete Event">
        <x-lucide-trash-2 class="w-5 h-5" />
    </button>
@endcan

                            
                            {{-- View Details Button --}}
                            <a href="{{ route('church.events.show', $event) }}" 
                                class="inline-flex items-center justify-center gap-2 w-full sm:w-auto md:w-full lg:w-auto text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-4 py-2 rounded-full text-sm shadow-sm transition">
                                <x-lucide-eye class="w-4 h-4" />
                                Details
                            </a>
                        </div>

                        {{-- Status Badges --}}
                        @if($event->end_at->isPast())
                            <span class="text-xs text-red-600 font-medium flex items-center gap-1 mt-4">
                                <x-lucide-clock class="w-4 h-4" />
                                Event Ended
                            </span>
                        @elseif($event->start_at->isToday())
                            <span class="text-xs text-emerald-600 font-bold flex items-center gap-1 mt-4">
                                <x-lucide-calendar-check class="w-4 h-4" />
                                Happening Today
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-white rounded-2xl shadow-lg border border-amber-100">
                <x-lucide-calendar-x-2 class="w-20 h-20 mx-auto mb-6 text-gray-300" />
                <p class="text-xl font-medium text-gray-600">No events found</p>
                <p class="text-gray-500 mt-2">Try adjusting your search or create something beautiful!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="flex justify-center pt-8">
        {{ $events->links() }}
    </div>
    
   
</div>
 

</div>
