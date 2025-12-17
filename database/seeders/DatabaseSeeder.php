<?php

namespace Database\Seeders;

use Database\Seeders\DataSeeders\BankSeeder;
use Database\Seeders\DataSeeders\CycleSeeder;
use Database\Seeders\DataSeeders\FieldTypeSeeder;
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
            FieldTypeSeeder::class,
            CycleSeeder::class,
            BankSeeder::class,
        ]);
    }
}
