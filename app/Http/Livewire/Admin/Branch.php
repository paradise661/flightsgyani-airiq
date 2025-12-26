<?php

namespace App\Http\Livewire\Admin;

use App\Models\Branch as ModelsBranch;
use Livewire\Component;
use Livewire\WithPagination;


class Branch extends Component
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
        $branches = ModelsBranch::oldest('order')
            ->where('title', 'like', $searchTerms)
            ->orWhere('location', 'like', $searchTerms)
            ->orWhere('email', 'like', $searchTerms)
            ->orWhere('email_2', 'like', $searchTerms)
            ->orWhere('phone', 'like', $searchTerms)
            ->orWhere('phone_2', 'like', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.admin.branch', compact('branches'));
    }
}
