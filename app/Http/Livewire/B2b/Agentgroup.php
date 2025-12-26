<?php

namespace App\Http\Livewire\B2b;

use App\Models\B2B\AgentGroup as B2BAgentGroup;
use Livewire\Component;
use Livewire\WithPagination;


class Agentgroup extends Component
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
        $agentgroups = B2BAgentGroup::oldest('order')
            ->where('name', 'like', $searchTerms)
            ->orWhere('order', 'like', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.b2b.agentgroup', compact('agentgroups'));
    }
}
