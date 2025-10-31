<?php

use App\Http\Controllers\AttendanceController;
use App\Livewire\Attendance\Create as AttendanceCreate;

use App\Livewire\User\Create as UserCreate;
use App\Livewire\User\Index as UserIndex;
use App\Livewire\Stiker\Create as StikerCreate;
use App\Livewire\Stiker\Index as StikerIndex;
use App\Livewire\Stiker\Kunjungan as StikerKunjungan;
use App\Livewire\Attendance\Index as AttendanceIndex;
use App\Livewire\Attendance\Token as AttendanceToken;
use App\Livewire\Config;
use App\Livewire\Driver\Index as DriverIndex;
use App\Livewire\Driver\Create as DriverCreate;
use App\Livewire\Pembayaran\Index as PembayaranIndex;
use App\Livewire\Pembayaran\Create as PembayaranCreate;
use App\Livewire\Komisi\Index as KomisiIndex;
use App\Livewire\Komisi\Create as KomisiCreate;
use App\Livewire\Driver\Show as DriverShow;
use App\Livewire\Product\Index as ProductIndex;
use App\Livewire\Product\Create as ProductCreate;
use App\Livewire\Transaction\Create as TransactionCreate;
use App\Livewire\Transaction\Index as TransactionIndex;
use App\Livewire\Transaction\Withdrawal as TransactionWithdrawal;
use App\Livewire\Withdrawal\Request as WithdrawalRequest;
use App\Livewire\Withdrawal\Index as WithdrawalIndex;
use App\Livewire\Withdrawal\Accepted as WithdrawalAccepted;
use Illuminate\Cache\RedisTagSet;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect(route('login'));
})->name('home');



Route::middleware(['auth', 'verify'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');



    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth', 'verify', 'user'])->group(function () {

    Route::get('kunjungan', AttendanceIndex::class)->name('stiker.index');
    Route::get('transaksi/', TransactionIndex::class)->name('transaction.index');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verify', 'staff'])->group(function () {
    Route::get('catat_kunjungan', AttendanceCreate::class)->name('attendance.create');
    Route::get('tambah-transaksi/', TransactionCreate::class)->name('transaction.create');
    Route::get('transaksi/{slug}/cairkan-komisi', TransactionWithdrawal::class)->name('transaction.withdrawal');
    Route::get('scan', [AttendanceController::class, 'index'])->name('attendance.scan');

    Route::get('scan-kunjungan', StikerKunjungan::class)->name('kunjungan');
    Route::get('tambah-kunjungan', StikerCreate::class)->name('stiker.create');
});

Route::middleware(['auth', 'verify', 'admin'])->group(function () {
    Route::get('staff/', action: UserIndex::class)->name('user.index');
    Route::get('tambah-staff/', UserCreate::class)->name('user.create');
    Route::get('edit-staff/{slug}', UserCreate::class)->name('user.edit');

    Route::get('business-configuration', Config::class)->name('config');

    Route::get('produk', ProductIndex::class)->name('product.index');
    Route::get('tambah-produk', ProductCreate::class)->name('product.create');
    Route::get('edit-produk/{slug}', ProductCreate::class)->name('product.edit');

    // Route::get('komisi', KomisiIndex::class)->name('komisi.index');
    // Route::get('tambah-komisi', KomisiCreate::class)->name('komisi.create');
    // Route::get('edit-komisi/{slug}', KomisiCreate::class)->name('komisi.edit');

    // Route::get('pembayaran', PembayaranIndex::class)->name('pembayaran.index');
    // Route::get('tambah-pembayaran', PembayaranCreate::class)->name('pembayaran.create');
    Route::get('pembayaran-komisi/{slug}', PembayaranCreate::class)->name('pembayaran.create');

    Route::get('driver', DriverIndex::class)->name('driver.index');
    Route::get('tambah-driver', DriverCreate::class)->name('driver.create');
    Route::get('detail-driver/{slug}', DriverShow::class)->name('driver.show');
    Route::get('edit-driver/{slug}', DriverCreate::class)->name('driver.edit');

    // Route::get('kunjungan', StikerIndex::class)->name('stiker.index');

    Route::get('kunjungan/{token}', AttendanceToken::class)->name('attendance.token');

    Route::get('tukar-poin/', WithdrawalIndex::class)->name('withdrawal.index');
    Route::get('proses-tukar-poin/{token}', WithdrawalAccepted::class)->name('withdrawal.token');
});

Route::middleware(['auth', 'verify', 'driver'])->group(function () {
    // Route::get('dashboard', DriverShow::class)->name('dashboard');

    Route::get('permintaan-tukar-poin', WithdrawalRequest::class)->name('withdrawal.request');

    Volt::route('settings/bank', 'settings.bank')->name('settings.bank');
});
