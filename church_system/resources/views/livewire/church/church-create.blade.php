<div class="max-w-4xl mx-auto bg-[#FAF7F2] rounded-2xl shadow-lg p-8 border border-amber-100">

    {{-- Page Title --}}
    <h2 class="text-2xl font-bold text-[#4B2E05] mb-6 flex items-center">
        <i class="fa fa-church text-amber-600 mr-2"></i>
        Register New Church (Tenant)
    </h2>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4 shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Main Form with autocomplete=on --}}
    <form wire:submit.prevent="confirmSave" class="space-y-8" autocomplete="on">

        {{-- ===================== CHURCH INFORMATION ===================== --}}
        <fieldset class="space-y-6">
            <legend class="text-lg font-semibold text-[#5C3D1E] mb-2">Church Information</legend>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Church Name --}}
                <div>
                    <label class="text-sm text-gray-600">Church Name</label>
                    <input 
                        wire:model="church_name" 
                        name="church_name"
                        type="text"
                        autocomplete="organization"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500"
                        placeholder="e.g. Grace Community Church">
                    @error('church_name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Church Email --}}
                <div>
                    <label class="text-sm text-gray-600">Church Email</label>
                    <input 
                        wire:model="church_email" 
                        name="church_email"
                        type="email"
                        autocomplete="email"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500">
                    @error('church_email') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Church Mobile --}}
                <div>
                    <label class="text-sm text-gray-600">Church Mobile</label>
                    <input 
                        wire:model="church_mobile" 
                        name="church_mobile"
                        type="text"
                        autocomplete="tel"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500">
                    @error('church_mobile') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Address --}}
                <div>
                    <label class="text-sm text-gray-600">Address</label>
                    <input 
                        wire:model="address" 
                        name="address"
                        type="text"
                        autocomplete="street-address"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500">
                    @error('address') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Location (City/Region) --}}
                <div>
                    <label class="text-sm text-gray-600">Location</label>
                    <input 
                        wire:model="location" 
                        name="location"
                        type="text"
                        autocomplete="address-level2"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500">
                    @error('location') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Website --}}
                <div>
                    <label class="text-sm text-gray-600">Website</label>
                    <input 
                        wire:model="website" 
                        name="website"
                        type="url"
                        autocomplete="url"
                        placeholder="https://"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500">
                    @error('website') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- VAT PIN --}}
                <div>
                    <label class="text-sm text-gray-600">VAT PIN</label>
                    <input 
                        wire:model="vat_pin" 
                        name="vat_pin"
                        type="text"
                        autocomplete="off"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500">
                    @error('vat_pin') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- KRA PIN --}}
                <div>
                    <label class="text-sm text-gray-600">KRA PIN</label>
                    <input 
                        wire:model="kra_pin" 
                        name="kra_pin"
                        type="text"
                        autocomplete="off"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500">
                    @error('kra_pin') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Domain --}}
                <div class="col-span-2">
                    <label class="text-sm text-gray-600">Domain</label>
                    <input 
                        wire:model="domain" 
                        name="domain"
                        type="text"
                        autocomplete="off"
                        placeholder="e.g. mychurch.org"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500">
                    @error('domain') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Logo Upload / URL (Dual Input) --}}
                <div class="col-span-2 space-y-4">
                    <label class="text-sm text-gray-600 font-medium">Church Logo (optional)</label>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        {{-- File Upload --}}
                        <div class="flex-1">
                            <label class="block text-xs text-gray-500 mb-1">Upload from device</label>
                            <input 
                                wire:model="logo_file" 
                                name="logo_file"
                                type="file"
                                accept="image/*"
                                class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                            @error('logo_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- OR Divider --}}
                        <div class="flex items-center justify-center">
                            <span class="text-gray-400 text-sm">OR</span>
                        </div>

                        {{-- URL Input --}}
                        <div class="flex-1">
                            <label class="block text-xs text-gray-500 mb-1">Paste image URL</label>
                            <input 
                                wire:model.debounce.500ms="logo_url" 
                                name="logo_url"
                                type="url"
                                placeholder="https://example.com/logo.png"
                                class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500 text-sm">
                            @error('logo_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Preview Area --}}
                    @if ($logoPreview)
                        <div class="mt-4">
                            <p class="text-xs text-gray-500 mb-2">Preview:</p>
                            <img src="{{ $logoPreview }}" alt="Logo Preview" class="h-32 w-auto rounded-lg shadow-md border border-amber-200 object-contain bg-white">
                        </div>
                    @endif

                    {{-- Helper Text --}}
                    <p class="text-xs text-gray-500 mt-2">
                        Upload a file (PNG, JPG, SVG) or paste a direct URL to your church logo. Max 2MB recommended.
                    </p>
                </div>
            </div>
        </fieldset>

        {{-- ===================== CHURCH ADMIN ACCOUNT ===================== --}}
        <fieldset class="pt-6 border-t border-amber-200 space-y-6">
            <legend class="text-lg font-semibold text-[#5C3D1E] mb-2">Church Admin Account</legend>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- First Name --}}
                <div>
                    <label class="text-sm text-gray-600">First Name</label>
                    <input 
                        wire:model="first_name" 
                        name="first_name"
                        type="text"
                        autocomplete="given-name"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500">
                    @error('first_name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Last Name --}}
                <div>
                    <label class="text-sm text-gray-600">Last Name</label>
                    <input 
                        wire:model="last_name" 
                        name="last_name"
                        type="text"
                        autocomplete="family-name"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500">
                    @error('last_name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input 
                        wire:model="email" 
                        name="email"
                        type="email"
                        autocomplete="email"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500">
                    @error('email') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="text-sm text-gray-600">Phone</label>
                    <input 
                        wire:model="phone" 
                        name="phone"
                        type="text"
                        autocomplete="tel"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500">
                    @error('phone') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="text-sm text-gray-600">Password</label>
                    <input 
                        wire:model="password" 
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500">
                    @error('password') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>
            </div>
        </fieldset>

        {{-- ===================== SUBMIT BUTTON ===================== --}}
      {{-- ===================== SUBMIT BUTTON ===================== --}}
{{-- ===================== SUBMIT BUTTON ===================== --}}
<div class="flex justify-end pt-6 border-t border-amber-200 mt-8">
    <x-button 
        primary 
        label="Create Church" 
        type="submit" 
        spinner="isSaving" 
        :disabled="$isSaving"
        class="px-10 py-4 text-lg font-bold text-white bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-700 hover:to-amber-600 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 rounded-xl flex items-center gap-3"
    >
        {{-- Church Icon + Text --}}
        <span class="flex items-center gap-2">
            <i class="fa-solid fa-church text-xl"></i>
            <span>Create Church</span>
        </span>

        {{-- Arrow (when not loading) --}}
        <span wire:loading.remove wire:target="confirmSave" class="ml-3">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </span>

        {{-- Spinner (when saving) --}}
        <span wire:loading wire:target="confirmSave" class="ml-3">
            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </span>
    </x-button>
</div>
    </form>
</div>

