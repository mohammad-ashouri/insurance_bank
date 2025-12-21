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

                    <x-modal maxWidth="5xl" name="create">
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
                                        <x-tag-input
                                                :tags="$policyholders"
                                                :allowUserInput="false"
                                                placeholder-text="بیمه گذار را انتخاب کنید"
                                                variable="form.policy_holder_id"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.policy_holder_id')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="مالک وسیله نقلیه*"/>
                                        <x-tag-input
                                                :tags="$policyholders"
                                                :allowUserInput="false"
                                                placeholder-text="مالک وسیله نقلیه را انتخاب کنید"
                                                variable="form.owner_id"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.owner_id')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="نوع بیمه*"/>
                                        <x-tag-input
                                                :tags="$insurance_types"
                                                :allowUserInput="false"
                                                placeholder-text="نوع بیمه را انتخاب کنید"
                                                variable="form.insurance_type"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.insurance_type')"/>
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
                                            <x-input-label value="تصویر کارت بیمه(اختیاری)"/>
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
                                            <x-input-label value="تصویر الحاقیه(اختیاری)"/>
                                            <x-filepond::upload wire:model="form.attachment_insurance_photo"
                                                                :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                                :allowMultiple="false"
                                                                :instantUpload="true"
                                                                server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                                :chunkSize="2000000"/>
                                            <x-input-error class="mt-2"
                                                           :messages="$errors->get('form.attachment_insurance_photo')"/>
                                            <x-input-info
                                                    :messages="[
                                                'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                'حداکثر حجم فایل: 5MB',
                                            ]"
                                                    type="info"
                                                    class="mb-4"/>
                                        </div>
                                        <x-input-error class="mt-2"
                                                       :messages="$errors->get('form.attachment_insurance_photo')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <div class="space-y-1 w-full">
                                            <x-input-label value="تصویر کارت ماشین (رو)(اختیاری)"/>
                                            <x-filepond::upload wire:model="form.vehicle_card_up"
                                                                :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                                :allowMultiple="false"
                                                                :instantUpload="true"
                                                                server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                                :chunkSize="2000000"/>
                                            <x-input-error class="mt-2"
                                                           :messages="$errors->get('form.vehicle_card_up')"/>
                                            <x-input-info
                                                    :messages="[
                                                'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                'حداکثر حجم فایل: 5MB',
                                            ]"
                                                    type="info"
                                                    class="mb-4"/>
                                        </div>
                                        <x-input-error class="mt-2"
                                                       :messages="$errors->get('form.vehicle_card_up')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <div class="space-y-1 w-full">
                                            <x-input-label value="تصویر کارت ماشین (پشت)(اختیاری)"/>
                                            <x-filepond::upload wire:model="form.vehicle_card_down"
                                                                :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                                :allowMultiple="false"
                                                                :instantUpload="true"
                                                                server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                                :chunkSize="2000000"/>
                                            <x-input-error class="mt-2"
                                                           :messages="$errors->get('form.vehicle_card_down')"/>
                                            <x-input-info
                                                    :messages="[
                                                'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                'حداکثر حجم فایل: 5MB',
                                            ]"
                                                    type="info"
                                                    class="mb-4"/>
                                        </div>
                                        <x-input-error class="mt-2"
                                                       :messages="$errors->get('form.vehicle_card_down')"/>
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
                                        <x-input-label value="بیمه گذار*"/>
                                        <x-tag-input
                                                :tags="$policyholders"
                                                :allowUserInput="false"
                                                placeholder-text="بیمه گذار را انتخاب کنید"
                                                variable="form.policy_holder_id"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.policy_holder_id')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="مالک وسیله نقلیه*"/>
                                        <x-tag-input
                                                :tags="$policyholders"
                                                :allowUserInput="false"
                                                placeholder-text="مالک وسیله نقلیه را انتخاب کنید"
                                                variable="form.owner_id"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.owner_id')"/>
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <x-input-label value="نوع بیمه*"/>
                                        <x-tag-input
                                                :tags="$insurance_types"
                                                :allowUserInput="false"
                                                placeholder-text="نوع بیمه را انتخاب کنید"
                                                variable="form.insurance_type"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.insurance_type')"/>
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
                                            <x-input-label value="تصویر کارت بیمه(اختیاری)"/>
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
                                            <x-input-label value="تصویر الحاقیه(اختیاری)"/>
                                            <x-filepond::upload wire:model="form.attachment_insurance_photo"
                                                                :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                                :allowMultiple="false"
                                                                :instantUpload="true"
                                                                server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                                :chunkSize="2000000"/>
                                            <x-input-error class="mt-2"
                                                           :messages="$errors->get('form.attachment_insurance_photo')"/>
                                            <x-input-info
                                                    :messages="[
                                                'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                'حداکثر حجم فایل: 5MB',
                                            ]"
                                                    type="info"
                                                    class="mb-4"/>
                                        </div>
                                        <x-input-error class="mt-2"
                                                       :messages="$errors->get('form.attachment_insurance_photo')"/>
                                        @if($this->attachment_insurance_photo!=null) <x-image alt="برای نمایش کلیک کنید" src="{{ $this->attachment_insurance_photo->src }}"/> @endif
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <div class="space-y-1 w-full">
                                            <x-input-label value="تصویر کارت ماشین (رو)(اختیاری)"/>
                                            <x-filepond::upload wire:model="form.vehicle_card_up"
                                                                :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                                :allowMultiple="false"
                                                                :instantUpload="true"
                                                                server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                                :chunkSize="2000000"/>
                                            <x-input-error class="mt-2"
                                                           :messages="$errors->get('form.vehicle_card_up')"/>
                                            <x-input-info
                                                    :messages="[
                                                'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                'حداکثر حجم فایل: 5MB',
                                            ]"
                                                    type="info"
                                                    class="mb-4"/>
                                        </div>
                                        <x-input-error class="mt-2"
                                                       :messages="$errors->get('form.vehicle_card_up')"/>
                                        @if($this->vehicle_card_up!=null) <x-image alt="برای نمایش کلیک کنید" src="{{ $this->vehicle_card_up->src }}"/> @endif
                                    </div>
                                    <div class="mt-4 space-y-1">
                                        <div class="space-y-1 w-full">
                                            <x-input-label value="تصویر کارت ماشین (پشت)(اختیاری)"/>
                                            <x-filepond::upload wire:model="form.vehicle_card_down"
                                                                :accept="'image/jpg,image/png,image/jpeg,image.bmp'"
                                                                :allowMultiple="false"
                                                                :instantUpload="true"
                                                                server-headers='@json(["X-CSRF-TOKEN" => csrf_token()])'
                                                                :chunkSize="2000000"/>
                                            <x-input-error class="mt-2"
                                                           :messages="$errors->get('form.vehicle_card_down')"/>
                                            <x-input-info
                                                    :messages="[
                                                'فرمت‌های مجاز: png,jpg,jpeg,bmp',
                                                'حداکثر حجم فایل: 5MB',
                                            ]"
                                                    type="info"
                                                    class="mb-4"/>
                                        </div>
                                        <x-input-error class="mt-2"
                                                       :messages="$errors->get('form.vehicle_card_down')"/>
                                        @if($this->vehicle_card_down!=null) <x-image alt="برای نمایش کلیک کنید" src="{{ $this->vehicle_card_down->src }}"/> @endif
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
