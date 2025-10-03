

<div class="bg-white p-6 rounded-xl shadow mb-6">
    <h2 class="text-2xl font-semibold mb-4">{{ $title ?? 'Upcoming Events' }}</h2>

    @forelse($items as $item)
        <div class="border-b py-2 flex justify-between items-center">
            <div>
                <strong class="text-gray-800">
                    {{ $item[$labelField] ?? 'Untitled' }}
                </strong>

                @if(!empty($dateField) && !empty($item[$dateField]))
                    <span class="block text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($item[$dateField])->format('M d, Y') }}
                    </span>
                @endif
            </div>

            @if(!empty($routeName))
                <a href="{{ route($routeName, $item[$idField] ?? null) }}"
                   class="text-blue-600 text-sm hover:underline">
                   View
                </a>
            @endif
        </div>
    @empty
        <p class="text-gray-500">{{ $emptyMessage ?? 'No upcoming events.' }}</p>
    @endforelse
</div>
