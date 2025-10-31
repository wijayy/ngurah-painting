<?php

namespace App\Livewire\Pembayaran;

use App\Models\Komisi;
use Livewire\Component;
use App\Models\Pembayaran;
// use App\Models\Transaction;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\WithFileUploads;

class Create extends Component
{

    use WithFileUploads;
    public $title, $bank = '', $nama_rekening = '', $nomor_rekening = '', $pembayaran, $komisi, $preview_bukti_transfer = '';

    #[Validate('required|string')]
    public $status = 'cair', $nomor_transaksi = '';

    #[Validate('required|numeric')]
    public $amount = 0, $komisi_id;

    #[Validate('nullable|string')]
    public $catatan = '';

    public $bukti_transfer;

    #[Validate('nullable')]
    public $waktu_pembayaran = null;

    #[Validate('required_if:status,cair')]
    public $metode, $nomor_referensi = '';

    public function rules()
    {
        $rules = [];

        // bukti_transfer wajib saat status = 'cair'
        if ($this->status === 'cair') {
            // saat edit: jika sudah ada bukti di DB, upload baru bersifat optional
            if ($this->pembayaran && !empty($this->pembayaran->bukti_transfer)) {
                $rules['bukti_transfer'] = 'nullable|file|image|max:5120';
            } else {
                $rules['bukti_transfer'] = 'required|file|image|max:5120';
            }
        } else {
            $rules['bukti_transfer'] = 'nullable|file|image|max:5120';
        }

        return $rules;
    }

    public function mount($slug = null)
    {
        if ($slug) {
            $komisi = \App\Models\Komisi::where('slug', $slug)->firstOrFail();

            if ($komisi->pembayaran) {
                return redirect(route('transaction.index'))->with('error', 'Komisi ini sudah memiliki pembayaran.');
            }

            $this->komisi_id = $komisi->id_komisi;

            // dd($this->komisi_id);
            $this->komisi = $komisi;
            $this->nomor_transaksi = $komisi->nomor_transaksi;
            $this->amount = $komisi->nilai;

            $this->title = "Pembayaran Komisi untuk transaksi {$komisi->nomor_transaksi}";
        } else {
            return redirect(route('transaction.index'))->with('error', 'Transaksi tidak ditemukan');
        }
    }

    public function save()
    {
        $validated = $this->validate();

        try {
            DB::beginTransaction();

            if ($this->bukti_transfer) {
                // Hapus file lama jika ada (saat edit)

                // Buat instance manager dengan driver GD
                $manager = new ImageManager(Driver::class);

                // Baca file dan kompres
                $image = $manager->read($this->bukti_transfer->getRealPath())->toJpeg(70);

                // Simpan file yang sudah dikompres
                $bukti_transfer_path = 'pembayaran/' . time() . '.jpg';
                Storage::disk('public')->put($bukti_transfer_path, (string) $image);
            } else {
                $bukti_transfer_path = null;
            }

            $validated['bukti_transfer'] = $bukti_transfer_path;

            \App\Models\Pembayaran::create(
                $validated
            );

            Komisi::where('id_komisi', $this->komisi_id)->update([
                'status' => $this->status == 'cair' ? "cair" : "ditolak",
            ]);


            $this->komisi->driver->user->aktifitas()->create([
                'aktifitas' => $this->status == 'cair' ? "Pembayaran untuk komisi untuk transaksi $this->nomor_transaksi dengan jumlah Rp. " . number_format($this->amount, 0, ',', '.') . " telah dilakukan" : "Pembayaran untuk komisi untuk transaksi $this->nomor_transaksi dengan jumlah Rp. " . number_format($this->amount, 0, ',', '.') . " ditolak",
            ]);

            DB::commit();
            session()->flash('message', 'Data pembayaran berhasil disimpan.');
            return redirect(route('transaction.index'))->with('success', 'Data pembayaran berhasil disimpan.');
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
