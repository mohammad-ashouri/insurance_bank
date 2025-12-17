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
            'مقادیر اولیه | مدیریت سیکل های صورتحساب',
            'مقادیر اولیه | مدیریت بانک ها',
            'مقادیر اولیه | مدیریت فیلد ها',
            'مقادیر اولیه | مدیریت نقش های کاربری',
            'مقادیر اولیه | مدیریت انواع سرویس',
            'مقادیر اولیه | مدیریت انواع سرویس | مدیریت فیلدها',
            'مدیریت حساب های بانکی | صفحه اصلی',
            'مدیریت حساب های بانکی | حساب جدید',
            'مدیریت حساب های بانکی | ویرایش حساب',
            'مدیریت حساب های بانکی | حذف حساب',
            'مدیریت حساب های بانکی | گزارش',
            'مدیریت کاربران | منو',
            'مدیریت کاربران | صفحه اصلی',
            'مدیریت کاربران | کاربر جدید',
            'مدیریت کاربران | ویرایش کاربر',
            'مدیریت سرویس ها | صفحه اصلی',
            'مدیریت سرویس ها | سرویس جدید',
            'مدیریت سرویس ها | ویرایش سرویس',
            'مدیریت سرویس ها | حذف سرویس',
            'مدیریت سرویس ها | تاریخچه سرویس',
            'مدیریت سرویس ها | فاکتورهای سرویس',
            'مدیریت سرویس ها | فاکتورهای سرویس | ایجاد فاکتور',
            'مدیریت سرویس ها | فاکتورهای سرویس | ویرایش فاکتور',
            'مدیریت سرویس ها | فاکتورهای سرویس | حذف فاکتور',
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
