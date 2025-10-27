<?php

namespace App\Livewire\Pembayaran;

use App\Models\Komisi;
use Livewire\Component;
use App\Models\Pembayaran;
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
    public $status = 'cair';

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
            $this->pembayaran = \App\Models\Pembayaran::where('id_pembayaran', $slug)->firstOrFail();
            $this->komisi_id = $this->pembayaran->komisi_id;
            $this->amount = $this->pembayaran->amount;
            $this->metode = $this->pembayaran->metode;
            $this->bank = $this->pembayaran->bank;
            $this->preview_bukti_transfer = $this->pembayaran->bukti_transfer;
            $this->nama_rekening = $this->pembayaran->nama_rekening;
            $this->nomor_rekening = $this->pembayaran->nomor_rekening;
            $this->nomor_referensi = $this->pembayaran->nomor_referensi;
            $this->catatan = $this->pembayaran->catatan;
            $this->status = $this->pembayaran->status;
            $this->waktu_pembayaran = $this->pembayaran->waktu_pembayaran?->format('Y-m-d\TH:i');
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
            if ($sudahAdaPembayaran && !$this->pembayaran) {
                $this->addError('komisi_id', 'Komisi ini sudah memiliki pembayaran.');
                $this->amount = 0;
                return;
            }
            $this->amount = $this->komisi->nilai;
        } else {
            $this->amount = 0;
        }

        if ($this->status == 'batal') {
            $this->amount = 0;
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
