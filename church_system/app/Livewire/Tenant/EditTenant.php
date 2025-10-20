<?php


namespace App\Livewire\Tenant;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Tenant;
use WireUi\Traits\WireUiActions;

class EditTenant extends Component
{
    use WithFileUploads, WireUiActions;

    public Tenant $tenant;
    public $logo_image; // new upload

    protected $rules = [
        'tenant.church_name'   => 'required|string|max:255',
        'tenant.church_mobile' => 'required|string|max:20',
        'tenant.church_email'  => 'required|email|unique:tenants,church_email,{tenant.id}',
        'tenant.address'       => 'nullable|string|max:500',
        'tenant.location'      => 'nullable|string|max:255',
        'tenant.website'       => 'nullable|url|max:255',
        'tenant.vat_pin'       => 'nullable|string|max:50',
        'tenant.kra_pin'       => 'nullable|string|max:50',
        'tenant.domain'        => 'required|string|unique:tenants,domain,{tenant.id}|max:255',
        'tenant.is_active'     => 'boolean',
        'logo_image'           => 'nullable|image|max:2048',
    ];

    public function mount(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function save()
    {
        $this->validate();

        // Handle logo update if a new one is uploaded
        if ($this->logo_image) {
            $path = $this->logo_image->store('tenant_logos', 'public');
            $this->tenant->logo_image = $path;
        }

        $this->tenant->save();

        $this->notification()->success(
            $title = 'Tenant Updated',
            $description = 'Tenant details have been successfully updated.'
        );

        return redirect()->route('tenants.index');
    }

    public function render()
    {
        return view('livewire.tenant.edit-tenant');
    }
}
