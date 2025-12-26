<?php

namespace App\Http\Livewire\Admin;

use App\Models\InternationalFlightCommission;
use Livewire\Component;
use Livewire\WithPagination;

class Internationalairlinecommission extends Component
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
        $commissions = InternationalFlightCommission::latest()->where('international_airline', 'like', $searchTerms)
            ->orWhere('international_airline_code', 'like', $searchTerms)
            ->orWhere('international_airline_class', 'like', $searchTerms)
            ->orWhere('commission', 'like', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.admin.internationalairlinecommission', compact('commissions'));
    }
}
