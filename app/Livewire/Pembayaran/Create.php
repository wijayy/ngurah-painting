<?php

namespace App\Livewire\Pembayaran;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    public $title, $bank = '', $nama_rekening = '', $nomor_rekening = '', $pembayaran, $komisi;

    #[Validate('required|string')]
    public $status = 'pending', $metode = 'cash', $nomor_referensi = '';

    #[Validate('required|numeric')]
    public $amount = 0, $komisi_id;

    #[Validate('nullable|string')]
    public $catatan = '';

    #[Validate('required|active_url')]
    public $bukti_transfer_url = '';

    public function mount($slug = null)
    {
        if ($slug) {
            $this->pembayaran = \App\Models\Pembayaran::where('id_pembayaran', $slug)->firstOrFail();
            $this->komisi_id = $this->pembayaran->komisi_id;
            $this->amount = $this->pembayaran->amount;
            $this->metode = $this->pembayaran->metode;
            $this->bukti_transfer_url = $this->pembayaran->bukti_transfer_url;
            $this->bank = $this->pembayaran->bank;
            $this->nama_rekening = $this->pembayaran->nama_rekening;
            $this->nomor_rekening = $this->pembayaran->nomor_rekening;
            $this->nomor_referensi = $this->pembayaran->nomor_referensi;
            $this->catatan = $this->pembayaran->catatan;
            $this->status = $this->pembayaran->status;
            $this->title = "Edit Pembayaran {$this->pembayaran->id_pembayaran}";
        } else {
            $this->title = "Tambah Pembayaran";
        }
    }

    public function updated($komisi_id)
    {
        $this->komisi = \App\Models\Komisi::where('id_komisi', $this->komisi_id)->first();
        if ($this->komisi) {
            // Cek apakah komisi sudah punya pembayaran
            $sudahAdaPembayaran = \App\Models\Pembayaran::where('komisi_id', $this->komisi_id)->exists();
            if ($sudahAdaPembayaran) {
                $this->addError('komisi_id', 'Komisi ini sudah memiliki pembayaran.');
                $this->amount = 0;
                return;
            }
            $this->amount = $this->komisi->nilai;
        } else {
            $this->amount = 0;
        }
    }

    public function save()
    {
        $validated = $this->validate();

        try {
            DB::beginTransaction();
            \App\Models\Pembayaran::updateOrCreate(
                ['id_pembayaran' => $this->pembayaran ? $this->pembayaran->id_pembayaran : null],
                $validated
            );

            $this->komisi->driver->user->aktifitas()->create([
                'aktifitas' => $this->pembayaran ? "Mengubah data pembayaran untuk komisi ID $this->komisi_id dengan jumlah Rp. " . number_format($this->amount, 0, ',', '.') : "Pembayaran untuk komisi ID $this->komisi_id dengan jumlah Rp. " . number_format($this->amount, 0, ',', '.') . " telah dilakukan",
            ]);

            DB::commit();
            session()->flash('message', 'Data pembayaran berhasil disimpan.');
            return redirect(route('komisi.index'));
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
        return view('livewire.pembayaran.create')->layout('components.layouts.app', ['title' => 'Tambah Pembayaran']);
    }
}
