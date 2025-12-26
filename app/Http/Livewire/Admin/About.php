<?php

namespace App\Http\Livewire\Admin;

use App\Models\AboutUs;
use Livewire\Component;
use Livewire\WithPagination;

class About extends Component
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
        $abouts = AboutUs::where('name', 'like', $searchTerms)
            ->orWhere('address', 'like', $searchTerms)
            ->orWhere('phone', 'like', $searchTerms)
            ->orWhere('email', 'like', $searchTerms)
            ->orWhere('fb', 'like', $searchTerms)
            ->orWhere('instagram', 'like', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.admin.about', compact('abouts'));
    }
}
