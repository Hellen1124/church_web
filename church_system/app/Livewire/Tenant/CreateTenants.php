<?php


namespace App\Livewire\Tenant;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Tenant;
use WireUi\Traits\WireUiActions;

class CreateTenants extends Component
{
    use WithFileUploads, WireUiActions;

    public $user_id;
    public $church_name;
    public $church_mobile;
    public $church_email;
    public $address;
    public $logo_image;
    public $location;
    public $website;
    public $vat_pin;
    public $kra_pin;
    public $domain;
    public $is_active = true;

    protected $rules = [
        'church_name'   => 'required|string|max:255',
        'church_mobile' => 'required|string|max:20',
        'church_email'  => 'required|email|unique:tenants,church_email',
        'address'       => 'nullable|string|max:500',
        'logo_image'    => 'nullable|image|max:2048', // 2MB
        'location'      => 'nullable|string|max:255',
        'website'       => 'nullable|url|max:255',
        'vat_pin'       => 'nullable|string|max:50',
        'kra_pin'       => 'nullable|string|max:50',
        'domain'        => 'required|string|unique:tenants,domain|max:255',
        'is_active'     => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        $path = $this->logo_image
            ? $this->logo_image->store('tenant_logos', 'public')
            : null;

        Tenant::create([
            'user_id'       => auth()->id(),
            'church_name'   => $this->church_name,
            'church_mobile' => $this->church_mobile,
            'church_email'  => $this->church_email,
            'address'       => $this->address,
            'logo_image'    => $path,
            'location'      => $this->location,
            'website'       => $this->website,
            'vat_pin'       => $this->vat_pin,
            'kra_pin'       => $this->kra_pin,
            'domain'        => $this->domain,
            'is_active'     => $this->is_active,
        ]);

        $this->notification()->success(
            $title = 'Tenant Created',
            $description = 'New tenant registered successfully.'
        );

        return redirect()->route('tenants.index');
    }

    public function render()
    {
        return view('livewire.tenant.create-tenant');
    }
}
