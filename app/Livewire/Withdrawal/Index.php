<?php

namespace App\Livewire\Withdrawal;

use App\Models\CommisionWithdrawal;
use Livewire\Component;

class Index extends Component
{
    public $date, $withdrawal;

    public function mount() {
        $this->date = date('Y-m-d');

        $this->withdrawal = $this->getWithdrawal();
    }
    public function getWithdrawal() {
        return CommisionWithdrawal::take(6)->get();
    }

    public function render()
    {
        return view('livewire.withdrawal.index');
    }
}
