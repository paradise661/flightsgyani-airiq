<?php

namespace App\Http\Livewire\B2b;

use App\Models\B2B\Transaction;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Alltransaction extends Component
{
    use WithPagination;
    public $searchTerms = '';
    public $limit = 10;
    public $agent = 'All';
    public $dateRange = '';

    public function updatingSearchTerms()
    {
        $this->resetPage();
    }

    public function updatingDateRange()
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
        $this->dateRange = '';
        $this->resetPage();
    }

    public function render()
    {
        $searchTerms = '%' . $this->searchTerms . '%';
        // Parse the date range if it exists
        $dates = [];
        if (!empty($this->dateRange)) {
            $dates = explode(' to ', $this->dateRange);
        }

        $transactions = Transaction::query()
            ->where(function ($query) use ($searchTerms) {
                $query->where('transaction_type', 'like', $searchTerms)
                    ->orWhere('currency_type', 'like', $searchTerms)
                    ->orWhere('invoice_id', 'like', $searchTerms)
                    ->orWhere('remarks', 'like', $searchTerms)
                    ->orWhere('status', 'like', $searchTerms)
                    ->orWhere('load_type', 'like', $searchTerms);
            });

        // Apply date range filter if both dates are present
        if (count($dates) === 2) {
            $startDate = $dates[0];
            $endDate = \Carbon\Carbon::parse($dates[1])->endOfDay();
            $transactions = $transactions->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($this->agent !== 'All') {
            $transactions = $transactions->where('agent_id', $this->agent);
        }
        $transactions = $transactions->orderBy('id', 'DESC')
            ->paginate($this->limit);

        $agents = User::where('user_type', 'AGENT')->orderBy('name', 'ASC')->get();
        return view('livewire.b2b.alltransaction', compact('transactions', 'agents'));
    }
}
