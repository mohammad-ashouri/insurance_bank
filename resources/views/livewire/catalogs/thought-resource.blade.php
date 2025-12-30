<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            مقادیر اولیه - منبع اندیشه
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @can('مقادیر اولیه | مدیریت منبع اندیشه')
                        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                x-on:click="$dispatch('resetCatalogName'); $dispatch('open-modal', 'create');"
                                title="جدید"> جدید
                        </button>
                    @endcan

                    <x-modal name="create">
                        <form wire:submit.prevent="store">
                            <div class="p-4">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight"
                                    >منبع اندیشه جدید
                                    </h2>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="نام منبع اندیشه"/>
                                        <x-text-input wire:model="name"
                                                      class="w-full"
                                                      placeholder="نام منبع اندیشه را وارد کنید"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="تصویر منبع اندیشه"/>
                                        <x-filepond::upload required="false" wire:model="attachment_file"
                                                            :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                            :allowMultiple="false"
                                                            :instantUpload="true"
                                                            server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                            :chunkSize="2000000"
                                        />
                                        <x-input-info
                                                :messages="[
                                                    'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                    'حداکثر حجم فایل: 300KB',
                                                    'سایز عکس: 50px*50px',
                                                ]"
                                                type="info"
                                                class="mb-4"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('attachment_file')"/>
                                    </div>
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
                                    >ویرایش منبع اندیشه
                                    </h2>
                                    <button x-on:click="$dispatch('close-modal', 'edit')"
                                            class="text-gray-500 dark:text-gray-400 hover:text-gray-700">
                                        <x-icons.x class="h-6 w-6"/>
                                    </button>
                                </div>
                                <div class="grid grid-cols-2 gap-2 w-full">
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="نام منبع اندیشه"/>
                                        <x-text-input class=" w-full" wire:model="name"
                                                      placeholder="نام منبع اندیشه را وارد کنید"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="تصویر منبع اندیشه"/>
                                        <x-filepond::upload required="false" wire:model="attachment_file"
                                                            :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                            :allowMultiple="false"
                                                            :instantUpload="true"
                                                            server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                            :chunkSize="2000000"
                                        />
                                        <x-input-info
                                                :messages="[
                                                    'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                    'حداکثر حجم فایل: 300KB',
                                                    'سایز عکس: 50px*50px',
                                                ]"
                                                type="info"
                                                class="mb-4"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('attachment_file')"/>
                                        @if($this->thought_resource_photo!=null)
                                            <x-image alt="برای نمایش کلیک کنید"
                                                     src="{{ $this->thought_resource_photo }}"/>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-end gap-4 p-4">
                                <x-primary-button wire:loading.remove type="submit">ویرایش</x-primary-button>
                                <span wire:loading class="text-gray-500">در حال پردازش...</span>
                            </div>
                        </form>
                    </x-modal>

                    <x-modal name="confirm-delete" :show="$errors->isNotEmpty()" focusable>
                        <form wire:submit="delete()" class="p-6">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                آیا مایل به حذف این آیتم هستید؟
                            </h2>
                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    لغو
                                </x-secondary-button>

                                <x-danger-button class="ms-3">
                                    تایید
                                </x-danger-button>
                            </div>
                        </form>
                    </x-modal>

                    <hr class="mt-2 border-gray-500 mb-2"/>

                    @livewire('tables.catalogs.thought-resources-table')
                </div>
            </div>
        </div>
    </div>
</div>
