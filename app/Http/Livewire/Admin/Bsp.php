<?php

namespace App\Http\Livewire\Admin;

use App\Models\InternationalFlight\BSPCommission;
use Livewire\Component;
use Livewire\WithPagination;

class Bsp extends Component
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

        $bsp = BSPCommission::latest()
            ->where('airline', 'like', $searchTerms)
            ->orWhere('commission', 'like', $searchTerms);

        if (strpos('siti', $this->searchTerms) === 0) {
            $bsp = $bsp->orWhere('with_origin', '=', '');
        }
        if (strpos('soto', $this->searchTerms) === 0) {
            $bsp = $bsp->orWhere('without_origin', '=', '');
        }
        $bsp = $bsp->paginate($this->limit);

        return view('livewire.admin.bsp', compact('bsp'));
    }
}
