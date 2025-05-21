<?php

namespace App\Livewire\Transaction;

use App\Models\Transaction;
use Livewire\Component;

class Index extends Component
{
    public $transaction;

    public function mount() {
        $this->transaction = Transaction::take(6)->get();
    }
    public function render()
    {
        return view('livewire.transaction.index');
    }
}
