<?php

namespace App\Http\Livewire\Admin;

use App\Models\Domestic\DomesticSector as DomesticDomesticSector;
use Livewire\Component;
use Livewire\WithPagination;

class Domesticsector extends Component
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
        $sectors = DomesticDomesticSector::oldest('order')
            ->where('name', 'like', $searchTerms)
            ->orWhere('code', 'like', $searchTerms)
            ->orWhere('order', 'like', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.admin.domesticsector', compact('sectors'));
    }
}
