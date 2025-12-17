<?php

namespace Database\Seeders\DataSeeders;

use App\Models\Catalogs\Cycle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cycle::insert([
            ['name' => 'یک روزه', 'adder' => 1, 'created_at' => '2025-10-02 08:36:34', 'updated_at' => '2025-10-02 08:36:34'],
            ['name' => 'هفت روزه', 'adder' => 1, 'created_at' => '2025-10-02 08:36:34', 'updated_at' => '2025-10-02 08:36:34'],
            ['name' => 'ده روزه', 'adder' => 1, 'created_at' => '2025-10-02 08:36:34', 'updated_at' => '2025-10-02 08:36:34'],
            ['name' => 'پانزده روزه', 'adder' => 1, 'created_at' => '2025-10-02 08:36:34', 'updated_at' => '2025-10-02 08:36:34'],
            ['name' => 'بیست روزه', 'adder' => 1, 'created_at' => '2025-10-02 08:36:34', 'updated_at' => '2025-10-02 08:36:34'],
            ['name' => 'سی روزه', 'adder' => 1, 'created_at' => '2025-10-02 08:36:34', 'updated_at' => '2025-10-02 08:36:34'],
            ['name' => 'چهل و پنج روزه', 'adder' => 1, 'created_at' => '2025-10-02 08:36:34', 'updated_at' => '2025-10-02 08:36:34'],
            ['name' => 'شصت روزه', 'adder' => 1, 'created_at' => '2025-10-02 08:36:34', 'updated_at' => '2025-10-02 08:36:34'],
            ['name' => 'نود روزه', 'adder' => 1, 'created_at' => '2025-10-02 08:36:34', 'updated_at' => '2025-10-02 08:36:34'],
            ['name' => 'صد و بیست روزه', 'adder' => 1, 'created_at' => '2025-10-02 08:36:34', 'updated_at' => '2025-10-02 08:36:34'],
        ]);
    }
}
