<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Product;
use App\Models\Region;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 50) as $key => $item) {
            $transaction = Transaction::factory()->recycle([User::all(), Driver::all(), Region::all()])->create();

            foreach (range(1, mt_rand(1, 5)) as $key => $itm) {
                TransactionDetail::factory()->recycle([$transaction, Product::all()])->create();
            }
        }
    }
}
