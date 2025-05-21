<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = [
            [
                'key' => 'attendance_reward',
                'value' => 15000
            ],
            [
                'key' => 'commision_rate',
                'value' => 50
            ]
        ];

        foreach ($arr as $key => $item) {
            Setting::create($item);
        }
    }
}
