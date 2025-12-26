<?php

namespace App\Http\Livewire\Admin;

use App\Models\Page as ModelsPage;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
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
        $pages = ModelsPage::oldest('order')
            ->where('title', 'like', $searchTerms)
            ->orWhere('status', 'like', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.admin.page', compact('pages'));
    }
}
