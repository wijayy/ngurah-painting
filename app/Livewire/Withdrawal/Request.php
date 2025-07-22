<?php

namespace App\Livewire\Withdrawal;

use App\Models\CommisionWithdrawal;
use App\Models\Pembayaran;
use App\Models\PenukaranPoin;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Request extends Component
{
    public $user, $amount = 10, $metode_penukaran = 'cash', $max, $jumlah;

    protected $rules = [
        'amount' => 'required|numeric|min:10',
        'metode_penukaran' => 'required|string',
    ];

    public function mount()
    {
        $this->user = Auth::user();

        if ($this->user->driver->poin < Setting::where('key', 'minimum_penukaran_poin')->value('value')) {
            return redirect()->route('dashboard')->with('error', 'Penukaran poin tidak memenuhi kriteria minumum penukaran poin');
        }

        $this->max = $this->user->driver->poin;
        $this->updatedAmount();
    }

    public function updatedAmount()
    {
        $this->jumlah = $this->amount * Setting::where('key', 'hadiah_kunjungan')->value('value');
    }

    public function save()
    {
        $validated = $this->validate($this->rules);
        try {
            DB::beginTransaction();
            // dd($validated);
            PenukaranPoin::create([
                'jumlah' => $this->jumlah,
                'poin' => $this->amount,
                'token'=> PenukaranPoin::generateToken(),
                'driver_id' => $this->user->driver->id_driver,
                'metode_penukaran' => $this->metode_penukaran,
                'status' => 'diajukan',
            ]);

            $this->user->driver->decrement('poin', $this->amount);

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'We’ve received your commission withdrawal request!');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                session()->flash('error', $th->getMessage());
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.withdrawal.request')->layout('components.layouts.app', ['title' => "Permintaan Penukaran Poin"]);
    }
}
