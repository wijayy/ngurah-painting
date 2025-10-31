<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Driver;
use App\Models\Kunjungan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = Driver::all();

        foreach ($users as $key => $user) {
            $attendance = Attendance::factory()->recycle([$user])->create([
                'nomor_stiker' => $key + 1,
            ]);

            $attendance->kunjungan()->save(Kunjungan::factory()->make());
        }
    }
}
