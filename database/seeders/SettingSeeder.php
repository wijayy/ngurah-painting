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
                'key' => 'hadiah_kunjungan',
                'value' => 15000
            ],
            [
                'key' => 'rasio_komisi',
                'value' => 50
            ],
            [
                'key' => 'minimum_penukaran_poin',
                'value' => 10
            ],
            [
                'key' => 'max_nonaktif',
                'value' => 90
            ],
        ];

        foreach ($arr as $key => $item) {
            Setting::create($item);
        }
    }
}
