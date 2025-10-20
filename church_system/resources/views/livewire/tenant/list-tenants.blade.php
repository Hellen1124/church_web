<div class="p-6 space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Tenant Management</h2>
            <p class="text-gray-500 text-sm">View, search, and manage all registered church tenants.</p>
        </div>

        <x-button primary icon="plus" label="Register New Tenant" href="{{ route('tenants.create') }}" />
    </div>

    {{-- Search & Filters --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <x-input wire:model.debounce.500ms="search"
                 placeholder="Search by church name, domain, or email..."
                 icon="search"
                 class="w-full sm:w-1/3" />
    </div>

    {{-- Tenant Table --}}
    <x-card class="shadow-sm rounded-2xl overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Logo</th>
                    <th class="px-4 py-3 text-left">Church Name</th>
                    <th class="px-4 py-3 text-left">Domain</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Mobile</th>
                    <th class="px-4 py-3 text-left">Location</th>
                    <th class="px-4 py-3 text-left">Website</th>
                    <th class="px-4 py-3 text-left">VAT / KRA PIN</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                    <tr class="border-b hover:bg-gray-50 transition">
                        {{-- Logo --}}
                        <td class="px-4 py-3">
                            @if($tenant->logo_image)
                                <img src="{{ asset('storage/'.$tenant->logo_image) }}"
                                     alt="Logo"
                                     class="w-10 h-10 rounded-full object-cover border" />
                            @else
                                <div class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-full text-gray-500">
                                    <x-icon name="building-church" class="w-5 h-5" />
                                </div>
                            @endif
                        </td>

                        {{-- Church Details --}}
                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $tenant->church_name }}
                        </td>

                        <td class="px-4 py-3">
                            <a href="http://{{ $tenant->domain }}" target="_blank" class="text-primary-600 hover:underline">
                                {{ $tenant->domain }}
                            </a>
                        </td>

                        <td class="px-4 py-3">{{ $tenant->church_email }}</td>
                        <td class="px-4 py-3">{{ $tenant->church_mobile }}</td>
                        <td class="px-4 py-3">{{ $tenant->location }}</td>
                        <td class="px-4 py-3">
                            @if($tenant->website)
                                <a href="{{ $tenant->website }}" target="_blank" class="text-blue-600 hover:underline">
                                    {{ $tenant->website }}
                                </a>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            <div>
                                <div><span class="font-semibold">VAT:</span> {{ $tenant->vat_pin ?? '—' }}</div>
                                <div><span class="font-semibold">KRA:</span> {{ $tenant->kra_pin ?? '—' }}</div>
                            </div>
                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-3 text-center">
                            @if($tenant->is_active)
                                <x-badge flat positive label="Active" />
                            @else
                                <x-badge flat negative label="Inactive" />
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-4 py-3 text-right space-x-2">
                            <x-button flat icon="eye" primary label="View"
                                      href="{{ route('tenants.show', $tenant->id) }}" />
                            <x-button flat icon="pencil" secondary label="Edit"
                                      href="{{ route('tenants.edit', $tenant->id) }}" />
                            <x-button flat icon="trash" negative label="Delete"
                                      wire:click="deleteTenant({{ $tenant->id }})"
                                      x-on:confirm="{
                                          title: 'Delete Tenant?',
                                          description: 'Are you sure you want to delete {{ $tenant->church_name }}?',
                                          icon: 'warning',
                                          accept: { label: 'Yes, Delete', method: 'deleteTenant', params: {{ $tenant->id }} },
                                          reject: { label: 'Cancel' }
                                      }" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-gray-500 py-8">
                            No tenants found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-card>

    {{-- Pagination --}}
    <div>
        {{ $tenants->links() }}
    </div>
</div>
