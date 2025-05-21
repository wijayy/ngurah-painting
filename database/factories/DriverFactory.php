<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        return [
            'user_id' => User::factory()->create(['role'=>'driver']),
            'bank' => 'BRI',
            'qr' => 'qr/qr.png',
            'account_name' => $name,
            'account_number' => fake()->numberBetween(111111111, 999999999),
            'token' => Driver::generateToken()
        ];
    }
}
