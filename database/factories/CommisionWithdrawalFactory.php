<?php

namespace Database\Factories;

use App\Models\CommisionWithdrawal;
use App\Models\User;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommisionWithdrawal>
 */
class CommisionWithdrawalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'driver_id' => Driver::factory(),
            'amount' => mt_rand(10, 30) * 10000,
            'withdrawal_method' => 'cash',
            'token' => CommisionWithdrawal::generateToken(),
        ];
    }
}
