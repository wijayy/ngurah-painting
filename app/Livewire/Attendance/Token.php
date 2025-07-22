<?php

namespace App\Livewire\Attendance;

use Livewire\Component;

class Token extends Component
{

    public function mount()
    {
        return redirect()->route("login");
    }
    public function render()
    {
        return view('livewire.attendance.token');
    }
}
