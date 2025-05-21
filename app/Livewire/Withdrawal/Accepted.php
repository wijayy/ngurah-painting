<?php

namespace App\Livewire\Withdrawal;

use App\Models\CommisionWithdrawal;
use Livewire\Component;

class Accepted extends Component
{

    public CommisionWithdrawal $withdrawal, $amount;

    public function mount($token)
    {
        try {
            $this->withdrawal = CommisionWithdrawal::where('token', $token)->firstOrFail();
            $this->amount = $this->withdrawal->amount;
        } catch (\Throwable $th) {
            return redirect(route('withdrawal.index'))->with('error', 'Oops! No withdrawal found. Did you actually make one, or were you just dreaming of money?');
        }

        if ($this->withdrawal->status == 'declined') {
            return redirect(route('withdrawal.index'))->with('error', 'Withdrawal failed. Maybe your money just ghosted you');
        }
        if ($this->withdrawal->status == 'accepted') {
            return redirect(route('withdrawal.index'))->with('success', 'Boom! Withdrawal request fired. Time for the money to start jogging your way');
        }
    }


    public function render()
    {
        return view('livewire.withdrawal.accepted');
    }
}
