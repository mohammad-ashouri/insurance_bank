<?php

namespace Database\Seeders;

use Database\Seeders\DataSeeders\InsuranceTypeSeeder;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class,
            InsuranceTypeSeeder::class,
        ]);
    }
}
