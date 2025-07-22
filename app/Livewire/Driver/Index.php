<?php

namespace App\Livewire\Driver;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{

    public $drivers;

    public function mount()
    {
        $this->drivers = User::where('role', 'driver')->get();
    }

    #[Layout('components.layouts.app', ['title' => "Semua Driver"])]
    public function render()
    {
        return view('livewire.driver.index');
    }
}
