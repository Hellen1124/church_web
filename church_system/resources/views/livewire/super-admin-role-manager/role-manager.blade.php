<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <div class="sm:flex sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Role & Permission Manager</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Manage roles and permissions securely.
                </p>
            </div>
            <button wire:click="createRole"
                class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg shadow-sm transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create Role
            </button>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Users</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Permissions</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($roleData as $role)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ ucfirst(str_replace(['-', '_'], ' ', $role['name'])) }}
                                        @if ($role['name'] === 'super-admin')
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Critical
                                            </span>
                                        @endif
                                    </div>
                                    @if ($role['description'])
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $role['description'] }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $role['users_count'] > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200' }}">
                                        {{ $role['users_count'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $role['permissions_count'] }} permissions
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    @if ($role['name'] !== 'super-admin')
                                        <button wire:click="editRole({{ $role['id'] }})"
                                                class="text-amber-600 hover:text-amber-900 dark:text-amber-400">
                                            Edit
                                        </button>
                                        <button wire:click="deleteRole({{ $role['id'] }})"
                                                wire:confirm="Delete this role?"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400">
                                            Delete
                                        </button>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400 text-xs italic">
                                            Actions Disabled
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <p class="mt-2">No roles found. Create one to get started.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($showRoleModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition" wire:click="showRoleModal = false"></div>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                    <form wire:submit.prevent="saveRole">
                        <div class="bg-white dark:bg-gray-800 px-6 pt-5 pb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">
                                {{ $roleId ? 'Edit Role' : 'Create Role' }}
                            </h3>

                            <div class="mt-6 grid gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                     <textarea wire:model="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm"></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Permissions</label>
                                    <div class="space-y-4">
                                        @foreach ($permissionGroups as $group => $perms)
                                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                                <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3 capitalize">
                                                    {{ ucfirst(str_replace('-', ' ', $group)) }}
                                                </h4>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    @foreach ($perms as $perm)
                                                        <label class="flex items-center space-x-3 text-sm">
                                                             <input type="checkbox"
                                                                wire:model="selectedPermissions"
                                                                value="{{ $perm['name'] }}"
                                                                class="h-4 w-4 text-amber-500 border-gray-300 rounded focus:ring-amber-500">
                                                            <span class="text-gray-700 dark:text-gray-300">
                                                                {{ ucfirst(str_replace(['-', '_'], ' ', $perm['name'])) }}
                                                            </span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-3 flex flex-col sm:flex-row-reverse gap-3">
                            <button type="submit"
                                    class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg shadow-sm">
                                <span wire:loading.remove wire:target="saveRole">Save Role</span>
                                <span wire:loading wire:target="saveRole">Saving...</span>
                            </button>
                            <button type="button" wire:click="showRoleModal = false"
                                    class="w-full sm:w-auto inline-flex justify-center px-4 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 text-gray-700 dark:text-gray-300 font-medium rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-500">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>