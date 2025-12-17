<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            مقادیر اولیه - بانک ها
        </h2>
    </x-slot>

    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @can('مقادیر اولیه | مدیریت بانک ها')
                        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                x-on:click="$dispatch('resetForm'); $dispatch('open-modal', 'create');"
                                title="بانک جدید">بانک جدید
                        </button>
                    @endcan

                    <x-modal name="create">
                        <form wire:submit="store">
                            <div class="p-4 ">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight"
                                    >بانک جدید
                                    </h2>
                                    <button x-on:click="$dispatch('close-modal', 'create')"
                                            class="text-gray-500 dark:text-gray-400 hover:text-gray-700">
                                        <x-icons.x class="h-6 w-6"/>
                                    </button>
                                </div>
                                <div class="mt-4 space-y-1">
                                    <x-input-label value="عنوان*"/>
                                    <x-text-input wire:model="name" class="w-full" placeholder="عنوان را وارد کنید"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                                </div>
                            </div>
                            <div class="flex items-center justify-end gap-4 p-4">
                                <x-primary-button wire:loading.remove type="submit">ایجاد</x-primary-button>
                                <span wire:loading class="text-gray-500">در حال پردازش...</span>
                            </div>
                        </form>
                    </x-modal>

                    <x-modal name="edit">
                        <form wire:submit="edit">
                            <div class="p-4 ">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight"
                                    >ویرایش بانک
                                    </h2>
                                </div>
                                <div class="mt-4 space-y-1">
                                    <x-input-label value="عنوان*"/>
                                    <x-text-input wire:model="name" class="w-full" placeholder="عنوان را وارد کنید"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                                </div>
                                <div class="mt-4 space-y-1">
                                    <x-input-label value="وضعیت*"/>
                                    <x-select-input
                                            :options="
                                                [
                                                1=>'فعال',
                                                0=>'غیرفعال',
                                                ]"
                                            wire:model="status"
                                            title="لطفا وضعیت را انتخاب کنید"
                                    ></x-select-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('status')"/>
                                </div>
                            </div>
                            <div class="flex items-center justify-end gap-4 p-4">
                                <x-primary-button wire:loading.remove type="submit">ویرایش</x-primary-button>
                                <span wire:loading class="text-gray-500">در حال پردازش...</span>
                            </div>
                        </form>
                    </x-modal>

                    <hr class="mt-2 border-gray-500 mb-2"/>

                    @livewire('tables.catalogs.banks-table')

                </div>
            </div>
        </div>
    </div>
</div>
