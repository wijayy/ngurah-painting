<?php

namespace App\Livewire\Driver;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public $password_confirmation  = '';

    #[Validate('required|string')]
    public $nama = '';

    #[Validate('required|email')]
    public $email = '';

    #[Validate('required|string|starts_with:62')]
    public $no_telepon = '';

    #[Validate('required|confirmed|string')]
    public $password = '';

    #[Validate('required|string')]
    public $no_ktp = '';

    #[Validate('required|file|image')]
    public $foto_ktp = '';



    public function save()
    {
        $validated = $this->validate();
        $validated['name'] = $this->nama;
        try {
            DB::beginTransaction();
            $validated['password'] = Hash::make($validated['password']);
            $validated['role'] = 'driver';

            event(new Registered(($user = User::create($validated))));

            $this->foto_ktp = $this->foto_ktp->store('driver');

            Driver::create([
                'user_id' => $user->id,
                'token' => Driver::generateToken(),
                'foto_ktp' => $this->foto_ktp,
                'no_telepon' => $this->no_telepon,
                'no_ktp' => $this->no_ktp
            ]);

            DB::commit();
            session()->flash('success', "Yey! $user->name is on their way with customer money – no need to chase, it's coming to you!");
            return redirect(route('driver.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
    }
    #[Layout('components.layouts.app', ['title' => "Add Driver"])]
    public function render()
    {
        return view('livewire.driver.create', ['title' => "Add Driver"]);
    }
}
