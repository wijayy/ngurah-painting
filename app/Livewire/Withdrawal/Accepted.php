<?php

namespace App\Livewire\Withdrawal;

use App\Models\CommisionWithdrawal;
use App\Models\PenukaranPoin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Accepted extends Component
{

    use WithFileUploads;
    public PenukaranPoin $penukaran;
    public $expect, $metode_penukaran;

    #[Validate('required|file|image|max:2048')]
    public $bukti_penukaran;

    #[Validate('required|integer')]
    public $jumlah = '';

    public function mount($token)
    {
        try {
            $this->penukaran = PenukaranPoin::where('token', $token)->firstOrFail();
            $this->expect = $this->penukaran->jumlah;
            $this->metode_penukaran = $this->penukaran->metode_penukaran;
        } catch (\Throwable $th) {
            return redirect(route('withdrawal.index'))->with('error', 'Oops! No withdrawal found. Did you actually make one, or were you just dreaming of money?');
        }

        if ($this->penukaran->status == 'ditolak') {
            return redirect(route('withdrawal.index'))->with('error', 'Withdrawal failed. Maybe your money just ghosted you');
        }
        if ($this->penukaran->status == 'sukses') {
            return redirect(route('withdrawal.index'))->with('success', 'Boom! Withdrawal request fired. Time for the money to start jogging your way');
        }
    }

    public function save()
    {

        try {
            DB::beginTransaction();

            if ($this->jumlah != $this->expect) {
                session()->flash('error', 'Jumlah Penukaran Tidak Sesuai');
                return;
            }
            // dd($this->proof);
            $image = $this->bukti_penukaran->store('penukaran');
            // dd($validated);
            $this->penukaran->update([
                'bukti_penukaran' => $image,
                'status' => 'sukses'
            ]);
            DB::commit();

            return redirect(route('withdrawal.index'))->with('success', "{$this->penukaran->driver->user->name} just scored his commission! Time to make it rain (maybe)!");
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
        return view('livewire.withdrawal.accepted')->layout('components.layouts.app', ['title' => 'Terima Penukaran Poin']);
    }
}
