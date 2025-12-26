<?php

namespace App\Http\Livewire\Admin;

use App\Models\CompanyTicketDetail;
use Livewire\Component;
use Livewire\WithPagination;

class Ticket extends Component
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
        $tickets = CompanyTicketDetail::latest()->where('company_name', 'like', $searchTerms)
            ->orWhere('company_email', 'like', $searchTerms)
            ->orWhere('company_contact', 'like', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.admin.ticket', compact('tickets'));
    }
}
