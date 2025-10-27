<?php

namespace App\Livewire\Withdrawal;

use Livewire\Component;
use App\Models\PenukaranPoin;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use App\Models\CommisionWithdrawal;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class Accepted extends Component
{

    use WithFileUploads;
    public PenukaranPoin $penukaran;
    public $expect, $metode_penukaran, $diajukan_at, $disetujui_at, $ditolak_at, $id_penukaran, $driver_id, $poin, $title = 'Proses Penukaran Poin';

    #[Validate('required|string')]
    public $status = 'disetujui';

    #[Validate('required_if:status,disetujui|nullable|file|image|max:5120')]
    public $bukti_penukaran = '';

    #[Validate('required|integer')]
    public $jumlah = '';

    public function mount($token)
    {
        try {
            $this->penukaran = PenukaranPoin::where('token', $token)->firstOrFail();
            $this->expect = $this->penukaran->jumlah;
            $this->metode_penukaran = $this->penukaran->metode_penukaran;
            $this->id_penukaran = $this->penukaran->id_penukaran;
            $this->driver_id = $this->penukaran->driver_id;
            $this->poin = $this->penukaran->poin;
            $this->diajukan_at = date('Y-m-d\TH:i', strtotime($this->penukaran->created_at));
            $this->disetujui_at = date('Y-m-d\TH:i');
            $this->ditolak_at = date('Y-m-d\TH:i');
        } catch (\Throwable $th) {
            return redirect(route('withdrawal.index'))->with('error', 'Data Penukaran Tidak Ditemukan');
        }

        if ($this->penukaran->status == 'ditolak') {
            return redirect(route('withdrawal.index'))->with('error', 'Penukaran poin telah ditolak');
        }
        if ($this->penukaran->status == 'disetujui') {
            return redirect(route('withdrawal.index'))->with('success', 'Penukaran poin telah disetujui');
        }
    }

    public function save()
    {

        try {
            DB::beginTransaction();

            if ($this->jumlah != $this->expect) {
                $this->addError('jumlah', 'Jumlah penukaran harus sama dengan jumlah yang diminta');
                // dd($this->jumlah);
                return;
            }

            if ($this->bukti_penukaran) {
                // Hapus file lama jika ada (saat edit)

                // Buat instance manager dengan driver GD
                $manager = new ImageManager(Driver::class);

                // Baca file dan kompres
                $image = $manager->read($this->bukti_penukaran->getRealPath())->toJpeg(70);

                // Simpan file yang sudah dikompres
                $bukti_penukaran_path = 'driver/ktp_' . time() . '.jpg';
                Storage::disk('public')->put($bukti_penukaran_path, (string) $image);
            } else {
                $bukti_penukaran_path = null;
            }

            $penukaran = $this->penukaran->update([
                'bukti_penukaran' => $bukti_penukaran_path ?? null,
                'status' => $this->status,
                'disetujui_at' => $this->status == 'disetujui' ? date('Y-m-d H:i:s') : null,
                'ditolak_at' => $this->status == 'ditolak' ? date('Y-m-d H:i:s') : null,
                'jumlah' => $this->jumlah,
            ]);
            DB::commit();

            return redirect(route('withdrawal.index'))->with('success', $this->status == 'disetujui' ? 'Penukaran poin berhasil disetujui' : 'Penukaran poin berhasil ditolak');
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
        return view('livewire.withdrawal.accepted')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
