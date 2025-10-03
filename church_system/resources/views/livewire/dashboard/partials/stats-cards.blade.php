

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    @foreach($stats as $stat)
        <div 
            class="bg-white p-4 rounded-xl shadow hover:shadow-md transition cursor-pointer"
            @if(!empty($stat['route']))
                onclick="window.location='{{ route($stat['route']) }}'"
            @endif
        >
            <h2 class="text-xl font-semibold text-gray-700">
                {{ $stat['title'] }}
            </h2>

            <p class="text-3xl font-bold {{ $stat['color'] ?? 'text-gray-800' }}">
                {{ $stat['value'] }}
            </p>

            @if(!empty($stat['note']))
                <p class="text-sm text-gray-500 mt-1">
                    {{ $stat['note'] }}
                </p>
            @endif
        </div>
    @endforeach
</div>
