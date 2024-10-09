<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PembayaranBulanan>
 */
class PembayaranBulananFactory extends Factory
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
            'payment_date' => fake()->dateTimeBetween('-1 year', '-1 month')->format('Y-m-d'),
            'amount' => 10000000,
            'period' => Carbon::now()->format('Y-m-d'), // We'll set this in the configure method
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($pembayaran) {
            static $startDate = null;
            static $count = 0;

            if ($startDate === null) {
                // Pick a random start date in 2023
                $startDate = Carbon::createFromDate(2023, rand(1, 12), 1);
                $count = 0;
            }

            $period = $startDate->copy()->addMonths($count);
            $pembayaran->update(['period' => $period->format('Y-m-d')]);

            $count++;

            // Reset after 5 iterations
            if ($count >= 5) {
                $startDate = null;
            }
        });
    }
}
