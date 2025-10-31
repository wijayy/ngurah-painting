<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kunjungan>
 */
class KunjunganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jumlah_wisatawan' => 4,
            'tanggal_waktu' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'nama' => $this->faker->name(),
            'wa' => $this->faker->phoneNumber(),
        ];
    }
}
