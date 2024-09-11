<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DanaDP>
 */
class DanaDPFactory extends Factory
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
            'payment_date' => fake()->dateTimeBetween('-2 years', '-1 year')->format('Y-m-d'),
            'amount' => 10000000,
        ];  
    }
}
