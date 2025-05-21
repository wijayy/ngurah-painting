<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Database\Seeder;
use App\Models\CommisionWithdrawal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommisionWithdrawalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = Driver::all();

        foreach ($users as $key => $user) {
            CommisionWithdrawal::factory(5)->recycle([$user, User::all()])->create();
        }
    }
}
