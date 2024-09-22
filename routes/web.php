<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DanaKomitmenController;
use App\Http\Controllers\DanaDPController;
use App\Http\Controllers\DanaPelunasanController;

use App\Livewire\Counter;

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

    Route::get('customer/active', [CustomerController::class, 'indexActive'])->name('customer.active');
    Route::get('customer/candidate', [CustomerController::class, 'indexCandidate'])->name('customer.candidate');
    Route::resource('customer', CustomerController::class);

    // ROUTING DANA KOMITMEN
    Route::get('danakomitmen/create/{customer}',[DanaKomitmenController::class, 'create'])->name('customer.danakomitmen.create');
    Route::resource('danakomitmen', DanaKomitmenController::class, [
        'parameters' => ['danakomitmen' => 'dana_komitmen']
    ]);

    // ROUTING DANA DP
    Route::get('danadp/create/{customer}',[DanaDPController::class, 'create'])->name('customer.danadp.create');
    Route::resource('danadp', DanaDPController::class, [
        'parameters' => ['danadp' => 'dana_dp']
    ]);

    // ROUTING DANA PELUNASAN
    Route::get('danapelunasan/create/{customer}',[DanaPelunasanController::class, 'create'])->name('customer.danapelunasan.create');
    Route::resource('danapelunasan', DanaPelunasanController::class, [
        'parameters' => ['danapelunasan' => 'dana_pelunasan']
    ]);

    
    
    // Route::get('dana-komitmen/{id}', [DanaKomitmenController::class, 'show'])->name('danakomitmen.show');
    // Route::get('danakomitmen/{danaKomitmen}', [DanaKomitmenController::class, 'show'])->name('danakomitmen.show');
    
    // Route::resource('danakomitmen', DanaKomitmenController::class);
    
});
