<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Carbon\Carbon;
use Livewire\Component;

class Create extends Component
{

    public $sticker, $amount, $token;

    protected $listeners = ['qrScanned'];
    public function mount()
    {
        $this->sticker = Attendance::latest()->whereDate("created_at", Carbon::today())->first();
        if ($this->sticker) {
            $this->sticker = $this->sticker->sticker_number + 1;
        } else {
        $this->sticker = 1;
        }
    }

    public function qrScanned($token)
    {
        $this->token = $token;

        // Lakukan logika seperti simpan ke DB, redirect, dll.
        // Contoh: presensi otomatis
        $attendance = Attendance::where('token', $token)->first();
        dd($attendance);
    }

    public function render()
    {
        return view('livewire.attendance.create')->layout('components.layouts.app', ['title'=> 'Catat Kunjungan']);
    }
}
