<?php

namespace App\Livewire\Transaction;

use App\Models\Transaction;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{
    public $transaction, $transaksi = null;

    #[Url(except: '')]
    public $search = '', $status = '';

    public function mount()
    {
        $this->transaction = $this->getTransaction();
    }

    public function updated($search, $status)
    {
        $this->transaction = $this->getTransaction();
    }

    public function detailTransaksi($id)
    {
        $this->transaksi = Transaction::where('id_transaksi', $id)->first();
        $this->dispatch('modal-show', name:'detail');
    }

    public function getTransaction()
    {
        return Transaction::filters(['search' => $this->search, 'status' => $this->status])->get();
    }
    public function render()
    {
        return view('livewire.transaction.index')->layout('components.layouts.app', ['title' => 'Transaksi']);
    }
}
