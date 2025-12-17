<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            مدیریت کاربران | کاربر جدید
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-3 text-gray-900 dark:text-gray-100">
                    <button href="{{ route('users.index') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            wire:navigate
                            title="بازگشت به کاربران">بازگشت به کاربران
                    </button>
                </div>
                <form wire:submit="store" class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
                    <div class="grid grid-cols-2 gap-1 gap-y-2">
                        <div class="space-y-1 w-full">
                            <x-input-label value="مشخصات*"/>
                            <x-text-input class="w-full" wire:model="name" placeholder="مشخصات را وارد کنید"/>
                            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                        </div>
                        <div class="space-y-1 w-full">
                            <x-input-label value="ایمیل*"/>
                            <x-text-input class="w-full" wire:model="email" type="email"
                                          placeholder="ایمیل را وارد کنید"/>
                            <x-input-error class="mt-2" :messages="$errors->get('email')"/>
                        </div>
                        <div class="space-y-1 w-full">
                            <x-input-label value="رمز عبور*"/>
                            <x-text-input class="w-full" wire:model="password" type="password"
                                          placeholder="رمز عبور را وارد کنید"/>
                            <x-input-error class="mt-2" :messages="$errors->get('password')"/>
                        </div>
                        <div class="space-y-1 w-full">
                            <x-input-label value="نقش*"/>
                            <x-select-input
                                placeholder="انتخاب کنید"
                                :options="$roles"
                                wire:model="role"
                                title="لطفا قالب رسانه را انتخاب کنید"
                            ></x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('role')"/>
                        </div>
                    </div>
                    <div class="px-6 py-3 text-left text-gray-900 dark:text-gray-100">
                        <x-send-button wire:loading.remove type="submit">ایجاد کاربر جدید
                        </x-send-button>
                        <span wire:loading class="text-gray-500">در حال پردازش...</span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
