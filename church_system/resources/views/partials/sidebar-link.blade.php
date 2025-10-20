@php
    $isActive = $route !== '#' && request()->routeIs($route); 
    $linkHref = $route === '#' ? '#' : route($route);
@endphp

<a href="{{ $linkHref }}"
   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-150
          {{ $isActive 
              ? 'bg-amber-100 text-amber-800 font-semibold shadow-sm' 
              : 'text-stone-700 hover:bg-amber-50 hover:text-amber-700' }}
          focus:outline-none focus:ring-2 focus:ring-amber-300"
>
    <i class="fa {{ $icon }} w-5 me-3 transition-transform duration-200 group-hover:scale-110 
        {{ $isActive ? 'text-amber-700' : 'text-amber-600 group-hover:text-amber-700' }}"></i>
    <span>{{ $label }}</span>
</a>

