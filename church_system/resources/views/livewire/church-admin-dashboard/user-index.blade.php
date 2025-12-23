<div class="p-6 bg-white shadow-xl sm:rounded-lg">
    {{-- Check if the user is authorized to even see the page --}}
    @can('view users')
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">
            Church Users Management 
        </h2>

        {{-- Top Bar: Search and Create Button --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
            <x-input 
                placeholder="Search by name or email..." 
                wire:model.live.debounce.300ms="search" 
                class="w-full md:w-1/3"
                icon="magnifying-glass"
            />
            
            @can('create users')
                {{-- Link to the Create User component --}}
                <a href="{{ route('church.users.create') }}">
                    <x-button label="Create New User" primary icon="plus" lg />
                </a>
            @endcan
        </div>

        {{-- Users Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('first_name')">
                            Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('email')">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role(s)
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('created_at')">
                            Created
                        </th>
                        <th class="px-6 py-3"></th> {{-- Actions column --}}
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @foreach ($user->roles as $role)
                                    <x-badge 
                                        label="{{ ucwords(str_replace('-', ' ', $role->name)) }}" 
                                        class="bg-blue-100 text-blue-800" 
                                    />
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                {{-- Edit Button (Visible only if user has permission AND user belongs to tenant) --}}
                                @can('update users')
                                    @if ($user->tenant_id === auth()->user()->tenant_id)
                                        <a href="#">
                                            <x-button icon="pencil" flat primary />
                                        </a>
                                    @endif
                                @endcan

                                {{-- Delete Button (Visible only if user has permission AND user belongs to tenant) --}}
                                @can('delete users')
                                    @if ($user->tenant_id === auth()->user()->tenant_id)
                                        <x-button 
                                            icon="trash" 
                                            flat negative 
                                            wire:click="deleteUser({{ $user->id }})"
                                            wire:confirm="Are you sure you want to delete this user? This action cannot be undone."
                                        />
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No users found for this church.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
        
    @else
        <div class="text-red-600 font-semibold p-4 border border-red-200 bg-red-50 rounded-md">
            Permission Denied: You do not have the 'view users' permission to access this page.
        </div>
    @endcan
</div>