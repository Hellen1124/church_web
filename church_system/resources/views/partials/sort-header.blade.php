<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
    wire:click="setSortBy('{{ $field }}')">
    <div class="flex items-center">
        {{ $label }}
        {{-- Arrow indicator for current sorting direction --}}
        @if ($sortBy === $field)
            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path>
            </svg>
        @endif
    </div>
</th>