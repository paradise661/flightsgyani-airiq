<?php

namespace App\Http\Livewire\B2b;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;


class Agent extends Component
{
    use WithPagination;
    public $searchTerms = '';
    public $limit = 10;
    public $accountStatus = 'All';

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
        $this->accountStatus = 'All';
        $this->resetPage();
    }

    public function render()
    {
        $searchTerms = '%' . $this->searchTerms . '%';

        $agents = User::query()
            ->whereUserType('AGENT')
            ->where(function ($query) use ($searchTerms) {
                $query->where('name', 'like', $searchTerms)
                    ->orWhere('email', 'like', $searchTerms)
                    ->orWhere('phonenumber', 'like', $searchTerms)
                    ->orWhere('contact_person', 'like', $searchTerms)
                    ->orWhere('address', 'like', $searchTerms);
            })
            ->when($this->searchTerms, function ($query) {
                $query->orWhereHas('agentGroup', function ($query) {
                    $query->where('name', 'like', $this->searchTerms);
                });
            })
            ->latest();

        // Apply account status filter
        if ($this->accountStatus !== 'All') {
            $agents->where('status', $this->accountStatus);
        }

        // Paginate results
        $agents = $agents->paginate($this->limit);
        return view('livewire.b2b.agent', compact('agents'));
    }
}
