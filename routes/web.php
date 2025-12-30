<?php

use App\Livewire\Catalogs\ThoughtResource;
use App\Livewire\Catalogs\Roles;
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

    Route::prefix('catalogs')->group(function () {
        Route::get('roles', Roles::class)->name('roles');
        Route::get('thought_resources', ThoughtResource::class)->name('thought_resources');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', UsersIndex::class)->name('users.index');
        Route::get('/create', UsersCreate::class)->name('users.create');
        Route::get('/edit/{id}', UsersEdit::class)->name('users.edit');
    });

});

require __DIR__ . '/auth.php';
