<?php

namespace App\Livewire\Driver;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{

    public $drivers;

    public function mount()
    {
        $this->drivers = User::where('role', 'driver')->get();
    }

    public function render()
    {
        return view('livewire.driver.index');
    }
}
