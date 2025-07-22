<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{

    public $name, $email, $phone, $password, $password_confirmation, $role = "staff";

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required|string|starts_with:62',
        'password' => 'required|string|confirmed',
        'role' => 'required|string',
    ];

    public function save()
    {
        $validated = $this->validate();

        // dd($validated);
        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        session()->flash('success', "Say hello to our new teammate, $this->name!");
        return redirect(route('user.index'));
    }
    public function render()
    {
        return view('livewire.user.create');
    }
}
