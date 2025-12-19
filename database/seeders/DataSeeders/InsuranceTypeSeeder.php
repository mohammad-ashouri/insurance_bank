<?php

namespace Database\Seeders\DataSeeders;

use App\Models\Catalogs\InsuranceType;
use Illuminate\Database\Seeder;

class InsuranceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insurance_types=[
            [
                'name' => 'شخص ثالث',
                'adder' => 1,
            ],
            [
                'name' => 'بدنه',
                'adder' => 1,
            ],
            [
                'name' => 'عمر و سرمایه گذاری',
                'adder' => 1,
            ],
        ];
        foreach ($insurance_types as $insurance_type) {
            InsuranceType::firstOrCreate($insurance_type);
        }

    }
}
