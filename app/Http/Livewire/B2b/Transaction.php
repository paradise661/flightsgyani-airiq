<?php

namespace App\Http\Livewire\B2b;

use App\Models\B2B\Transaction as B2BTransaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Transaction extends Component
{
    use WithPagination;
    public $searchTerms = '';
    public $limit = 10;
    public $type = '';
    public $dateRange = '';
    public $paymentStatus = 'All';

    public function mount($type)
    {
        $this->type = $type;
    }

    public function updatingSearchTerms()
    {
        $this->resetPage();
    }

    public function updatingDateRange()
    {
        $this->resetPage();
    }

    public function updatingPaymentStatus()
    {
        $this->resetPage();
    }

    // Apply filters when the user clicks the 'Filter' button
    public function applyFilters()
    {
        // This method triggers the re-rendering with applied filters
        $this->resetPage(); // Reset pagination on filter change
    }

    // Clear all filters
    public function clearFilters()
    {
        $this->searchTerms = '';
        $this->dateRange = '';
        $this->paymentStatus = 'All';
        $this->limit = 10;
        $this->resetPage(); // Reset pagination as well
    }

    public function render()
    {
        $searchTerms = '%' . $this->searchTerms . '%';

        // Parse the date range if it exists
        $dates = [];
        if (!empty($this->dateRange)) {
            $dates = explode(' to ', $this->dateRange);
        }

        $transactions = B2BTransaction::where('agent_id', Auth::user()->id);
        if ($this->type) {
            $transactions = $transactions->where('load_type', 'ADMIN')->where('status', $this->type);
        }

        // Apply date range filter if both dates are present
        if (count($dates) === 2) {
            $startDate = $dates[0];
            $endDate = \Carbon\Carbon::parse($dates[1])->endOfDay();
            $transactions = $transactions->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($this->paymentStatus !== 'All') {
            $transactions = $transactions->where('transaction_type', $this->paymentStatus);
        }

        $transactions = $transactions->where(function ($query) use ($searchTerms) {
            $query->where('transaction_type', 'like', $searchTerms)
                ->orWhere('currency_type', 'like', $searchTerms)
                ->orWhere('load_type', 'like', $searchTerms);
        })
            ->orderBy('id', 'DESC')
            ->paginate($this->limit);
        return view('livewire.b2b.transaction', compact('transactions'));
    }
}
