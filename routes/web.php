<?php

use App\Livewire\Attendance\Token as AttendanceToken;
use App\Livewire\Driver\Index as DriverIndex;
use App\Livewire\Driver\Create as DriverCreate;
use App\Livewire\Driver\Show as DriverShow;
use App\Livewire\Product\Index as ProductIndex;
use App\Livewire\Product\Create as ProductCreate;
use App\Livewire\Transaction\Index;
use App\Livewire\Withdrawal\Index as WithdrawalIndex;
use App\Livewire\Withdrawal\Accepted as WithdrawalAccepted;
use Illuminate\Support\Facades\Route;
use League\ISO3166\ISO3166;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect(route('login'));
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::get('product', ProductIndex::class)->name('product.index');
    Route::get('add-product', ProductCreate::class)->name('product.create');
    Route::get('edit-product/{slug}', ProductCreate::class)->name('product.edit');

    Route::get('driver', DriverIndex::class)->name('driver.index');
    Route::get('add-driver', DriverCreate::class)->name('driver.create');
    Route::get('show-driver/{slug}', DriverShow::class)->name('driver.show');

    Route::get('attendance/{token}', AttendanceToken::class)->name('attendance.token');

    Route::get('transaction/', Index::class)->name('transaction.index');

    Route::get('withdrawal/', WithdrawalIndex::class)->name('withdrawal.index');
    Route::get('accept-withdrawal/{token}', WithdrawalAccepted::class)->name('withdrawal.token');
});

require __DIR__ . '/auth.php';
