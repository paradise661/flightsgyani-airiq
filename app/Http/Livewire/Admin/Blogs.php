<?php

namespace App\Http\Livewire\Admin;

use App\Models\Blog;
use Livewire\Component;
use Livewire\WithPagination;

class Blogs extends Component
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
        $blogs = Blog::latest()
            ->where('title', 'like', $searchTerms)
            ->orWhere('description', 'like', $searchTerms)
            ->paginate($this->limit);
        return view('livewire.admin.blogs', compact('blogs'));
    }
}
