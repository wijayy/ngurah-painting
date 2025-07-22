<?php

namespace App\Livewire\Transaction;

use App\Models\Pembayaran;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Withdrawal extends Component
{
    use WithFileUploads;
    public $transaksi;

    #[Validate('required|integer')]
    public $komisi = '';

    #[Validate('required')]
    public $metode_pembayaran = 'cash';

    #[Validate('required|file|image')]
    public $bukti_pembayaran = '';

    public function mount($slug)
    {
        try {
            $this->transaksi = Transaction::where('slug', $slug)->firstOrFail();

            if (!$this->transaksi->komisi) {
                throw new Exception("Transaksi {$this->transaksi->nomor_transaksi} Tidak Memiliki Komisi");
            }

            if ($this->transaksi->komisi->pembayaran) {
                throw new Exception("Komisi pada Transaksi {$this->transaksi->nomor_transaksi} Sudah Dicairkan");
            }
        } catch (\Throwable $th) {
            return redirect(route('transaction.index'))->with('error', $th->getMessage());
        }
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();
            if ($this->transaksi->komisi->komisi != $this->komisi) {
                throw new Exception('Jumlah Komisi Tidak Sama');
            }

            $bukti_pembayaran = $this->bukti_pembayaran->store('pembayaran');

            Pembayaran::create([
                'komisi_id' => $this->transaksi->komisi->id_komisi,
                'komisi' => $this->komisi,
                'metode_pembayaran'=>$this->metode_pembayaran,
                'bukti_pembayaran'=>$bukti_pembayaran,
            ]);
            DB::commit();

            return redirect(route('transaction.index'))->with('success', "Komisi Berhasil Dicairkan");
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
    }


    public function render()
    {
        return view('livewire.transaction.withdrawal')->layout('components.layouts.app', ['title' => 'Pencairan Komisi']);
    }
}
