<?php

namespace App\Http\Livewire\Admin;

use App\Models\Domestic\DomesticAirline as DomesticDomesticAirline;
use Livewire\Component;
use Livewire\WithPagination;

class Domesticairline extends Component
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
        $airlines = DomesticDomesticAirline::oldest('order')
            ->where('name', 'like', $searchTerms)
            ->orWhere('code', 'like', $searchTerms)
            ->orWhere('order', 'like', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.admin.domesticairline', compact('airlines'));
    }
}
