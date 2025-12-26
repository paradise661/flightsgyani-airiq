<?php

namespace App\Http\Livewire\Admin;

use App\Models\InternationalFlight\Airline as InternationalFlightAirline;
use Livewire\Component;
use Livewire\WithPagination;

class Airline extends Component
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
        $airlines = InternationalFlightAirline::latest()
            ->where('name', 'like', $searchTerms)
            ->orWhere('code', 'like', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.admin.airline', compact('airlines'));
    }
}
