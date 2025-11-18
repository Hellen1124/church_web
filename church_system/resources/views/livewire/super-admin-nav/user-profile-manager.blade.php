<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Account Settings</h1>
    
    <div class="lg:grid lg:grid-cols-12 lg:gap-x-8">
        
        {{-- 1. Settings Sidebar Navigation (Col 3) --}}
        <div class="py-6 lg:col-span-3">
            <nav class="space-y-1">
                {{-- General Information Tab --}}
                <a href="#" wire:click.prevent="setTab('general')"
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition
                       {{ $activeTab === 'general' ? 'bg-amber-100 text-amber-800 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa fa-user-circle mr-3 w-5"></i>
                    General Information
                </a>
                
                {{-- Security Tab --}}
                <a href="#" wire:click.prevent="setTab('security')"
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition
                       {{ $activeTab === 'security' ? 'bg-amber-100 text-amber-800 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa fa-lock mr-3 w-5"></i>
                    Security & Authentication
                </a>

                {{-- Preferences Tab --}}
                <a href="#" wire:click.prevent="setTab('preferences')"
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition
                       {{ $activeTab === 'preferences' ? 'bg-amber-100 text-amber-800 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa fa-cog mr-3 w-5"></i>
                    Preferences
                </a>
            </nav>
        </div>

        {{-- 2. Settings Content Area (Col 9) --}}
        <div class="space-y-6 lg:col-span-9">
            
            @if ($activeTab === 'general')
                {{-- 🚀 This loads the profile form content below --}}
                <div class="bg-white shadow rounded-xl p-6 border border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 border-b pb-3">Profile Details</h2>
                    @livewire('system-admin.update-profile-information-form')
                </div>
            @elseif ($activeTab === 'security')
                <div class="bg-white shadow rounded-xl p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Account Security</h2>
                    <p class="text-gray-600">Security content will go here.</p>
                </div>
            @elseif ($activeTab === 'preferences')
                <div class="bg-white shadow rounded-xl p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Display & Notifications</h2>
                    <p class="text-gray-600">Preferences content will go here.</p>
                </div>
            @endif

        </div>
    </div>
</div>
