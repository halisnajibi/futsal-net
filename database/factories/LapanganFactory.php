<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Facade;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lapangan>
 */
class LapanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'kategori_id' => \mt_rand(1,3),
            'nama' => 'lapangan -' . \fake()->randomNumber(3, false),
            'keterangan' => \fake()->paragraph(\mt_rand(1,3)),
        ];
    }
}
