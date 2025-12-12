{{-- LINK TEMPLATE (unchanged logic, improved micro-interactions) --}}
@php
    use Illuminate\Support\Facades\Route;
    $isActive = request()->routeIs($route);
    $href = Route::has($route) ? route($route) : '#';
@endphp

<a href="{{ $href }}"
   class="group relative flex items-center gap-4 px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-150"
   :class="{
       'bg-amber-100 text-amber-900 font-bold shadow-md shadow-amber-200/40' : {{ $isActive }},
       'text-gray-700 hover:bg-amber-50 hover:text-amber-800' : !{{ $isActive }}
   }"
   x-data="{ hover: false }"
   @mouseenter="hover = true" @mouseleave="hover = false">

    <i data-lucide="{{ $icon }}"
       class="w-5 h-5 transition-all"
       :class="{
           'text-amber-800 scale-[1.08]' : {{ $isActive }},
           'text-amber-600 group-hover:scale-[1.12] group-hover:text-amber-700' : !{{ $isActive }}
       }}">
    </i>

    <span x-show="open" x-transition.opacity>{{ $label }}</span>

    @if(isset($badge))
        <span x-show="open"
              class="ml-auto text-xs px-3 py-1 rounded-full bg-amber-200 text-amber-900 font-bold shadow-sm">
            {{ $badge }}
        </span>
    @endif

    <!-- Tooltip when collapsed -->
    <div x-show="!open && hover"
         class="absolute left-full ml-4 px-4 py-2 bg-gray-900 text-white text-sm rounded-lg shadow-2xl whitespace-nowrap z-50"
         x-transition>
        {{ $label }} @if(isset($badge)) • {{ $badge }} @endif
        <div class="absolute top-1/2 -left-3 w-0 h-0 border-t-8 border-b-8 border-r-8 border-transparent border-r-gray-900"></div>
    </div>
</a>

