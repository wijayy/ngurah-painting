<?php

namespace App\Livewire\Driver;

use App\Models\CommisionWithdrawal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{

    public $user, $slug;

    public function mount($slug = null)
    {
        $this->slug = $slug;

        if ($slug) {
            try {
                $this->user = User::where('slug', $slug)->firstOrFail();
            } catch (\Throwable $th) {
                return redirect(route('dashboard'))->with('error', "No driver found. Did they vanish into the multiverse again?");
            }
        } else {
            $this->user = Auth::user();
        }

        // $this->qr =
    }

    public function decline(CommisionWithdrawal $withdrawal)
    {
        $withdrawal->update(['status' => 'declined']);
        if ($this->slug) {
            $this->user = User::where('slug', $this->slug)->first();
        } else {
            $this->user = Auth::user();
        }
    }

    public function render()
    {
        return view('livewire.driver.show');
    }
}
