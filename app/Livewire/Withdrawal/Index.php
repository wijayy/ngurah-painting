<?php

namespace App\Livewire\Withdrawal;

use App\Models\CommisionWithdrawal;
use App\Models\PenukaranPoin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $month, $year, $withdrawal;

    public function mount()
    {
        $this->month = date('m');
        $this->year = date('Y');

        $this->withdrawal = $this->getWithdrawal();
    }
    public function getWithdrawal()
    {
        return PenukaranPoin::whereMonth('created_at', $this->month)->whereYear('created_at', $this->year)->get();
    }

    public function decline(PenukaranPoin $withdrawal)
    {
        $withdrawal->update(['status' => 'ditolak']);
        $withdrawal->driver->increment('poin', $withdrawal->poin);
        session()->flash('success', "Sorry, {$withdrawal->driver->user->name}’s commission withdrawal didn’t go through—it was rejected.");
        $this->withdrawal = $this->getWithdrawal();

    }

    public function render()
    {
        return view('livewire.withdrawal.index')->layout('components.layouts.app', ['title' => 'Penukaran Poin']);
    }
}
