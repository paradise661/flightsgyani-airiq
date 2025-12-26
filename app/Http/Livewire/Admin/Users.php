<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
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
        $users = User::latest()
            ->where('user_type', 'ADMIN')
            ->where(function ($query) use ($searchTerms) {
                $query->where('name', 'like', '%' . $searchTerms . '%')
                    ->orWhere('email', 'like', '%' . $searchTerms . '%')
                    ->orWhere('phonenumber', 'like', '%' . $searchTerms . '%');
            })
            ->paginate($this->limit);

        return view('livewire.admin.users', compact('users'));
    }
}
