<?php

namespace App\Livewire\Stiker;

use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    public $stiker = '', $driver, $title = 'Buat Stiker', $drivers;

    #[Url(except: '')]
    public $token = '';

    #[Validate('required|string')]
    public $nama = '', $wa;

    #[Validate('required|numeric')]
    public $driver_id, $nomor_stiker, $jumlah;

    #[Validate('required')]
    public $tanggal_waktu, $expired_at;

    #[Validate('nullable')]
    public $used_at;


    public function mount()
    {
        $this->drivers = \App\Models\Driver::all();
        if ($this->token) {
            $this->driver = \App\Models\Driver::where('token', $this->token)->first();
            if ($this->driver) {
                $this->driver_id = $this->driver->id_driver;
            } else {
                $this->addError('token', 'Token tidak valid.');
            }
        }
    }

    public function save()
    {
        // dd(123);

        try {
            // $validated = $this->validate();
            // dd($validated);
            DB::beginTransaction();
            // Cek apakah nomor_stiker sudah ada
            $sudahAda = Attendance::whereDate('created_at', now())->where('nomor_stiker', $this->nomor_stiker)->exists();
            if ($sudahAda) {
                $this->addError('nomor_stiker', 'Nomor stiker sudah ada.');
                return;
            }

            // Simpan data stiker baru
            $stiker = new Attendance();
            $stiker->nomor_stiker = $this->nomor_stiker;
            $stiker->driver_id = $this->driver_id;
            $stiker->nama = $this->nama;
            $stiker->wa = $this->wa;
            $stiker->tanggal_waktu = $this->tanggal_waktu;
            $stiker->expired_at = $this->expired_at;
            $stiker->used_at = $this->used_at;
            $stiker->jumlah_wisatawan = $this->jumlah;
            $stiker->save();

            $this->driver->user->aktifitas()->create([
                'aktifitas' => "Melakukan Kunjungan dengan Nomor Stiker $this->nomor_stiker dan Jumlah Wisatawan $this->jumlah",
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
        session()->flash('message', 'Stiker berhasil dibuat.');
        return redirect()->route('stiker.index');
    }

    public function render()
    {
        return view('livewire.stiker.create')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
