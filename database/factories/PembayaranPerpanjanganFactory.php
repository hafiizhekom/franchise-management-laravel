<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PembayaranPerpanjangan>
 */
class PembayaranPerpanjanganFactory extends Factory
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
            'year' => Carbon::now()->format('Y'), // We'll set this in the configure method
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($pembayaran) {
            static $startYear = null;
            static $count = 0;
            static $customer_id = 0;

            // Reset sebelum memulai iterasi baru
            if ($customer_id != $pembayaran->customer_id) {
                $startYear = null;
                $count = 0;
            }
            
            if ($startYear === null) {
                // Pick a random start date in 2023
                $range = rand(1,5);
                $startYear = Carbon::now()->subYears($range);
                $customer_id = $pembayaran->customer_id;
            }

            $year = $startYear->copy()->addYears($count);
            $pembayaran->update(['year' => $year->format('Y')]);

            $count++;

            // Perbarui customer_id untuk iterasi berikutnya
            $customer_id = $pembayaran->customer_id;

        });
    }
}
