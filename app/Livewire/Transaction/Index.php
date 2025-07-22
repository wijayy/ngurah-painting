<?php

namespace App\Livewire\Transaction;

use App\Models\Transaction;
use Livewire\Component;

class Index extends Component
{
    public $transaction, $month, $year;

    public function mount()
    {
        $this->month = date("n", );
        $this->year = date("Y");
        $this->transaction = $this->getTransaction();
    }

    public function changeDate()
    {
        $this->transaction = $this->getTransaction();
    }
    public function getTransaction()
    {
        return Transaction::whereMonth('created_at', $this->month)->whereYear('created_at', $this->year)->get();
    }
    public function render()
    {
        return view('livewire.transaction.index')->layout('components.layouts.app', ['title'=> 'Transaksi']);
    }
}
