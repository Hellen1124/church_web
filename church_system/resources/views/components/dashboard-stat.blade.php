
@props(['title', 'value' => '—', 'iconColor' => 'text-gray-600', 'trendChange' => null, 'valueClass' => 'text-gray-900'])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 rounded-2xl shadow p-4 flex items-center gap-4 border border-gray-200 dark:border-gray-700']) }}>
    <div class="flex-shrink-0">
        <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
            <svg class="w-6 h-6 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
            </svg>
        </div>
    </div>
    <div class="flex-1 min-w-0">
        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $title }}</div>
        <div class="mt-1 flex items-baseline gap-2">
            <div class="text-2xl font-semibold {{ $valueClass }}">{{ $value }}</div>
            @if($trendChange)
                <div class="text-sm text-gray-400">{{ $trendChange }}</div>
            @endif
        </div>
    </div>
</div>
