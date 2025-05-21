<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Driver;
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
            Attendance::factory(5)->recycle([$user, User::all()])->create();
        }
    }
}
