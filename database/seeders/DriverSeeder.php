<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 20) as $key => $item) {
            $name = fake()->name();
            $user = User::factory()->create(['email' => "driver$item@admin.com", 'role'=>'driver', 'name'=>$name]);
            Driver::factory(1)->recycle($user)->create(['nama_rekening'=>$name]);
        }
    }
}
