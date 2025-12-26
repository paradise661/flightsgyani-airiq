<?php

namespace App\Http\Livewire\Admin;

use App\Models\FAQ as ModelsFAQ;
use Livewire\Component;
use Livewire\WithPagination;

class Faq extends Component
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
        $faqs = ModelsFAQ::oldest('order')
            ->where('title', 'like', $searchTerms)
            ->orWhere('status', 'like', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.admin.faq', compact('faqs'));
    }
}
