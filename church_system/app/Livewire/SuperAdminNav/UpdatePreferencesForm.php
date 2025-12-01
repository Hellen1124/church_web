<?php

namespace App\Livewire\SuperAdminNav;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UpdatePreferencesForm extends Component
{
    public $user;

    /**
     * Component state properties for preferences.
     */
    public string $theme;
    public bool $notifications_enabled;
    public ?string $status = null;

    public function mount(): void
    {
        $this->user = Auth::user();
        
        // Load preferences from the user model. (Assumes 'preferences' is cast to 'array')
        $preferences = $this->user->preferences ?? [];

        // Initialize state with stored preferences or defaults
        $this->theme = $preferences['theme'] ?? 'light';
        $this->notifications_enabled = $preferences['notifications_enabled'] ?? true;
    }

    protected function rules(): array
    {
        return [
            'theme' => ['required', 'string', 'in:light,dark'],
            'notifications_enabled' => ['required', 'boolean'],
        ];
    }

    /**
     * Update the user's stored preferences.
     */
    public function updatePreferences(): void
    {
        $this->validate();

        // 1. Create the new preferences array
        $newPreferences = [
            'theme' => $this->theme,
            'notifications_enabled' => $this->notifications_enabled,
        ];
        
        // 2. Save the array back to the 'preferences' column 
        // (Laravel's JSON casting handles the serialization)
        $this->user->preferences = $newPreferences;
        $this->user->save();

        $this->status = 'Preferences updated successfully.';
        
        // 3. Refresh the user instance
        $this->user = $this->user->fresh();
        $this->dispatch('preferences-updated'); 
    }

    public function render()
    {
        return view('livewire.super-admin-nav.update-preferences-form');
    }
}
