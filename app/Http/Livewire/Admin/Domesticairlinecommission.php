<?php

namespace App\Http\Livewire\Admin;

use App\Models\Domestic\DomesticFlightCommission;
use Livewire\Component;
use Livewire\WithPagination;

class Domesticairlinecommission extends Component
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
        $commissions = DomesticFlightCommission::latest()->where('domestic_airline', 'like', $searchTerms)
            ->orWhere('domestic_airline_code', 'like', $searchTerms)
            ->orWhere('domestic_airline_class', 'like', $searchTerms)
            ->orWhere('commission', 'like', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.admin.domesticairlinecommission', compact('commissions'));
    }
}
