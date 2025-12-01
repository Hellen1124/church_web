<div class="bg-white rounded-2xl shadow-lg border border-{{ $color }}-100 p-6">
    <div class="flex items-center gap-4 mb-4">
        <div class="bg-{{ $color }}-100 text-{{ $color }}-600 p-3 rounded-xl flex items-center justify-center">
            <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">{{ $title }}</p>
            <p class="text-xl font-bold">{{ $value }}</p>
        </div>
    </div>
    @if($subtitle)
        <p class="text-xs text-gray-400 mt-2">{{ $subtitle }}</p>
    @endif
</div>
