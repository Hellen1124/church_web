<div class="max-w-7xl mx-auto bg-[#FAF7F2] p-6 rounded-2xl shadow-lg border border-amber-100">

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <h2 class="text-2xl font-bold text-[#4B2E05] flex items-center gap-2">
            <i class="fa-solid fa-church text-amber-600"></i>
            Church Directory
        </h2>

        {{-- Search + View Toggle --}}
        <div class="flex items-center gap-3">
            <input 
                wire:model.debounce.500ms="search" 
                type="text" 
                placeholder="Search churches..." 
                class="rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500 text-sm px-4 py-2"
            />

            {{-- View Toggle --}}
           {{-- View Toggle --}}
<div class="flex items-center bg-white border rounded-lg overflow-hidden">
    <button 
        wire:click="setViewMode('grid')" 
        class="px-3 py-2 {{ $viewMode === 'grid' ? 'bg-amber-600 text-white' : 'hover:bg-amber-50 text-gray-600' }}">
        <i class="fa-solid fa-border-all"></i>
    </button>
    <button 
        wire:click="setViewMode('table')" 
        class="px-3 py-2 {{ $viewMode === 'table' ? 'bg-amber-600 text-white' : 'hover:bg-amber-50 text-gray-600' }}">
        <i class="fa-solid fa-table"></i>
    </button>
</div>

        </div>
    </div>

    {{-- Bulk Actions --}}
    @if(count($selected) > 0)
        <div class="bg-amber-50 border border-amber-200 p-4 rounded-lg mb-4 flex items-center justify-between">
            <p class="text-sm text-[#4B2E05] font-medium">
                {{ count($selected) }} selected
            </p>
            <div class="flex gap-2">
                <button wire:click="bulkActivate" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-md text-xs">Activate</button>
                <button wire:click="bulkDeactivate" class="px-3 py-1 bg-yellow-600 hover:bg-yellow-700 text-white rounded-md text-xs">Suspend</button>
                <button wire:click="bulkDelete" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs">Delete</button>
            </div>
        </div>
    @endif

    {{-- Success Message --}}
    @if (session('message'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded-lg mb-4 shadow">
            {{ session('message') }}
        </div>
    @endif

    {{-- ============ GRID VIEW ============ --}}
    @if($viewMode === 'grid')
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($churches as $church)
                <div class="bg-white border border-amber-100 rounded-2xl shadow-sm hover:shadow-md transition-all p-5 relative">
                    {{-- Selection Checkbox --}}
                    <input type="checkbox" wire:model="selected" value="{{ $church->id }}" class="absolute top-4 left-4 rounded text-amber-600 focus:ring-amber-500">

                    {{-- Logo & Name --}}
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ $church->logo ? asset('storage/' . $church->logo) : 'https://via.placeholder.com/60x60?text=Church' }}" 
                            class="w-14 h-14 rounded-full object-cover border border-amber-200" 
                            alt="{{ $church->church_name }}">
                        <div>
                            <h3 class="font-semibold text-[#4B2E05]">{{ $church->church_name }}</h3>
                            <p class="text-sm text-gray-500">{{ $church->domain }}</p>
                        </div>
                    </div>

                    {{-- Details --}}
                    <p class="text-sm text-gray-700"><i class="fa-solid fa-envelope text-amber-600 mr-1"></i> {{ $church->church_email }}</p>
                    <p class="text-sm text-gray-700"><i class="fa-solid fa-phone text-amber-600 mr-1"></i> {{ $church->church_mobile }}</p>

                    {{-- Status Badge --}}
                    <div class="mt-4 flex justify-between items-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($church->status === 'active') bg-green-100 text-green-700
                            @elseif($church->status === 'suspended') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-600 @endif">
                            {{ ucfirst($church->status ?? 'unknown') }}
                        </span>
                        <a href="#" class="text-amber-600 hover:underline text-sm font-medium">Manage</a>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500 py-10">No churches found.</p>
            @endforelse
        </div>

    {{-- ============ TABLE VIEW ============ --}}
    @else
        <div class="overflow-x-auto bg-white border border-amber-100 rounded-2xl shadow-sm">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-amber-100 text-[#4B2E05]">
                    <tr>
                        <th class="p-3"><input type="checkbox" class="rounded text-amber-600" wire:model="selectAll"></th>
                        <th class="p-3">Church</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Domain</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($churches as $church)
                        <tr class="border-t hover:bg-amber-50">
                            <td class="p-3"><input type="checkbox" wire:model="selected" value="{{ $church->id }}" class="rounded text-amber-600"></td>
                            <td class="p-3 font-medium">{{ $church->church_name }}</td>
                            <td class="p-3">{{ $church->church_email }}</td>
                            <td class="p-3 text-amber-700">{{ $church->domain }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($church->status === 'active') bg-green-100 text-green-700
                                    @elseif($church->status === 'suspended') bg-yellow-100 text-yellow-700
                                    @else bg-gray-100 text-gray-600 @endif">
                                    {{ ucfirst($church->status ?? 'unknown') }}
                                </span>
                            </td>
                            <td class="p-3 text-right">
                                <a href="#" class="text-amber-600 hover:underline text-xs font-medium">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">No churches found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $churches->links() }}
    </div>
</div>



