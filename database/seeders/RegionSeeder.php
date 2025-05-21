<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\ISO3166\ISO3166;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = new ISO3166();

        foreach ($countries as $key => $item) {
            Region::create([
                'name' => $item['name'],
                'code' => $item['alpha3']
            ]);
        }
    }
}
