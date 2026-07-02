<?php

namespace Database\Factories;

use App\Models\Bus;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusFactory extends Factory
{
    protected $model = Bus::class;

    public function definition(): array
    {
        return [
            'nama_bus' => fake()->unique()->words(2, true),
            'kategori_bus' => fake()->randomElement(['Big Bus', 'Medium Bus']),
            'tipe_bus' => fake()->randomElement(['SHD Single Glass', 'SHD Double Glass', 'Medium']),
            'kapasitas' => fake()->numberBetween(20, 60),
            'harga_sewa' => fake()->numberBetween(2000000, 5000000),
            'status' => true,
        ];
    }
}
