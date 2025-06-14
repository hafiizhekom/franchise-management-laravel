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
            static $customer_id = 0;

            // Reset sebelum memulai iterasi baru
            if ($customer_id != $pembayaran->customer_id) {
                $startDate = null;
                $count = 0;
            }

            if ($startDate === null) {
                // Pick a random start date in 2024
                $startDate = Carbon::createFromDate(2024, rand(1, Carbon::now()->format('m')), 1);
                $customer_id = $pembayaran->customer_id;
            }

            $period = $startDate->copy()->addMonths($count);
            $pembayaran->update(['period' => $period->format('Y-m-d')]);

            $count++;

            // Perbarui customer_id untuk iterasi berikutnya
            $customer_id = $pembayaran->customer_id;
        });
    }
}
