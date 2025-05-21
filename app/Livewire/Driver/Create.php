<?php

namespace App\Livewire\Driver;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{
    public $name, $email, $phone, $password, $password_confirmation;

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required|string|starts_with:62',
        'password' => 'required|string|confirmed',
    ];

    public function save()
    {
        $validated = $this->validate();

        // dd($validated);
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'driver';

        event(new Registered(($user = User::create($validated))));

        $token = Driver::generateToken();

        Driver::create([
            'user_id' => $user->id,
            'token' => $token,
            'qr' => Driver::generateQrFile($token)
        ]);

        session()->flash('success', "Yey! $user->name is on their way with customer money – no need to chase, it's coming to you!");
        return redirect(route('driver.index'));
    }

    public function render()
    {
        return view('livewire.driver.create');
    }
}
