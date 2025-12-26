<?php

namespace App\Http\Livewire\Admin;

use App\Models\InternationalFlight\Airport as InternationalFlightAirport;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class Airport extends Component
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
        $airports = InternationalFlightAirport::oldest('country')
            ->where('country', 'like', $searchTerms)
            ->orWhere('city', 'like', $searchTerms)
            ->orWhere('airport', 'like', $searchTerms)
            ->orWhere('code', 'like', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.admin.airport', compact('airports'));
    }
}
