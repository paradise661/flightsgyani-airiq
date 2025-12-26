<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    use WithPagination;
    public $searchTerms = '';
    public $limit = 10;

    public function updatingSearchTerms()
    {
        $this->resetPage();
    }

    public function render()
    {
        $searchTerms = '%' . $this->searchTerms . '%';
        $permissions = Permission::latest()
            ->where('name', 'like', $searchTerms)
            ->orWhere('parent', 'like', $searchTerms)
            ->paginate($this->limit);

        return view('livewire.admin.permissions', compact('permissions'));
    }
}
