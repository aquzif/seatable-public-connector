<?php

namespace App\Livewire;

use App\Models\Request as RequestModel;
use Livewire\WithPagination;
use Livewire\Component;

class RequestsList extends Component
{
    use WithPagination;

    public function render()
    {
        $requests = RequestModel::latest()->paginate(10);

        return view('livewire.requests-list', [
            'requests' => $requests,
        ])->layout('layouts.app');
    }
}
