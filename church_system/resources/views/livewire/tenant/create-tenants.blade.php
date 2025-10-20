<div class="p-6 max-w-5xl mx-auto space-y-6">
    {{-- Header --}}
    <div>
        <h2 class="text-2xl font-semibold text-gray-800">Register New Tenant</h2>
        <p class="text-gray-500 text-sm">Fill in the details below to create a new church tenant.</p>
    </div>

    {{-- Form --}}
    <x-card class="shadow-sm rounded-2xl p-6">
        <form wire:submit.prevent="save" class="space-y-6">

            {{-- Basic Info --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <x-input wire:model.defer="church_name" label="Church Name" placeholder="e.g. Grace Fellowship Church" required />
                <x-input wire:model.defer="church_mobile" label="Mobile Number" placeholder="+254 700 000 000" required />
                <x-input wire:model.defer="church_email" type="email" label="Church Email" placeholder="info@church.org" required />
                <x-input wire:model.defer="domain" label="Domain" placeholder="gracefellowship.org" required />
            </div>

            {{-- Additional Info --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <x-input wire:model.defer="website" type="url" label="Website" placeholder="https://gracefellowship.org" />
                <x-input wire:model.defer="location" label="Location" placeholder="Nairobi, Kenya" />
                <x-input wire:model.defer="vat_pin" label="VAT PIN" placeholder="A1234567B" />
                <x-input wire:model.defer="kra_pin" label="KRA PIN" placeholder="P051234567C" />
            </div>

            {{-- Address --}}
            <x-textarea wire:model.defer="address" label="Address" placeholder="Enter physical address or postal details" rows="3" />

            {{-- Logo Upload --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                <div>
                    <x-input wire:model="logo_image" type="file" label="Logo Image" accept="image/*" />
                    <small class="text-gray-500 text-xs">Accepted formats: JPG, PNG, Max size: 2MB</small>
                    @error('logo_image') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                @if ($logo_image)
                    <div class="flex justify-center">
                        <img src="{{ $logo_image->temporaryUrl() }}" class="h-24 w-24 rounded-full object-cover border" alt="Preview">
                    </div>
                @endif
            </div>

            {{-- Status --}}
            <div class="flex items-center gap-3">
                <x-toggle wire:model.defer="is_active" label="Active" />
                <span class="text-gray-500 text-sm">Toggle to deactivate this tenant upon creation.</span>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3">
                <x-button flat label="Cancel" href="{{ route('tenants.index') }}" />
                <x-button primary type="submit" spinner="save" icon="check" label="Create Tenant" />
            </div>
        </form>
    </x-card>
</div>

