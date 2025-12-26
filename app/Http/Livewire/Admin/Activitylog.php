<?php

namespace App\Http\Livewire\Admin;

use App\Models\ActivityLog as ModelsActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class Activitylog extends Component
{
    use WithPagination;
    public $searchTerms = '';
    public $dateRange = '';
    public $limit = 10;

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
        $this->dateRange = '';
        $this->limit = 10;
        $this->resetPage();
    }

    public function render()
    {
        $searchTerms = '%' . $this->searchTerms . '%';

        $dates = [];

        if (!empty($this->dateRange)) {
            $dates = explode(' to ', $this->dateRange);
        }

        $logs = ModelsActivityLog::query()
            ->latest()
            ->where(function ($query) use ($searchTerms) {
                $query->where('activity', 'LIKE', $searchTerms);
            });

        if (count($dates) === 2) {
            $startDate = $dates[0];
            $endDate = \Carbon\Carbon::parse($dates[1])->endOfDay();
            $logs = $logs->whereBetween('created_at', [$startDate, $endDate]);
        }

        $logs = $logs->paginate($this->limit);

        return view('livewire.admin.activitylog', compact('logs'));
    }
}
