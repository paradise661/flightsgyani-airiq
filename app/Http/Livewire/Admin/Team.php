<?php

namespace App\Http\Livewire\Admin;

use App\Models\Team as ModelsTeam;
use Livewire\Component;
use Livewire\WithPagination;

class Team extends Component
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
        $teams = ModelsTeam::oldest('order')
            ->where('name', 'like', $searchTerms)
            ->orWhere('short_description', 'like', $searchTerms)
            ->orWhere('fb', 'like', $searchTerms)
            ->orWhere('instagram', 'like', $searchTerms)
            ->orWhere('position', 'like', $searchTerms)
            ->paginate($this->limit);

        return view('livewire.admin.team', compact('teams'));
    }
}
