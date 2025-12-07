<?php

namespace App\Livewire;

use App\Models\Request;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class RequestList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.request-list', [
            'requests' => Request::latest()->paginate(10),
        ]);
    }
}
