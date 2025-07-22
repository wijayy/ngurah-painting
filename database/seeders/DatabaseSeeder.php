<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
            'role' => 'admin'
        ]);

        foreach (range(1,5) as $key => $item) {
            User::factory()->create([
                'email'=>"user{$item}@admin.com"
            ]);

        }

        $this->call(SettingSeeder::class);
        $this->call(DriverSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(AttendanceSeeder::class);
        $this->call(TransactionSeeder::class);
        // $this->call(CommisionWithdrawalSeeder::class);
    }
}
