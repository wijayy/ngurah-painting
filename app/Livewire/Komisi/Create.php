<?php

namespace App\Livewire\Komisi;

use App\Models\Aktifitas;
use App\Models\Komisi;
use App\Models\Transaction;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    public $title = "", $komisi;

    #[Validate('required|numeric')]
    public $transaksi_id, $persen = 50, $nilai = 0;

    #[Validate('required|string')]
    public $status = 'pending';


    public function mount($slug = null)
    {
        if ($slug) {
            $this->komisi = Komisi::where('id_komisi', $slug)->firstOrFail();
            // $this->product = $product->id_produk;
            $this->transaksi_id = $this->komisi->transaksi_id;
            $this->persen = $this->komisi->persen;
            $this->nilai = $this->komisi->nilai;
            $this->status = $this->komisi->status;
            $this->title = "Edit Komisi {$this->komisi->id_komisi}";
        } else {
            $this->title = "Tambah Komisi";
        }
    }

    public function updated($field)
    {
        // Hanya jalankan jika field transaksi_id atau persen yang berubah
        if (in_array($field, ['transaksi_id', 'persen'])) {
            $transaksi = Transaction::where('id_transaksi', $this->transaksi_id)->first();
            if ($transaksi) {
                // Jika tambah data (komisi belum ada), pastikan transaksi_id belum pernah ada di komisi
                if (!$this->komisi) {
                    $sudahAda = \App\Models\Komisi::where('transaksi_id', $this->transaksi_id)->exists();
                    if ($sudahAda) {
                        $this->addError('transaksi_id', 'Komisi untuk transaksi ini sudah ada.');
                        $this->nilai = 0;
                        return;
                    }

                    if ($transaksi->stiker === null) {
                        $this->addError('transaksi_id', 'Transaksi tidak memiliki driver terkait.');
                        $this->nilai = 0;
                        return;
                    }
                } else {
                    // Jika edit, transaksi_id tidak boleh diubah dari komisi yang sedang diedit
                    if ($this->transaksi_id != $this->komisi->transaksi_id) {
                        $this->addError('transaksi_id', 'ID transaksi tidak boleh diubah saat edit komisi.');
                        $this->nilai = 0;
                        return;
                    }
                }
                if (is_numeric($this->persen) && $this->persen >= 0 && $this->persen <= 100) {
                    // Hitung nilai komisi berdasarkan persen dan total_harga transaksi
                    $this->nilai = ($this->persen / 100) * $transaksi->total_harga;
                }
            } else {
                $this->nilai = 0;
            }
        }
    }

    public function save()
    {
        $validated = $this->validate();

        $driver = Transaction::where('id_transaksi', $this->transaksi_id)->first()->stiker->driver ?? null;

        if ($driver) {
            $validated['driver_id'] = $driver->id_driver;
        } else {
            session()->flash('success', $this->komisi ? 'Komisi Berhasil Diubah' : 'Komisi Berhasil Ditambahkan');
            return redirect()->route('komisi.index');
        }

        Komisi::updateOrCreate(
            ['id_komisi' => $this->komisi ? $this->komisi->id_komisi : null],
            $validated
        );

        if ($driver) {
            $driver->user->aktifitas()->create([
                'aktifitas' => $this->komisi ? "Mengubah komisi untuk transaksi ID $this->transaksi_id dengan nilai Rp. " . number_format($this->nilai, 0, ',', '.') : "Menambahkan komisi untuk transaksi ID $this->transaksi_id dengan nilai Rp. " . number_format($this->nilai, 0, ',', '.'),
            ]);
        }

        session()->flash('success', $this->komisi ? 'Komisi Berhasil Diubah' : 'Komisi Berhasil Ditambahkan');
        return redirect()->route('komisi.index');
    }

    public function render()
    {
        return view('livewire.komisi.create')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
