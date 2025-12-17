<?php

use App\Livewire\BankAccounts\Index as BankAccountsIndex;
use App\Livewire\BankAccounts\Invoices as BankAccountsReport;
use App\Livewire\Services\Index as ServicesIndex;
use App\Livewire\Services\Create as ServicesCreate;
use App\Livewire\Services\Invoices\Index as ServicesFactorCreate;
use App\Livewire\Catalogs\Banks;
use App\Livewire\Catalogs\Cycles;
use App\Livewire\Catalogs\Fields;
use App\Livewire\Catalogs\Roles;
use App\Livewire\Catalogs\ServiceType;
use App\Livewire\Catalogs\ServiceTypeField;
use App\Livewire\Dashboard;
use App\Livewire\User\Profile;
use App\Livewire\Users\Create as UsersCreate;
use App\Livewire\Users\Edit as UsersEdit;
use App\Livewire\Users\Index as UsersIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/profile', Profile::class)
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::prefix('catalog')->group(function () {
        Route::get('roles', Roles::class)->name('roles');
        Route::get('banks', Banks::class)->name('banks');
    });

//    Route::prefix('services')->group(function () {
//        Route::get('', ServicesIndex::class)->name('services.index');
//        Route::get('create', ServicesCreate::class)->name('services.create');
//        Route::prefix('invoices')->group(function () {
//            Route::get('{service_id}', ServicesFactorCreate::class)->name('services.invoices');
//        });
//    });

    Route::prefix('users')->group(function () {
        Route::get('/', UsersIndex::class)->name('users.index');
        Route::get('/create', UsersCreate::class)->name('users.create');
        Route::get('/edit/{id}', UsersEdit::class)->name('users.edit');
    });

});

require __DIR__ . '/auth.php';
