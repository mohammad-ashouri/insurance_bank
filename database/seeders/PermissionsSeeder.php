<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'telescope',
            'مقادیر اولیه | مدیریت نقش های کاربری',
            'مقادیر اولیه | مدیریت منبع اندیشه',
            'مدیریت کاربران | منو',
            'مدیریت کاربران | صفحه اصلی',
            'مدیریت کاربران | کاربر جدید',
            'مدیریت کاربران | ویرایش کاربر',
        ];

// ایجاد دسترسی‌ها
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

// ایجاد نقش و تخصیص دسترسی
        $superAdminRole = Role::firstOrCreate(['name' => 'ادمین کل', 'adder' => 1]);
        $superAdminRole->givePermissionTo($permissions);

// تخصیص نقش به کاربران
        User::all()->each(function ($user) use ($superAdminRole) {
            $user->assignRole([$superAdminRole->id]);
        });
    }
}
