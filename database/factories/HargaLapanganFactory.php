<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Facade;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HargaLapangan>
 */
class HargaLapanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'lapangan_id' => \mt_rand(1,5),
            'hari_id' => \mt_rand(1,3),
            'jam_id' => \mt_rand(1,17),
            'harga' => \fake()->randomNumber(\mt_rand(5,6), true)
        ];
    }
}
