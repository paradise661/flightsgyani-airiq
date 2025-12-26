<?php

namespace App\Http\Livewire\Admin;

use App\Models\DomesticSearchFlight;
use Livewire\Component;
use Livewire\WithPagination;

class Domesticsearch extends Component
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

        $searches = DomesticSearchFlight::latest()->where('id', 'LIKE', $searchTerms)
            ->orWhere('departure', 'LIKE', $searchTerms)
            ->orWhere('arrival', 'LIKE', $searchTerms)
            ->orWhere('departure_date', 'LIKE', $searchTerms)
            ->orWhere('return_date', 'LIKE', $searchTerms)
            ->orWhere('nationality', 'LIKE', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.admin.domesticsearch', compact('searches'));
    }
}
