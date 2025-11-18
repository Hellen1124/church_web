<?php


namespace App\Livewire\SuperAdminNav;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class UpdateProfileInformationForm extends Component
{
    use WithFileUploads;

    public $user;
    
    // State properties for the form
    public string $first_name = '';
    public string $email = '';
    public $new_photo; // Holds the temporary uploaded file

    // Status message for feedback
    public $status;

    public function mount(): void
    {
        $this->user = Auth::user();
        // Initialize form fields with current user data
        $this->first_name = $this->user->first_name ?? $this->user->name;
        $this->email = $this->user->email;
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
                // Ensure email is unique, ignoring the current user's ID
                'unique:users,email,' . $this->user->id,
            ],
            'new_photo' => ['nullable', 'image', 'max:1024'], // 1MB max photo size
        ];
    }

    public function updateProfileInformation(): void
    {
        $validatedData = $this->validate();

        // 1. Handle Photo Upload
        if ($this->new_photo) {
            // Delete old photo if it exists
            if ($this->user->profile_photo_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($this->user->profile_photo_path);
            }
            // Store the new photo
            $photoPath = $this->new_photo->store('profile-photos', 'public');
            $this->user->profile_photo_path = $photoPath;
        }

        // 2. Update Basic Fields
        $this->user->forceFill([
            'first_name' => $validatedData['first_name'],
            'email' => $validatedData['email'],
        ])->save();

        // Reset the photo field and set status
        $this->new_photo = null;
        $this->status = 'Profile information updated successfully.';
        
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
            $this->user = $this->user->fresh(); // Refresh
            $this->status = 'Profile photo removed successfully.';
        }
    }

    public function render()
    {
        // ⚠️ Renders the blade view in the SuperAdminNav directory
        return view('livewire.super-admin-nav.update-profile-information-form');
    }
}
