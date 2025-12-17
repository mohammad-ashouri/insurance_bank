<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            مدیریت کاربران
        </h2>
    </x-slot>

    <div class="py-12"
         x-data
         x-on:livewire:navigated="$wire.$refresh()">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @can('مدیریت کاربران | کاربر جدید')
                        <button href="{{ route('users.create') }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                wire:navigate
                                title="کاربر جدید">کاربر جدید
                        </button>
                    @endcan

                    <hr class="mt-2 border-gray-500 mb-2"/>
                    @livewire('tables.users-table')
                </div>
            </div>
        </div>
    </div>
</div>
