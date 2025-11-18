<?php


namespace App\Livewire\Church;

use App\Models\Tenant;
use App\Models\User;
use App\Models\Member;
use App\Models\Role;
use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;

class ChurchCreate extends Component
{
    use WithFileUploads, WireUiActions;

    public bool $isSaving = false;

    // Tenant (church) fields
    public $church_name, $church_email, $church_mobile, $address, $domain;
    public $location, $website, $vat_pin, $kra_pin;

    // Admin user fields
    public $first_name, $last_name, $email, $phone, $password;

    // Logo
    public $logo_file = null;
    public $logo_url = '';
    public $logoPreview = null;

    protected $rules = [
        'church_name'   => 'required|string|max:255',
        'church_email'  => 'required|email|max:255|unique:tenants,church_email',
        'church_mobile' => 'required|string|max:20',
        'address'       => 'nullable|string|max:255',
        'location'      => 'nullable|string|max:255',
        'website'       => 'nullable|url|max:255',
        'vat_pin'       => 'nullable|string|max:50',
        'kra_pin'       => 'nullable|string|max:50',
        'domain'        => 'required|string|max:255|unique:tenants,domain',

        'first_name'    => 'required|string|max:255',
        'last_name'     => 'nullable|string|max:255',
        'email'         => 'required|email|max:255|unique:users,email',
        'phone'         => 'required|string|max:20|unique:users,phone',
        'password'      => 'required|string|min:8|max:255',

        'logo_file'     => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
        'logo_url'      => 'nullable|url',
    ];

    protected $messages = [
        'logo_file.image' => 'The file must be an image.',
        'logo_file.max'   => 'Logo must not exceed 2MB.',
        'logo_url.url'    => 'Please enter a valid image URL.',
    ];

    public function updatedLogoFile()
    {
        $this->updateLogoPreview();
    }

    public function updatedLogoUrl()
    {
        $this->updateLogoPreview();
    }

    private function updateLogoPreview()
    {
        if ($this->logo_file) {
            $this->logoPreview = $this->logo_file->temporaryUrl();
        } elseif ($this->logo_url && filter_var($this->logo_url, FILTER_VALIDATE_URL)) {
            $this->logoPreview = $this->logo_url;
        } else {
            $this->logoPreview = null;
        }
    }

    public function confirmSave()
    {
        $this->notification()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Save the information?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, save it',
                'method' => 'save',
                'params' => 'Saved',
            ],
            'reject' => [
                'label' => 'No, cancel',
                'method' => 'cancel',
            ],
        ]);
    }

    public function save()
    {
        Log::info('✅ Save method triggered in Livewire component');

        $otpService = app(OtpService::class);
        if ($this->isSaving) return;

        $this->isSaving = true;

        $validated = $this->validate();
        Log::info('STEP 2: Validation passed');

        DB::beginTransaction();
        Log::info('STEP 2 ✅ Transaction started');

        try {
            $logoPath = null;

            if ($this->logo_file) {
                Log::info('STEP 3: Handling logo_file');
                $logoPath = $this->logo_file->store('logos', 'public');
            } elseif ($this->logo_url) {
                Log::info('STEP 3: Handling logo_url');
                try {
                    $contents = file_get_contents($this->logo_url);
                    $filename = 'logo_' . time() . '_' . uniqid() . '.' .
                        pathinfo(parse_url($this->logo_url, PHP_URL_PATH), PATHINFO_EXTENSION);
                    $logoPath = 'logos/' . $filename;
                    Storage::disk('public')->put($logoPath, $contents);
                } catch (\Exception $e) {
                    $this->addError('logo_url', 'Failed to download image from URL.');
                    $this->isSaving = false;
                    return;
                }
                Log::info('STEP 3 ✅ Logo handled');
            }

            Log::info('STEP 4: Creating Tenant');
            $tenant = Tenant::create([
                'church_name'   => $validated['church_name'],
                'church_email'  => $validated['church_email'],
                'church_mobile' => $validated['church_mobile'],
                'address'       => $validated['address'] ?? null,
                'location'      => $validated['location'] ?? null,
                'website'       => $validated['website'] ?? null,
                'vat_pin'       => $validated['vat_pin'] ?? null,
                'kra_pin'       => $validated['kra_pin'] ?? null,
                'domain'        => $validated['domain'],
                'logo'          => $logoPath,
                'created_by'    => Auth::id(),
                'updated_by'    => Auth::id(),
            ]);
            Log::info('STEP 4 ✅ Tenant created ID=' . $tenant->id);

            Log::info('STEP 5: Creating Admin');
            $user = User::create([
                'tenant_id'  => $tenant->id,
                'first_name' => $validated['first_name'],
                'last_name'  => $validated['last_name'] ?? null,
                'email'      => $validated['email'],
                'phone'      => $validated['phone'],
                'password'   => Hash::make($validated['password']),
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

                // STEP 3️⃣ Update tenant with user_id (now we have $user->id)
    $tenant->update(['user_id' => $user->id]);
            Log::info('STEP 5 ✅ User created ID=' . $user->id);


            Log::info('STEP 6: Assign role');
            $role = Role::firstOrCreate(['name' => 'Church Admin']);
            $user->assignRole('Church Admin');
            Log::info('STEP 6 ✅ Role assigned');

            Log::info('STEP 7: Create member');
            Member::create([
                'tenant_id'     => $tenant->id,
                'membership_no' => $tenant->id . '-001',
                'first_name'    => $user->first_name,
                'last_name'     => $user->last_name,
                'phone'         => $user->phone,
                'email'         => $user->email,
                'date_joined'   => now(),
                'status'        => 'active',
                'role'          => 'admin',
            ]);
            Log::info('STEP 7 ✅ Member created');

            Log::info('STEP 8: Sending OTP');
            $otp = rand(100000, 999999);
            $user->update(['otp_token' => $otp]);
            $otpService->send($user->phone, $otp);
            Log::info('STEP 8 ✅ OTP sent');

            DB::commit();
            Log::info('STEP 9 ✅ COMMIT SUCCESS');

            $this->resetForm();
            $this->notification()->success(
                title: 'Church Created!',
                description: 'Church and admin account created successfully. OTP sent to admin phone.'
            );

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('CreateChurch error: ' . $e->getMessage());

            $this->notification()->error(
                title: 'Error',
                description: 'Failed to create church. Please try again.'
            );
        } finally {
            $this->isSaving = false;
        }
    }

    protected function resetForm()
    {
        $this->reset([
            'church_name', 'church_email', 'church_mobile', 'address', 'domain',
            'location', 'website', 'vat_pin', 'kra_pin',
            'first_name', 'last_name', 'email', 'phone', 'password',
            'logo_file', 'logo_url', 'logoPreview',
        ]);
    }

    public function render()
    {
        return view('livewire.church.church-create');
    }
}



