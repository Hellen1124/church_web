<div class="p-6 max-w-5xl mx-auto space-y-6">
    {{-- Header --}}
    <div>
        <h2 class="text-2xl font-semibold text-gray-800">Edit Tenant</h2>
        <p class="text-gray-500 text-sm">Update the details of this church tenant.</p>
    </div>

    {{-- Form --}}
    <x-card class="shadow-sm rounded-2xl p-6">
        <form wire:submit.prevent="save" class="space-y-6">

            {{-- Basic Info --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <x-input wire:model.defer="tenant.church_name" label="Church Name" required />
                <x-input wire:model.defer="tenant.church_mobile" label="Mobile Number" required />
                <x-input wire:model.defer="tenant.church_email" type="email" label="Church Email" required />
                <x-input wire:model.defer="tenant.domain" label="Domain" required />
            </div>

            {{-- Additional Info --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <x-input wire:model.defer="tenant.website" type="url" label="Website" />
                <x-input wire:model.defer="tenant.location" label="Location" />
                <x-input wire:model.defer="tenant.vat_pin" label="VAT PIN" />
                <x-input wire:model.defer="tenant.kra_pin" label="KRA PIN" />
            </div>

            {{-- Address --}}
            <x-textarea wire:model.defer="tenant.address" label="Address" rows="3" />

            {{-- Logo Upload --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                <div>
                    <x-input wire:model="logo_image" type="file" label="Replace Logo" accept="image/*" />
                    <small class="text-gray-500 text-xs">Leave empty to keep the current logo</small>
                    @error('logo_image') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-center">
                    @if ($logo_image)
                        <img src="{{ $logo_image->temporaryUrl() }}" class="h-24 w-24 rounded-full object-cover border" alt="Preview">
                    @elseif ($tenant->logo_image)
                        <img src="{{ asset('storage/'.$tenant->logo_image) }}" class="h-24 w-24 rounded-full object-cover border" alt="Logo">
                    @else
                        <div class="h-24 w-24 flex items-center justify-center bg-gray-200 rounded-full text-gray-500">
                            <x-icon name="building-church" class="w-8 h-8" />
                        </div>
                    @endif
                </div>
            </div>

            {{-- Status --}}
            <div class="flex items-center gap-3">
                <x-toggle wire:model.defer="tenant.is_active" label="Active" />
                <span class="text-gray-500 text-sm">Toggle tenant availability.</span>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3">
                <x-button flat label="Cancel" href="{{ route('tenants.index') }}" />
                <x-button primary type="submit" spinner="save" icon="check" label="Save Changes" />
            </div>
        </form>
    </x-card>
</div>

