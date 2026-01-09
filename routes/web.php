<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LostFoundController;
use App\Http\Controllers\TrafficController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CctvController;
use App\Http\Controllers\GateController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth']) // Hapus 'verified'
    ->name('dashboard');

// --- BAGIAN LAPORAN KERUSAKAN (REPORTS) ---
Route::resource('reports', ReportController::class)
    ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::patch('reports/{report}/update-status', [ReportController::class, 'updateStatus'])
    ->name('reports.update-status')
    ->middleware(['auth', 'verified']);


// --- BAGIAN BARANG HILANG (LOST FOUND) ---
Route::resource('lost-found', LostFoundController::class)
    ->parameters(['lost-found' => 'lostFoundItem'])
    ->only(['index', 'create', 'store', 'show', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::patch('lost-found/{lostFoundItem}/update-status', [LostFoundController::class, 'updateStatus'])
    ->name('lost-found.update-status')
    ->middleware(['auth', 'verified']);

// --- BAGIAN TRAFFIC & GATES ---
Route::middleware('auth')->group(function () {
    Route::get('/traffic', [TrafficController::class, 'index'])->name('traffic.index');
    Route::post('/traffic', [TrafficController::class, 'store'])->name('traffic.store');
    Route::patch('/gates/{gate}', [TrafficController::class, 'updateGate'])->name('gates.update');
});

// --- BAGIAN CCTV (Public View) ---
Route::get('/cctv', [CctvController::class, 'index'])
    ->name('cctv.index')
    ->middleware(['auth', 'verified']);


// --- BAGIAN PROFILE USER ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// --- BAGIAN ADMIN ---
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // CCTV Management
    Route::get('/cctv', [CctvController::class, 'adminIndex'])->name('cctv.index');
    Route::get('/cctv/create', [CctvController::class, 'create'])->name('cctv.create');
    Route::post('/cctv', [CctvController::class, 'store'])->name('cctv.store');
    Route::get('/cctv/{cctv}/edit', [CctvController::class, 'edit'])->name('cctv.edit');
    Route::put('/cctv/{cctv}', [CctvController::class, 'update'])->name('cctv.update');
    Route::delete('/cctv/{cctv}', [CctvController::class, 'destroy'])->name('cctv.destroy');

    // Gate Management
    Route::get('/gates', [GateController::class, 'index'])->name('gates.index');
    Route::get('/gates/create', [GateController::class, 'create'])->name('gates.create');
    Route::post('/gates', [GateController::class, 'store'])->name('gates.store');
    Route::get('/gates/{gate}/edit', [GateController::class, 'edit'])->name('gates.edit');
    Route::put('/gates/{gate}', [GateController::class, 'update'])->name('gates.update');
    Route::delete('/gates/{gate}', [GateController::class, 'destroy'])->name('gates.destroy');
});

require __DIR__.'/auth.php';
