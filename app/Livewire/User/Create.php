<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{

    public $name, $email, $password, $password_confirmation, $role = "staff", $status = 1, $catatan = '', $user, $nomor_telepon;

    protected function rules()
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email',
            'nomor_telepon' => 'required|string|starts_with:62',
            'password' => 'required|string|confirmed',
            'role' => 'required|string',
            'status' => 'required|in:0,1',
            'catatan' => 'nullable|string',
        ];

        if ($this->user) {
            // If editing an existing user, password is optional
            $rules['password'] = 'nullable|string|confirmed';
        }

        return $rules;
    }

    public $title;

    public function mount($slug = null)
    {
        $this->user = User::where('slug', $slug)->first();

        if ($slug && $this->user == null) {
            return redirect(route('user.index'))->with('error', 'Staff tidak ditemukan');
        }

        if ($this->user) {
            $this->title = "Edit Staff {$this->user->name}";
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->nomor_telepon = $this->user->nomor_telepon;
            $this->role = $this->user->role;
            $this->status = $this->user->status;
            $this->catatan = $this->user->catatan;

            // Password is not filled for security reasons
        } else {
            $this->title = "Tambah Staff";
        }
    }

    public function save()
    {
        $validated = $this->validate();

        // dd($validated);

        if ($this->user) {
            // If editing an existing user
            if (empty($validated['password'])) {
                // If password is empty, remove it from the validated data to avoid overwriting
                unset($validated['password']);
            } else {
                // Hash the new password
                $validated['password'] = Hash::make($validated['password']);
            }
            $this->user->update($validated);
            session()->flash('success', "Staff {$this->user->name} has been updated.");
        } else {
            // If creating a new user, hash the password
            $validated['password'] = Hash::make($validated['password']);
            event(new Registered(($user = User::create($validated))));
            session()->flash('success', "Say hello to our new teammate, $this->name!");
        }

        return redirect(route('user.index'))->with('success', 'Data staff telah tersimpan.');
    }
    public function render()
    {
        return view('livewire.user.create')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
