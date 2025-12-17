<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            مقادیر اولیه - نقش های کاربری
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @can('مقادیر اولیه | مدیریت نقش های کاربری')
                        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                x-on:click="$dispatch('resetCatalogName'); $dispatch('open-modal', 'create');"
                                title="نقش جدید">نقش جدید
                        </button>
                    @endcan

                    <x-modal name="create">
                        <form wire:submit.prevent="store">
                            <div class="p-4">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight"
                                    >نقش جدید
                                    </h2>
                                </div>
                                <div class="mt-4 space-y-1">
                                    <x-input-label value="نام نقش"/>
                                    <x-text-input wire:model="name" placeholder="نام نقش را وارد کنید"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                                </div>
                                <div class="mt-4 space-y-1">
                                    <x-input-label value="دسترسی ها"/>
                                    <div class="grid grid-cols-2">
                                        @foreach($this->permissions as $permission)
                                            <div class="flex gap-2 gap-y-2"
                                                 wire:key="permission-create-{{ $permission }}">
                                                <input
                                                        type="checkbox"
                                                        wire:model="selected_permissions"
                                                        value="{{ $permission }}"
                                                        id="{{ $permission }}"
                                                >
                                                <x-input-label
                                                        for="{{ $permission }}"
                                                        value="{{ $permission }}"
                                                        class="cursor-pointer"
                                                />
                                            </div>
                                        @endforeach
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('selected_permissions')"/>
                                </div>
                            </div>
                            <div class="flex items-center justify-end gap-4 p-4">
                                <x-primary-button wire:loading.remove type="submit">ایجاد</x-primary-button>
                                <span wire:loading class="text-gray-500">در حال پردازش...</span>
                            </div>
                        </form>
                    </x-modal>

                    <x-modal name="edit">
                        <form wire:submit.prevent="update">
                            <div class="p-4">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight"
                                    >ویرایش نقش
                                    </h2>
                                    <button x-on:click="$dispatch('close-modal', 'edit')"
                                            class="text-gray-500 dark:text-gray-400 hover:text-gray-700">
                                        <x-icons.x class="h-6 w-6"/>
                                    </button>
                                </div>
                                <div class="grid grid-cols-2 w-full">
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="نام نقش"/>
                                        <x-text-input class=" w-full" wire:model="name"
                                                      placeholder="نام نقش را وارد کنید"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                                    </div>
                                </div>
                                <div class="mt-4 space-y-1">
                                    <x-input-label value="دسترسی ها"/>
                                    <div class="grid grid-cols-2">
                                        @foreach($this->permissions as $permission)
                                            <div class="flex gap-2 gap-y-2"
                                                 wire:key="permission-update-{{ $permission }}">
                                                <input
                                                        type="checkbox"
                                                        wire:model="selected_permissions"
                                                        value="{{ $permission }}"
                                                        id="{{ $permission }}"
                                                >
                                                <x-input-label
                                                        for="{{ $permission }}"
                                                        value="{{ $permission }}"
                                                        class="cursor-pointer"
                                                />
                                            </div>
                                        @endforeach
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('selected_permissions')"/>
                                </div>
                            </div>
                            <div class="flex items-center justify-end gap-4 p-4">
                                <x-primary-button wire:loading.remove type="submit">ویرایش</x-primary-button>
                            </div>
                        </form>
                    </x-modal>

                    <hr class="mt-2 border-gray-500 mb-2"/>

                    @livewire('tables.catalogs.roles-table')
                </div>
            </div>
        </div>
    </div>
</div>
