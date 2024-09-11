<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\DanaKomitmen;
use App\Models\DanaDP;
use App\Models\DanaPelunasan;

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
            ->create();
    }

    public function down(){

    }
}
