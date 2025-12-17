<?php

namespace Database\Seeders\DataSeeders;

use App\Models\Catalogs\FieldType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FieldType::insert([
            ['name' => 'متن', 'type' => 'text', 'validation_type' => 'string'],
            ['name' => 'عددی', 'type' => 'number', 'validation_type' => 'integer'],
            ['name' => 'دراپ داون', 'type' => 'select_single', 'validation_type' => 'string'],
            ['name' => 'دراپ داون (چند انتخابی)', 'type' => 'select_multiple', 'validation_type' => 'array'],
            ['name' => 'رادیو', 'type' => 'radio', 'validation_type' => 'string'],
            ['name' => 'چک باکس', 'type' => 'checkbox', 'validation_type' => 'array'],
            ['name' => 'تاریخ', 'type' => 'date', 'validation_type' => 'date'],
            ['name' => 'سیکل صورتحساب', 'type' => 'cycle', 'validation_type' => 'string'],
            ['name' => 'درست/نادرست', 'type' => 'boolean', 'validation_type' => 'string'],
            ['name' => 'ایمیل', 'type' => 'email', 'validation_type' => 'email'],
            ['name' => 'کاربران', 'type' => 'users', 'validation_type' => 'integer'],
            ['name' => 'باکس متن', 'type' => 'textbox', 'validation_type' => 'string'],
        ]);
    }
}
