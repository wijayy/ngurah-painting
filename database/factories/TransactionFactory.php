<?php

namespace Database\Factories;

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
            'driver_id' => Driver::factory(),
            'user_id' => User::factory(),
            'region_id' => Region::factory(),
            'transaction_number' => Transaction::transactionNumberGenerator(),
            'name' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'note' => fake()->sentence(),
            'total_amount' => mt_rand(10, 30) * 100000,
            'total_item' => mt_rand(1, 10),
            'total_product' => mt_rand(1, 10),
        ];
    }
}
