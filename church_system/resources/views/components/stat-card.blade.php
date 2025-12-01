<div class="bg-white rounded-2xl shadow-lg border border-{{ $color }}-100 p-6 hover:shadow-xl transition">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
            <p class="text-3xl font-bold mt-2 text-gray-900">
                {{ is_numeric($value) ? number_format($value) : $value }}
            </p>
            @if($subtitle)
                <p class="text-xs text-gray-500 mt-2">{{ $subtitle }}</p>
            @endif
        </div>
        <div class="w-14 h-14 rounded-full flex items-center justify-center bg-{{ $color }}-100 text-{{ $color }}-600">
            <i class="fa {{ $icon }} text-2xl"></i>
        </div>
    </div>
</div>