

<div class="bg-white p-6 rounded-xl shadow mb-6">
    <h2 class="text-2xl font-semibold mb-4">{{ $title ?? 'Recent Activities' }}</h2>

    <ul>
        @forelse($activities as $activity)
            <li class="border-b py-2 text-gray-700">
                {{ $activity['description'] ?? 'No description' }}
            </li>
        @empty
            <li class="py-2 text-gray-500">
                {{ $emptyMessage ?? 'No recent activities.' }}
            </li>
        @endforelse
    </ul>
</div>
