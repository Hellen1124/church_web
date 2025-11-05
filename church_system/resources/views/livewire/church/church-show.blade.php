<div class="max-w-5xl mx-auto bg-[#FAF7F2] rounded-2xl shadow-lg p-8 border border-amber-100">

    {{-- Title --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-[#4B2E05] flex items-center">
            <i class="fa fa-church text-amber-600 mr-2"></i>
            Church Details
        </h2>

        <a href="{{ route('admin.tenants.index') }}"
           class="text-amber-700 hover:text-amber-900 font-semibold text-sm flex items-center">
            <i class="fa fa-arrow-left mr-1"></i> Back to List
        </a>
    </div>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4 shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Church Info Card --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="col-span-1 flex flex-col items-center">
            <img src="{{ $church->logo }}" alt="Logo"
                 class="h-32 w-32 rounded-full border-4 border-amber-200 shadow-md object-cover mb-4">
            <h3 class="text-lg font-semibold text-[#4B2E05]">{{ $church->church_name }}</h3>
            <p class="text-sm text-gray-600">{{ $church->domain }}</p>

            <div class="mt-3">
                @if ($church->is_active)
                    <span class="px-3 py-1 text-xs bg-green-100 text-green-800 rounded-full">Active</span>
                @else
                    <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full">Inactive</span>
                @endif
            </div>

            <button wire:click="toggleStatus"
                class="mt-4 bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg shadow-md transition text-sm">
                {{ $church->is_active ? 'Deactivate' : 'Activate' }} Church
            </button>
        </div>

        <div class="col-span-2 bg-white rounded-xl shadow-md p-6 border border-amber-100">
            <h4 class="text-lg font-semibold text-[#4B2E05] mb-4">Church Information</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <p><strong class="text-[#5C3D1E]">Email:</strong> {{ $church->church_email }}</p>
                <p><strong class="text-[#5C3D1E]">Mobile:</strong> {{ $church->church_mobile }}</p>
                <p><strong class="text-[#5C3D1E]">Address:</strong> {{ $church->address }}</p>
                <p><strong class="text-[#5C3D1E]">Location:</strong> {{ $church->location }}</p>
                <p><strong class="text-[#5C3D1E]">Website:</strong> 
                    <a href="{{ $church->website }}" target="_blank" class="text-amber-700 hover:underline">
                        {{ $church->website ?? '—' }}
                    </a>
                </p>
                <p><strong class="text-[#5C3D1E]">VAT PIN:</strong> {{ $church->vat_pin }}</p>
                <p><strong class="text-[#5C3D1E]">KRA PIN:</strong> {{ $church->kra_pin }}</p>
                <p><strong class="text-[#5C3D1E]">Created:</strong> {{ $church->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Admin Info Card --}}
    <div class="bg-white rounded-xl shadow-md p-6 border border-amber-100">
        <h4 class="text-lg font-semibold text-[#4B2E05] mb-4 flex items-center">
            <i class="fa fa-user-shield text-amber-600 mr-2"></i> Church Admin
        </h4>
        @if ($church->user)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <p><strong class="text-[#5C3D1E]">Name:</strong>
                    {{ $church->user->first_name }} {{ $church->user->last_name }}</p>
                <p><strong class="text-[#5C3D1E]">Email:</strong> {{ $church->user->email }}</p>
                <p><strong class="text-[#5C3D1E]">Phone:</strong> {{ $church->user->phone }}</p>
                <p><strong class="text-[#5C3D1E]">Role:</strong>
                    @foreach($church->user->roles as $role)
                        <span class="px-2 py-1 bg-amber-100 text-amber-800 rounded-full text-xs">{{ $role->name }}</span>
                    @endforeach
                </p>
            </div>
        @else
            <p class="text-gray-500 italic">No admin user associated with this church yet.</p>
        @endif
    </div>

</div>
