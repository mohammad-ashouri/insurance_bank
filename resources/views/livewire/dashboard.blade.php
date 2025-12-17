<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            داشبورد
        </h2>
    </x-slot>

    <div class="py-12 gap-y-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ auth()->user()->name }}
                    عزیز؛ به پنل مدیریت خوش آمدید!
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 gap-1">
                <x-cards.two_box_card
                        title="وضعیت سرویس ها"
                        blue_side_label="تعداد کل"
                        blue_side_value="{{ (clone $services)->count() }}"
                        green_side_label="فعال"
                        green_side_value="{{ (clone $services)->where('status',1)->count() }}"
                        red_side_label="غیرفعال"
                        red_side_value="{{ (clone $services)->where('status',0)->count() }}"
                        :grid_cols="3"
                />
                <x-cards.two_box_card
                        title="وضعیت انقضا سرویس ها"
                        green_side_label="منقضی نشده"
                        green_side_value="{{ $not_expired }}"
                        red_side_label="منقضی شده"
                        red_side_value="{{ $expired }}"
                />
                <div class="grid grid-cols-2 gap-2">
                    @foreach($service_status as $name=>$status)
                        <x-cards.two_box_card
                                title="سرویس: {{ $name }}"
                                green_side_label="منقضی نشده"
                                green_side_value="{{ $status['not_expired'] }}"
                                red_side_label="منقضی شده"
                                red_side_value="{{ $status['expired'] }}"
                        />
                    @endforeach
                </div>
            </div>
            <div class="grid grid-cols-2 gap-1">
                <x-cards.two_box_card
                        title="وضعیت حساب های بانکی"
                        blue_side_label="تعداد کل"
                        blue_side_value="{{ (clone $bank_accounts)->count() }}"
                        green_side_label="فعال"
                        green_side_value="{{ (clone $bank_accounts)->where('status',1)->count() }}"
                        red_side_label="غیرفعال"
                        red_side_value="{{ (clone $bank_accounts)->where('status',0)->count() }}"
                        :grid_cols="3"
                />
            </div>
        </div>
    </div>
</div>
