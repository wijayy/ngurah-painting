<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Driver;
use App\Models\Region;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomor_transaksi' => Transaction::transactionNumberGenerator(),
            'stiker_id' => Attendance::factory(),
            'total_harga' => mt_rand(10, 30) * 100000,
            'tanggal' => now(),
        ];
    }
}
