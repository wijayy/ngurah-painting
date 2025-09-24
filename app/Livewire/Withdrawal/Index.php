<?php

namespace App\Livewire\Withdrawal;

use App\Models\CommisionWithdrawal;
use App\Models\PenukaranPoin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{
    public $withdrawal, $title = 'Penukaran Poin';
    #[Url(except: '')]
    public $month, $year;

    public function mount()
    {
        $this->month = request()->query('month', date('n'));
        $this->year = request()->query('year', date('Y'));
        $this->withdrawal = $this->getWithdrawal();
    }

    public function updated($month, $year)
    {
        $this->withdrawal = $this->getWithdrawal();
    }

    public function getWithdrawal()
    {
        return PenukaranPoin::whereMonth('created_at', $this->month ?? date('m'))->whereYear('created_at', $this->year ?? date('Y'))->get();
    }

    public function render()
    {
        return view('livewire.withdrawal.index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
