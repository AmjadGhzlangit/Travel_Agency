<?php

namespace Database\Seeders;

use App\Models\Travel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TravelSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Travel::factory()->count(10)->create();
    }
}
