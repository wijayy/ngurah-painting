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
            'user_id' => User::factory()->create(['role'=>'driver', 'name'=>$name]),
            'bank' => 'BRI',
            'nama_rekening' => $name,
            'nomor_rekening' => fake()->numberBetween(111111111, 999999999),
            'token' => Driver::generateToken(),
            'no_ktp' => fake()->numberBetween(111111111, 999999999),
            'no_telepon' => fake()->phoneNumber(),
            'foto_ktp' => 'driver/foto_ktp.png',
        ];
    }
}
