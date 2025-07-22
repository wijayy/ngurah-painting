<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use App\Models\Driver;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Scan extends Component
{
    public function mount($id)
    {
         $sticker = request()->sticker_number;
        $amount = request()->amount;
        $token = request()->token;

        // Cek token, simpan presensi, dll.
        $driver = Driver::where('token', $token)->first();

        if (!$driver) {
            return redirect(route('attendance.index'))->with('error', 'Token tidak valid.');
        }

        // Simpan presensi baru
        Attendance::create([
            'sticker_number' => $sticker,
            'person' => $amount,
            'driver_id' => $driver->id,
            'user_id' => Auth::user()->id,
            // tambahkan kolom lain jika perlu
        ]);

        return redirect()->route('attendance.index')->with('success', 'Presensi berhasil!');
    }
    public function render()
    {
        return view('livewire.attendance.scan');
    }
}
