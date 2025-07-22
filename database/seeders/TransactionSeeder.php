<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Komisi;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Attendance::take(12)->get() as $key => $item) {
            $transaction = Transaction::create([
                'nomor_transaksi' => Transaction::transactionNumberGenerator(),
                'stiker_id' => $item->id_stiker,
                'total_harga' => mt_rand(10, 30) * 100000,
                'tanggal' => now(),
            ]);

            foreach (range(1, mt_rand(1, 5)) as $key => $itm) {
                TransactionDetail::factory()->recycle([$transaction, Product::all()])->create();
            }

            Komisi::create([
                'transaksi_id' => $transaction->id_transaksi,
                'driver_id' => $transaction->stiker->driver->id_driver,
                'komisi' => $transaction->total_harga / 2,
            ]);
        }
        foreach (range(1, 50) as $key => $item) {
            $transaction = Transaction::create([
                'nomor_transaksi' => Transaction::transactionNumberGenerator(),
                'total_harga' => mt_rand(10, 30) * 100000,
                'tanggal' => now(),
            ]);

            foreach (range(1, mt_rand(1, 5)) as $key => $itm) {
                TransactionDetail::factory()->recycle([$transaction, Product::all()])->create();
            }
        }
    }
}
