<?php

namespace App\Http\Livewire\Admin;

use App\Models\Whatwedo as ModelsWhatwedo;
use Livewire\Component;
use Livewire\WithPagination;

class Whatwedo extends Component
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
        $whatwedo = ModelsWhatwedo::latest()
            ->where('title', 'like', $searchTerms)
            ->orWhere('description', 'like', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.admin.whatwedo', compact('whatwedo'));
    }
}
