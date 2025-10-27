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
            'user_id' => User::factory(),
            'bank' => 'BRI',
            'membership_no' => Driver::memberNumberGenerator(),
            'nama_rekening' => $name,
            'nomor_rekening' => fake()->numberBetween(111111111, 999999999),
            'token' => Driver::generateToken(),
            'no_ktp' => fake()->numberBetween(111111111, 999999999),
            'no_sim' => fake()->numberBetween(111111111, 999999999),
            'sim_berlaku_hingga' => fake()->date(),
            'nomor_telepon' => fake()->phoneNumber(),
            'foto_ktp' => 'driver/ktp.png',
            'foto_sim' => 'driver/sim.png',
            'poin' => 40,
        ];
    }
}
