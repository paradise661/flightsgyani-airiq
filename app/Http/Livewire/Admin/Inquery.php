<?php

namespace App\Http\Livewire\Admin;

use App\Models\Inquery as ModelsInquery;
use Livewire\Component;
use Livewire\WithPagination;

class Inquery extends Component
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
        $inqueries = ModelsInquery::latest()
            ->where(function ($query) use ($searchTerms) {
                $query->where('name', 'like', '%' . $searchTerms . '%')
                    ->orWhere('email', 'like', '%' . $searchTerms . '%')
                    ->orWhere('phone', 'like', '%' . $searchTerms . '%')
                    ->orWhere('city', 'like', '%' . $searchTerms . '%')
                    ->orWhere('message', 'like', '%' . $searchTerms . '%')
                    ->orWhereDate('created_at', 'like', '%' . $searchTerms . '%');
            })
            ->paginate($this->limit);
        return view('livewire.admin.inquery', compact('inqueries'));
    }
}
