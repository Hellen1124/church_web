<div class="p-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border-b-4 border-amber-500">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
                        <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-4.418 0-8 2.015-8 4.5V20a1 1 0 001 1h14a1 1 0 001-1v-1.5c0-2.485-3.582-4.5-8-4.5zM19 11l-1-1m0 4l1-1m-4 0l1 1m0-4l-1 1" />
                        </svg>
                        Global Users Directory
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">Manage all users and tenants with administrative control.</p>
                </div>

                <div class="flex gap-3">
                    <button wire:click="$refresh" class="px-5 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition shadow-md text-sm font-medium">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.836 2l-1.5-1.5m-5.418-4v5h.582M12 18V6m0 0l-3 3m3-3l3 3m-8 8H4m16-4h-4"/></svg>
                        Refresh Data
                    </button>
                    <a href="#" class="px-5 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition shadow-md text-sm font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        New User
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 mb-8 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" wire:model.debounce.500ms="search" placeholder="Name, email, or tenant..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 transition shadow-sm text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tenant</label>
                    <select wire:model="tenantFilter" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 transition shadow-sm text-sm">
                        <option value="">All Tenants</option>
                        @foreach($tenants as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select wire:model="roleFilter" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 transition shadow-sm text-sm">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button wire:click="$set('perPage', 100)" class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition text-sm">
                        Showing {{ $users->total() }} users
                    </button>
                </div>
            </div>
        </div>

        <livewire:super-admin-users.user-table :users="$users" />

        <livewire:super-admin-users.impersonate-modal />
    </div>
</div>