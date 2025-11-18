@php
    use Illuminate\Support\Str;
@endphp

<div class="bg-white rounded-xl shadow-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Details</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verification</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Login</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr class="hover:bg-amber-50 transition duration-150">
                        {{-- USER DETAILS (First and Last Name) --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                {{-- Avatar Initials (First two letters) --}}
                                <div class="w-10 h-10 bg-amber-200 rounded-full flex items-center justify-center text-amber-700 font-semibold text-sm shadow-inner">
                                    {{ Str::substr($user->first_name, 0, 1) }}{{ Str::substr($user->last_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        
                        {{-- TENANT (Using church_name) --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->tenant)
                                <span class="inline-flex items-center px-3 py-0.5 text-xs font-medium bg-amber-100 text-amber-800 rounded-full">
                                    {{ $user->tenant->church_name }}
                                </span>
                            @else
                                <span class="text-red-500 text-sm italic">No Tenant</span>
                            @endif
                        </td>
                        
                        {{-- ROLES --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-1">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex items-center px-3 py-0.5 text-xs font-medium rounded-full 
                                        {{ $role->name === 'super-admin' ? 'bg-red-500 text-white' : 'bg-emerald-100 text-emerald-800' }}">
                                        {{ Str::headline($role->name) }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        
                        {{-- VERIFICATION (Using email_verified_at) --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-0.5 text-xs font-medium rounded-full 
                                {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                            </span>
                        </td>
                        
                        {{-- LAST LOGIN --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->last_login_at?->diffForHumans() ?? 'Never' }}
                        </td>
                        
                        {{-- ACTIONS --}}
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center gap-3">
                                <button wire:click="impersonate({{ $user->id }})" 
                                        class="text-purple-600 hover:text-purple-800 text-sm font-medium transition flex items-center gap-1 group">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-1a3 3 0 013-3h7"/></svg>
                                    Impersonate
                                </button>
                                <a href="#" class="text-gray-500 hover:text-amber-600 transition">Edit</a>
                                <button class="text-red-500 hover:text-red-700 transition">Delete</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 text-lg">
                            No users found matching the current filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
        {{ $users->links() }}
    </div>
</div>