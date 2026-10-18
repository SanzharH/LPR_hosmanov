<?php

namespace Database\Seeders;

use App\Models\Airport;
use App\Models\Flight;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $airports = Airport::factory()
            ->count(3)
            ->create();

        Flight::factory()
            ->count(30)
            ->recycle($airports)
            ->create();
    }
}
