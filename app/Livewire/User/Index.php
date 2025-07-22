<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::whereNot('role', 'driver')->get();
    }

    public function delete(User $user)
    {
        $user->delete();
        $this->users = User::whereNot('role', 'driver')->get();
        session()->flash('success', "{$user->name} has left the building... and the team");
    }
    public function render()
    {
        return view('livewire.user.index');
    }
}
