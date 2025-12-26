<?php

namespace App\Http\Livewire\Admin;

use App\Models\InternationalFlight\SearchFlight;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
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

        $searches = SearchFlight::latest()->where('id', 'LIKE', $searchTerms)
            ->orWhere('departure', 'LIKE', $searchTerms)
            ->orWhere('destination', 'LIKE', $searchTerms)
            ->orWhere('flight_date', 'LIKE', $searchTerms)
            ->orWhere('return_date', 'LIKE', $searchTerms)
            ->orWhere('currency', 'LIKE', $searchTerms)
            ->orWhere('nationality', 'LIKE', $searchTerms)
            ->orWhere('airline', 'LIKE', $searchTerms)
            ->orWhere('class', 'LIKE', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.admin.search', compact('searches'));
    }
}
