<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{--                <!-- Logo -->--}}
                {{--                <div class="shrink-0 flex items-center">--}}
                {{--                    <a href="{{ route('dashboard') }}" wire:navigate>--}}
                {{--                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"/>--}}
                {{--                    </a>--}}
                {{--                </div>--}}

                <!-- Navigation Links -->
                <div class="hidden space-x-0 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        داشبورد
                    </x-nav-link>
                    @canany(['مقادیر اولیه | مدیریت نقش های کاربری','مقادیر اولیه | مدیریت سیکل های صورتحساب'])
                        <div
                            class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        <div>مقادیر اولیه</div>

                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    @can('مقادیر اولیه | مدیریت نقش های کاربری')
                                        <x-dropdown-link :href="route('roles')" wire:navigate>
                                            نقش های کاربری
                                        </x-dropdown-link>
                                    @endcan
                                    @can('مقادیر اولیه | مدیریت سیکل های صورتحساب')
                                        <x-dropdown-link :href="route('cycles')" wire:navigate>
                                            سیکل های صورتحساب
                                        </x-dropdown-link>
                                    @endcan
                                    @can('مقادیر اولیه | مدیریت بانک ها')
                                        <x-dropdown-link :href="route('banks')" wire:navigate>
                                            بانک ها
                                        </x-dropdown-link>
                                    @endcan
                                    @can('مقادیر اولیه | مدیریت فیلد ها')
                                        <x-dropdown-link :href="route('fields')" wire:navigate>
                                            فیلد ها
                                        </x-dropdown-link>
                                    @endcan
                                    @can('مقادیر اولیه | مدیریت انواع سرویس')
                                        <x-dropdown-link :href="route('service_types')" wire:navigate>
                                            انواع سرویس
                                        </x-dropdown-link>
                                    @endcan
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endcanany
                    @can('مدیریت حساب های بانکی | صفحه اصلی')
                        <x-nav-link :href="route('bank_accounts.index')"
                                    :active="request()->routeIs('bank_accounts.index')"
                                    wire:navigate>
                            حساب های بانکی
                        </x-nav-link>
                    @endcan
                    @can('مدیریت سرویس ها | صفحه اصلی')
                        <x-nav-link :href="route('services.index')"
                                    :active="request()->routeIs('services.index')"
                                    wire:navigate>
                            سرویس ها
                        </x-nav-link>
                    @endcan
                    @can('مدیریت کاربران | منو')
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')"
                                    wire:navigate>
                            کاربران
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                                 x-on:profile-updated.window="name = $event.detail.name"></div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            پروفایل
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link class="!text-red-400">
                                خروج از حساب کاربری
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                داشبورد
            </x-responsive-nav-link>
            @canany(['مقادیر اولیه | مدیریت نقش های کاربری','مقادیر اولیه | سیکل های صورتحساب'])
                <div class="flex items-center sm:hidden">
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>مقادیر اولیه</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @can('مقادیر اولیه | مدیریت نقش های کاربری')
                                <x-dropdown-link :href="route('roles')" wire:navigate>
                                    نقش های کاربری
                                </x-dropdown-link>
                            @endcan
                            @can('مقادیر اولیه | سیکل های صورتحساب')
                                <x-dropdown-link :href="route('cycles')" wire:navigate>
                                    سیکل های صورتجساب
                                </x-dropdown-link>
                            @endcan
                            @can('مقادیر اولیه | بانک ها')
                                <x-dropdown-link :href="route('banks')" wire:navigate>
                                    بانک ها
                                </x-dropdown-link>
                            @endcan
                            @can('مقادیر اولیه | فیلد ها')
                                <x-dropdown-link :href="route('fields')" wire:navigate>
                                    فیلد ها
                                </x-dropdown-link>
                            @endcan
                            @can('مقادیر اولیه | مدیریت انواع سرویس')
                                <x-dropdown-link :href="route('service_types')" wire:navigate>
                                    انواع سرویس
                                </x-dropdown-link>
                            @endcan
                        </x-slot>
                    </x-dropdown>
                </div>
            @endcanany
            @can('مدیریت حساب های بانکی | صفحه اصلی')
                <x-responsive-nav-link :href="route('bank_accounts.index')"
                                       :active="request()->routeIs('bank_accounts.index')"
                                       wire:navigate>
                    حساب های بانکی
                </x-responsive-nav-link>
            @endcan
            @can('مدیریت سرویس ها | صفحه اصلی')
                <x-responsive-nav-link :href="route('services.index')"
                                       :active="request()->routeIs('services.index')"
                                       wire:navigate>
                    سرویس ها
                </x-responsive-nav-link>
            @endcan
            @can('مدیریت کاربران | منو')
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')"
                                       wire:navigate>
                    کاربران
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200"
                     x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                     x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    پروفایل
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        خروج از حساب کاربری
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
