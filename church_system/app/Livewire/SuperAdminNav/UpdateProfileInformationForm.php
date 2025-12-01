<?php


namespace App\Livewire\SuperAdminNav;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileInformationForm extends Component
{
    use WithFileUploads;

    public $user;

    // State properties (MUST be defined here to be available in validation and blade)
    public string $first_name = '';
    public string $email = '';
    // 🔑 Fix: Added the public property for the phone number
    public ?string $phone = null; 
    public $new_photo; 
    public $status;

    public function mount(): void
    {
        $this->user = Auth::user();
        
        // 🔑 Fix: Initializing the phone property from the database
        $this->first_name = $this->user->first_name ?? $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone; // Initialize the phone value
    }

    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                // Ensure email is unique except for the current user's ID
                Rule::unique('users')->ignore($this->user->id),
            ],
            // Phone is nullable for System Admin, but validated if present
            'phone' => ['nullable', 'string', 'max:20'], 
            'new_photo' => ['nullable', 'image', 'max:5120'],
        ];
    }

    public function updateProfileInformation(): void
    {
        $validatedData = $this->validate();

        // 1. Handle Photo Upload (using the corrected storage logic)
        if ($this->new_photo) {
            // Delete old photo if it exists
            if ($this->user->profile_photo_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($this->user->profile_photo_path);
            }
            // Store the new photo
            $photoPath = $this->new_photo->store('profile-photos', 'public');
            $this->user->profile_photo_path = $photoPath;
        }

        // 2. Update Basic Fields (including phone)
        $this->user->forceFill([
            'first_name' => $validatedData['first_name'],
            'email' => $validatedData['email'],
            // 🔑 Fix: Now this line will work because 'phone' is guaranteed to be in $validatedData
            'phone' => $validatedData['phone'],
        ])->save();

        // 3. Clean up and notify
        $this->new_photo = null;
        $this->status = 'System Admin profile updated successfully.';
        
        // Refresh the component and dispatch event for navbar update
        $this->user = $this->user->fresh();
        $this->dispatch('profile-updated'); 
    }
    
    public function deleteProfilePhoto(): void
    {
        if ($this->user->profile_photo_path) {
            // Delete file from storage
            \Illuminate\Support\Facades\Storage::disk('public')->delete($this->user->profile_photo_path);
            
            // Clear the path from the database
            $this->user->profile_photo_path = null;
            $this->user->save();
            
            // Refresh and set status
            $this->user = $this->user->fresh(); 
            $this->status = 'Profile photo removed successfully.';
        }
    }

    public function render()
    {
        return view('livewire.super-admin-nav.update-profile-information-form');
    }
}
