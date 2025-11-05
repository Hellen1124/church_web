<?php


namespace App\Livewire\Church;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tenant;

class ChurchIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $selected = [];
    public $viewMode = 'table'; // 'table' or 'grid'
    public $perPage = 9; // default pagination size

    protected $paginationTheme = 'tailwind';

    // Reset page on search update
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Bulk actions
    public function bulkActivate()
    {
        Tenant::whereIn('id', $this->selected)->update(['status' => 'active']);
        $this->reset('selected');
        session()->flash('message', 'Selected churches activated successfully.');
    }

    public function bulkDeactivate()
    {
        Tenant::whereIn('id', $this->selected)->update(['status' => 'suspended']);
        $this->reset('selected');
        session()->flash('message', 'Selected churches deactivated.');
    }

    public function bulkDelete()
    {
        Tenant::whereIn('id', $this->selected)->delete();
        $this->reset('selected');
        session()->flash('message', 'Selected churches deleted.');
    }

    public function setViewMode(string $mode): void
{
    // The viewMode property is public, so setting it here
    // will trigger a re-render automatically.
    $this->viewMode = $mode;
}

    public function render()
    {
        $churches = Tenant::query()
            ->when($this->search, function ($query) {
                $query->where('church_name', 'like', '%' . $this->search . '%')
                      ->orWhere('church_email', 'like', '%' . $this->search . '%')
                      ->orWhere('domain', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.church.church-index', [
            'churches' => $churches,
        ]);
    }
}





