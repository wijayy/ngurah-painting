<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $users, $title = 'Staff';

    public function mount()
    {
        $this->users = User::whereNot('role', 'driver')->get();
    }

    public function render()
    {
        return view('livewire.user.index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
