<?php

namespace App\Livewire\Driver;

use App\Models\CommisionWithdrawal;
use App\Models\PenukaranPoin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
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

    public function decline(PenukaranPoin $withdrawal)
    {
        $withdrawal->update(['status' => 'ditolak']);
        $withdrawal->driver->increment('poin', $withdrawal->poin);
        session()->flash('success', "Sorry, {$withdrawal->driver->user->name}’s commission withdrawal didn’t go through—it was rejected.");
    }

    #[Layout('components.layouts.app', ['title' => "Detail of Driver"])]
    public function render()
    {
        return view('livewire.driver.show');
    }
}
