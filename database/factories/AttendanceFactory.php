<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
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
            'nomor_stiker' => 4,
            'jumlah_wisatawan' => 4,
            'tanggal_waktu' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'expired_at' => $this->faker->dateTimeBetween('now', '+1 month'),
            'used_at' => null,
            'nama' => $this->faker->name(),
            'wa' => $this->faker->phoneNumber(),
        ];
    }
}
