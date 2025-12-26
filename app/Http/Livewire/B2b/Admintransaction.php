<?php

namespace App\Http\Livewire\B2b;

use App\Models\B2B\Transaction;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Admintransaction extends Component
{
    use WithPagination;
    public $searchTerms = '';
    public $limit = 10;
    public $agent = 'All';

    public function updatingSearchTerms()
    {
        $this->resetPage();
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->searchTerms = '';
        $this->limit = 10;
        $this->agent = 'All';
        $this->resetPage();
    }

    public function render()
    {
        $searchTerms = '%' . $this->searchTerms . '%';
        $transactions = Transaction::query()
            ->where('load_type', 'ADMIN')
            ->where(function ($query) use ($searchTerms) {
                $query->where('transaction_type', 'like', $searchTerms)
                    ->orWhere('currency_type', 'like', $searchTerms)
                    ->orWhere('invoice_id', 'like', $searchTerms)
                    ->orWhere('remarks', 'like', $searchTerms)
                    ->orWhere('status', 'like', $searchTerms)
                    ->orWhere('load_type', 'like', $searchTerms);
            });

        if ($this->agent !== 'All') {
            $transactions = $transactions->where('agent_id', $this->agent);
        }
        $transactions = $transactions->orderBy('id', 'DESC')
            ->paginate($this->limit);

        $agents = User::where('user_type', 'AGENT')->orderBy('name', 'ASC')->get();
        return view('livewire.b2b.admintransaction', compact('transactions', 'agents'));
    }
}
