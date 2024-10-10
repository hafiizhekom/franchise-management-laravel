<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\DanaKomitmen;
use App\Models\DanaDP;
use App\Models\DanaPelunasan;
use App\Models\PembayaranBulanan;
use App\Models\PembayaranPerpanjangan;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Customer::factory()
            ->count(10)
            ->has(
                DanaKomitmen::factory()
                    ->has(
                        DanaDP::factory()
                            ->has(
                                DanaPelunasan::factory()
                            )
                    )
            )
            ->has(PembayaranBulanan::factory()->count(rand(1,12)))
            ->has(PembayaranPerpanjangan::factory()->count(rand(1,12)))
            ->create();
    }

    public function down(){

    }
}
