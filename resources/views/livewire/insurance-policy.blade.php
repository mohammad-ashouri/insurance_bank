@php use Illuminate\Support\Facades\Storage; @endphp
<div>
    <script>
        jalaliDatepicker.startWatch({
            minDate: "attr",
            maxDate: "attr",
            hideAfterChange: true
        });

    </script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            بیمه نامه ها
        </h2>
    </x-slot>

    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @can('مدیریت بیمه نامه ها')
                        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                x-on:click="$dispatch('resetForm'); $dispatch('open-modal', 'create');"
                                title="جدید"> جدید
                        </button>
                    @endcan

                    <x-modal maxWidth="4xl" name="create">
                        <form wire:submit="store">
                            <div class="p-4">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight"
                                    >بیمه نامه جدید
                                    </h2>
                                    <button x-on:click="$dispatch('close-modal', 'create')"
                                            class="text-gray-500 dark:text-gray-400 hover:text-gray-700">
                                        <x-icons.x class="h-6 w-6"/>
                                    </button>
                                </div>
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="بیمه گذار*"/>
                                        <x-tag-input :tags="$policyholders" :allowUserInput="false" variable="form.policy_holder_id"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.first_name')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="مالک وسیله نقلیه(اختیاری)"/>
                                        <x-text-input wire:model="form.last_name" class="w-full"
                                                      placeholder="نام خانوادگی را وارد کنید"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.last_name')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="تاریخ شروع بیمه نامه(اختیاری)"/>
                                        <x-text-input wire:model="form.starts_at" class="w-full"
                                                      data-jdp
                                                      placeholder="تاریخ شروع بیمه نامه را وارد کنید"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.starts_at')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="تاریخ پایان بیمه نامه*"/>
                                        <x-text-input wire:model="form.ends_at" class="w-full"
                                                      data-jdp
                                                      placeholder="تاریخ پایان بیمه نامه را وارد کنید"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.ends_at')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="شماره بیمه نامه(اختیاری)"/>
                                        <x-text-input wire:model="form.insurance_policy_number" class="w-full"
                                                      placeholder="شماره بیمه نامه را وارد کنید"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.insurance_policy_number')"/>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="mt-4 space-y-1">
                                        <div class="space-y-1 w-full">
                                            <x-input-label value="تصویر کارت ملی (رو)(اختیاری)"/>
                                            <x-filepond::upload wire:model="form.insurance_policy_photo"
                                                                :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                                :allowMultiple="false"
                                                                :instantUpload="true"
                                                                server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                                :chunkSize="2000000"/>
                                            <x-input-error class="mt-2"
                                                           :messages="$errors->get('form.insurance_policy_photo')"/>
                                            <x-input-info
                                                    :messages="[
                                                'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                'حداکثر حجم فایل: 5MB',
                                            ]"
                                                    type="info"
                                                    class="mb-4"/>
                                        </div>
                                        <x-input-error class="mt-2"
                                                       :messages="$errors->get('form.insurance_policy_photo')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <div class="space-y-1 w-full">
                                            <x-input-label value="تصویر کارت ملی (پشت)(اختیاری)"/>
                                            <x-filepond::upload wire:model="form.vehicle_registration_card"
                                                                :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                                :allowMultiple="false"
                                                                :instantUpload="true"
                                                                server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                                :chunkSize="2000000"/>
                                            <x-input-error class="mt-2"
                                                           :messages="$errors->get('form.vehicle_registration_card')"/>
                                            <x-input-info
                                                    :messages="[
                                                'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                'حداکثر حجم فایل: 5MB',
                                            ]"
                                                    type="info"
                                                    class="mb-4"/>
                                        </div>
                                        <x-input-error class="mt-2"
                                                       :messages="$errors->get('form.vehicle_registration_card')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <div class="space-y-1 w-full">
                                            <x-input-label value="تصویر صفحه اول شناسنامه(اختیاری)"/>
                                            <x-filepond::upload wire:model="form.id_card_photo"
                                                                :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                                :allowMultiple="false"
                                                                :instantUpload="true"
                                                                server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                                :chunkSize="2000000"/>
                                            <x-input-error class="mt-2"
                                                           :messages="$errors->get('form.id_card_photo')"/>
                                            <x-input-info
                                                    :messages="[
                                                'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                'حداکثر حجم فایل: 5MB',
                                            ]"
                                                    type="info"
                                                    class="mb-4"/>
                                        </div>
                                        <x-input-error class="mt-2"
                                                       :messages="$errors->get('form.id_card_photo')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <div class="space-y-1 w-full">
                                            <x-input-label value="تصویر پرسنلی(اختیاری)"/>
                                            <x-filepond::upload wire:model="form.personal_photo"
                                                                :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                                :allowMultiple="false"
                                                                :instantUpload="true"
                                                                server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                                :chunkSize="2000000"/>
                                            <x-input-error class="mt-2"
                                                           :messages="$errors->get('form.personal_photo')"/>
                                            <x-input-info
                                                    :messages="[
                                                'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                'حداکثر حجم فایل: 5MB',
                                            ]"
                                                    type="info"
                                                    class="mb-4"/>
                                        </div>
                                        <x-input-error class="mt-2"
                                                       :messages="$errors->get('form.personal_photo')"/>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-end gap-4 p-4">
                                <x-primary-button wire:loading.remove type="submit">ایجاد</x-primary-button>
                                <span wire:loading class="text-gray-500">در حال پردازش...</span>
                                <x-spinners.ring-resize/>
                            </div>
                        </form>
                    </x-modal>

                    <x-modal maxWidth="4xl" name="edit">
                        <form wire:submit="edit">
                            <div class="p-4 ">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight"
                                    >ویرایش بیمه نامه
                                    </h2>
                                </div>
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="نام*"/>
                                        <x-text-input wire:model="form.first_name" class="w-full"
                                                      placeholder="نام را وارد کنید"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.first_name')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="نام خانوادگی*"/>
                                        <x-text-input wire:model="form.last_name" class="w-full"
                                                      placeholder="نام خانوادگی را وارد کنید"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.last_name')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="نام پدر(اختیاری)"/>
                                        <x-text-input wire:model="form.father_name" class="w-full"
                                                      placeholder="نام پدر را وارد کنید"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.father_name')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="کد ملی(اختیاری)"/>
                                        <x-text-input wire:model="form.national_code" class="w-full"
                                                      placeholder="کد ملی را وارد کنید"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.national_code')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="تاریخ تولد(اختیاری)"/>
                                        <x-text-input wire:model="form.birthdate" class="w-full"
                                                      data-jdp
                                                      data-jdp-max-date="today"
                                                      placeholder="تاریخ تولد را وارد کنید"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.birthdate')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="موبایل*"/>
                                        <x-text-input wire:model="form.mobile" class="w-full"
                                                      placeholder="موبایل را وارد کنید"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.mobile')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="آدرس(اختیاری)"/>
                                        <x-textbox
                                                class="w-full"
                                                placeholder="آدرس را وارد کنید"
                                                wire:model="form.address"
                                        />
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="کدپستی(اختیاری)"/>
                                        <x-text-input wire:model="form.postal_code" class="w-full"
                                                      placeholder="کدپستی را وارد کنید"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.postal_code')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="ایمیل(اختیاری)"/>
                                        <x-text-input wire:model="form.email" class="w-full"
                                                      placeholder="ایمیل را وارد کنید"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.email')"/>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="mt-4 space-y-1">
                                        <div class="space-y-1 w-full">
                                            <x-input-label value="تصویر کارت ملی (رو)(اختیاری)"/>
                                            <x-filepond::upload wire:model="form.insurance_policy_photo"
                                                                :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                                :allowMultiple="false"
                                                                :instantUpload="true"
                                                                server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                                :chunkSize="2000000"/>
                                            <x-input-error class="mt-2"
                                                           :messages="$errors->get('form.insurance_policy_photo')"/>
                                            <x-input-info
                                                    :messages="[
                                                'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                'حداکثر حجم فایل: 5MB',
                                            ]"
                                                    type="info"
                                                    class="mb-4"/>
                                        </div>
                                        <x-input-error class="mt-2"
                                                       :messages="$errors->get('form.insurance_policy_photo')"/>
                                        @if($this->insurance_policy_photo!=null) <x-image alt="برای نمایش کلیک کنید" src="{{ $this->insurance_policy_photo->src }}"/> @endif
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <div class="space-y-1 w-full">
                                            <x-input-label value="تصویر کارت ملی (پشت)(اختیاری)"/>
                                            <x-filepond::upload wire:model="form.vehicle_registration_card"
                                                                :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                                :allowMultiple="false"
                                                                :instantUpload="true"
                                                                server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                                :chunkSize="2000000"/>
                                            <x-input-error class="mt-2"
                                                           :messages="$errors->get('form.vehicle_registration_card')"/>
                                            <x-input-info
                                                    :messages="[
                                                'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                'حداکثر حجم فایل: 5MB',
                                            ]"
                                                    type="info"
                                                    class="mb-4"/>
                                        </div>
                                        <x-input-error class="mt-2"
                                                       :messages="$errors->get('form.vehicle_registration_card')"/>
                                        @if($this->vehicle_registration_card!=null) <x-image alt="برای نمایش کلیک کنید" src="{{ $this->vehicle_registration_card->src }}"/> @endif
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <div class="space-y-1 w-full">
                                            <x-input-label value="تصویر صفحه اول شناسنامه(اختیاری)"/>
                                            <x-filepond::upload wire:model="form.id_card_photo"
                                                                :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                                :allowMultiple="false"
                                                                :instantUpload="true"
                                                                server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                                :chunkSize="2000000"/>
                                            <x-input-error class="mt-2"
                                                           :messages="$errors->get('form.id_card_photo')"/>
                                            <x-input-info
                                                    :messages="[
                                                'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                'حداکثر حجم فایل: 5MB',
                                            ]"
                                                    type="info"
                                                    class="mb-4"/>
                                        </div>
                                        <x-input-error class="mt-2"
                                                       :messages="$errors->get('form.id_card_photo')"/>
                                        @if($this->id_card_photo!=null) <x-image alt="برای نمایش کلیک کنید" src="{{ $this->id_card_photo->src }}"/> @endif
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <div class="space-y-1 w-full">
                                            <x-input-label value="تصویر پرسنلی(اختیاری)"/>
                                            <x-filepond::upload wire:model="form.personal_photo"
                                                                :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                                :allowMultiple="false"
                                                                :instantUpload="true"
                                                                server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                                :chunkSize="2000000"/>
                                            <x-input-error class="mt-2"
                                                           :messages="$errors->get('form.personal_photo')"/>
                                            <x-input-info
                                                    :messages="[
                                                'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                'حداکثر حجم فایل: 5MB',
                                            ]"
                                                    type="info"
                                                    class="mb-4"/>
                                        </div>
                                        <x-input-error class="mt-2"
                                                       :messages="$errors->get('form.personal_photo')"/>
                                        @if($this->personal_photo!=null) <x-image alt="برای نمایش کلیک کنید" src="{{ $this->personal_photo->src }}"/> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-end gap-4 p-4">
                                <x-primary-button wire:loading.remove type="submit">ویرایش</x-primary-button>
                                <span wire:loading class="text-gray-500">در حال پردازش...</span>
                                <x-spinners.ring-resize/>
                            </div>
                        </form>
                    </x-modal>

                    <hr class="mt-2 border-gray-500 mb-2"/>

                    @livewire('tables.insurance-policy-table')

                </div>
            </div>
        </div>
    </div>
</div>
