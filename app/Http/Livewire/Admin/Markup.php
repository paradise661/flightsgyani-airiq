<?php

namespace App\Http\Livewire\Admin;

use App\Models\InternationalFlight\Markup as InternationalFlightMarkup;
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
        $markups = InternationalFlightMarkup::orderBy('priority','desc')
            ->where('type', 'LIKE', $searchTerms)
            ->orWhere('airline', 'LIKE', $searchTerms)
            ->orWhere('origin', 'LIKE', $searchTerms)
            ->orWhere('destination', 'LIKE', $searchTerms)
            ->orWhere('trip_type', 'LIKE', $searchTerms)
            ->orWhere('class', 'LIKE', $searchTerms)
            ->paginate($this->limit);

        return view('livewire.admin.markup', compact('markups'));
    }
}
