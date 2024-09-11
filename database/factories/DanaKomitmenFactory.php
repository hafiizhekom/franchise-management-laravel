<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DanaKomitmen>
 */
class DanaKomitmenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'payment_date' => fake()->dateTimeBetween('-3 years', '-2 years')->format('Y-m-d'),
            'amount' => 10000000,
        ];
    }
}
