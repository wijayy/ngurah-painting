<?php

namespace App\Livewire\Withdrawal;

use App\Models\CommisionWithdrawal;
use App\Models\Pembayaran;
use App\Models\PenukaranPoin;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Request extends Component
{
    public $user, $user_id, $poin = 10, $metode_penukaran = 'cash', $max, $jumlah, $status= 'diajukan', $title = "Permintaan Penukaran Poin";

    #[Validate('required_if:metode_penukaran,transfer|string')]
    public $bank, $nama_rekening, $nomor_rekening;
    protected $rules = [
        'poin' => 'required|numeric|min:10',
        'metode_penukaran' => 'required|string',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->user_id = $this->user->id;

        if ($this->user->driver->poin < Setting::where('key', 'minimum_penukaran_poin')->value('value')) {
            return redirect()->route('dashboard')->with('error', 'Penukaran poin tidak memenuhi kriteria minumum penukaran poin');
        }

        $this->max = $this->user->driver->poin;
        $this->default();
    }

    public function updatedPoin()
    {
        if(is_numeric($this->poin) && $this->poin > $this->max){
            $this->poin = $this->max;
        } elseif(!is_numeric($this->poin) || $this->poin < 10){
            return;
        }
        $this->jumlah = $this->poin * Setting::where('key', 'hadiah_kunjungan')->value('value');
    }

    public function default()
    {
        $this->poin = 10;
        $this->metode_penukaran = 'cash';
        $this->bank = Auth::user()->driver->bank;
        $this->nama_rekening = Auth::user()->driver->nama_rekening;
        $this->nomor_rekening = Auth::user()->driver->nomor_rekening;
        $this->status = 'diajukan';
        $this->updatedPoin();
    }

    public function save()
    {
        $validated = $this->validate($this->rules);
        try {
            DB::beginTransaction();
            // dd($validated);
            PenukaranPoin::create([
                'jumlah' => $this->jumlah,
                'poin' => $this->poin,
                'token' => PenukaranPoin::generateToken(),
                'driver_id' => $this->user->driver->id_driver,
                'metode_penukaran' => $this->metode_penukaran,
                'status' => 'diajukan',
                'bank' => $this->metode_penukaran == 'transfer' ? $this->bank : null,
                'nama_rekening' => $this->metode_penukaran == 'transfer' ? $this->nama_rekening : null,
                'nomor_rekening' => $this->metode_penukaran == 'transfer' ? $this->nomor_rekening : null
            ]);

            $this->user->aktifitas()->create([
                'aktifitas' => "Mengajukan penukaran poin sejumlah $this->poin poin",
            ]);

            $this->user->driver->decrement('poin', $this->poin);

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Permintaan penukaran poin berhasil diajukan');
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
        return view('livewire.withdrawal.request')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
