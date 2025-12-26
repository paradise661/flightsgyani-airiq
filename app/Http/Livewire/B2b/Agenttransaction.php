<?php

namespace App\Http\Livewire\B2b;

use App\Models\B2B\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Agenttransaction extends Component
{
    use WithPagination;
    public $searchTerms = '';
    public $limit = 10;
    public $agent_id = null;

    public function mount($agent)
    {
        $this->agent_id = $agent;
    }

    public function updatingSearchTerms()
    {
        $this->resetPage();
    }

    public function render()
    {
        // dd($this->agent_id);
        $searchTerms = '%' . $this->searchTerms . '%';
        $transactions = Transaction::where('agent_id', $this->agent_id)
            ->where(function ($query) use ($searchTerms) {
                $query->where('transaction_type', 'like', $searchTerms)
                    ->orWhere('currency_type', 'like', $searchTerms)
                    ->orWhere('load_type', 'like', $searchTerms);
            })
            ->orderBy('id', 'DESC')
            ->paginate($this->limit);
        return view('livewire.b2b.agenttransaction', compact('transactions'));
    }
}
