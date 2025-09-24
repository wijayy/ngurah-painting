<?php

namespace App\Livewire\Driver;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Profile extends Component
{

    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.driver.profile');
    }
}
