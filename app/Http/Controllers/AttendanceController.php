<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Driver;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        // dd(vars: request());
        // Validasi agar semua parameter wajib ada
        $validated = $request->validate([
            'nomor_stiker' => 'required|numeric',
            'jumlah_customer' => 'required|numeric',
            'token' => 'required|string',
        ]);

        $sticker = $validated['nomor_stiker'];
        $jumlah_customer = $validated['jumlah_customer'];
        $token = $validated['token'];

        try {
            DB::beginTransaction();
            $driver = Driver::where('token', $token)->first();

            if (!$driver) {
                return redirect(back())->with('error', 'Token tidak valid');
            }

            $driver->increment('poin');

            // Simpan presensi baru
            Attendance::create([
                'nomor_stiker' => $sticker,
                'jumlah_customer' => $jumlah_customer,
                'driver_id' => $driver->id_driver,
                // tambahkan kolom lain jika perlu
            ]);

            // return view('dashboard');

            DB::commit();
            return redirect()->route('attendance.index')->with('success', "{$driver->user->name} just showed up with {$validated['jumlah_customer']} new customers!");
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }

        // Cek token, simpan presensi, dll.

    }
}
