<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DanaKomitmenController;
use App\Http\Controllers\DanaDPController;
use App\Http\Controllers\DanaPelunasanController;
use App\Http\Controllers\PembayaranBulananController;

use App\Livewire\Counter;
use App\Models\PembayaranBulanan;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //ROUTING CUSTOMER
    Route::get('customer/active', [CustomerController::class, 'indexActive'])->name('customer.active');
    Route::get('customer/candidate', [CustomerController::class, 'indexCandidate'])->name('customer.candidate');
    Route::resource('customer', CustomerController::class);

    // ROUTING DANA KOMITMEN
    Route::get('danakomitmen/create/{customer}',[DanaKomitmenController::class, 'create'])->name('danakomitmen.create');
    Route::post('danakomitmen', [DanaKomitmenController::class, 'store'])->name('danakomitmen.store');
    Route::delete('danakomitmen/{dana_komitmen}', [DanaKomitmenController::class, 'destroy'])->name('danakomitmen.destroy');

    // ROUTING DANA DP
    Route::get('danadp/create/{customer}',[DanaDPController::class, 'create'])->name('danadp.create');
    Route::post('danadp', [DanaDPController::class, 'store'])->name('danadp.store');
    Route::delete('danadp/{dana_dp}', [DanaDPController::class, 'destroy'])->name('danadp.destroy');

    // ROUTING DANA PELUNASAN
    Route::get('danapelunasan/create/{customer}',[DanaPelunasanController::class, 'create'])->name('danapelunasan.create');
    Route::post('danapelunasan', [DanaPelunasanController::class, 'store'])->name('danapelunasan.store');
    Route::delete('danapelunasan/{dana_pelunasan}', [DanaPelunasanController::class, 'destroy'])->name('danapelunasan.destroy');

    //ROUTING PEMBAYARAN BULANAN
    Route::get('pembayaran/bulanan/create', [PembayaranBulananController::class, 'createCustomer'])->name('bulanan.create.customer');
    Route::get('pembayaran/bulanan/create/{customer}',[PembayaranBulananController::class, 'createPeriod'])->name('bulanan.create.period');
    Route::get('pembayaran/bulanan/year/{year}',[PembayaranBulananController::class, 'index'])->name('bulanan.index');
    Route::get('pembayaran/bulanan/detail/{customer}',[PembayaranBulananController::class, 'show'])->name('bulanan.show');
    Route::post('pembayaran/bulanan/', [PembayaranBulananController::class, 'store'])->name('bulanan.store');
    Route::delete('pembayaran/bulanan/{pembayaran_bulanan}', [PembayaranBulananController::class, 'destroy'])->name('bulanan.destroy');

});
