<?php

namespace App\Http\Livewire\B2b;

use App\Models\AgentMarkup;
use Livewire\Component;
use Livewire\WithPagination;

class Markup extends Component
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
        $markups = AgentMarkup::orderBy('priority','desc')
            ->where('type', 'LIKE', $searchTerms)
            ->orWhere('airline', 'LIKE', $searchTerms)
            ->orWhere('origin', 'LIKE', $searchTerms)
            ->orWhere('destination', 'LIKE', $searchTerms)
            ->orWhere('trip_type', 'LIKE', $searchTerms)
            ->orWhere('class', 'LIKE', $searchTerms)
            ->paginate($this->limit);

        return view('livewire.b2b.markup', compact('markups'));
    }
}
