<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CctvController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\GateController;
use App\Http\Controllers\Api\LostFoundController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\TrafficController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
| RESTful API for Tel-U Control System
| All routes return JSON responses
|
*/

// ============================================================================
// PUBLIC ROUTES (No Authentication Required)
// ============================================================================
Route::prefix('v1')->group(function () {
    // Authentication
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Public Gates Status
    Route::get('/gates', [GateController::class, 'index']);
    Route::get('/gates/summary', [GateController::class, 'summary']);

    // Public Traffic Info
    Route::get('/traffic/latest', [TrafficController::class, 'latestSummary']);

    // Public CCTV List (only online)
    Route::get('/cctv', [CctvController::class, 'index']);
});

// ============================================================================
// PROTECTED ROUTES (Authentication Required)
// ============================================================================
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    
    // --------------------------------------------------------------------
    // AUTH ROUTES
    // --------------------------------------------------------------------
    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::put('/change-password', [AuthController::class, 'changePassword']);
    });

    // --------------------------------------------------------------------
    // DASHBOARD ROUTES
    // --------------------------------------------------------------------
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])
        ->middleware('role:admin');
    Route::get('/dashboard/satpam', [DashboardController::class, 'satpamDashboard'])
        ->middleware('role:admin,satpam');
    Route::get('/dashboard/civitas', [DashboardController::class, 'civitasDashboard'])
        ->middleware('role:admin,civitas');
    Route::get('/dashboard/warga', [DashboardController::class, 'wargaDashboard']);

    // --------------------------------------------------------------------
    // REPORTS (Laporan Kerusakan Fasilitas) - Full CRUD
    // --------------------------------------------------------------------
    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index']);
        Route::post('/', [ReportController::class, 'store'])
            ->middleware('role:admin,civitas');
        Route::get('/statistics', [ReportController::class, 'statistics'])
            ->middleware('role:admin');
        Route::get('/{report}', [ReportController::class, 'show']);
        Route::put('/{report}', [ReportController::class, 'update']);
        Route::patch('/{report}/status', [ReportController::class, 'updateStatus'])
            ->middleware('role:admin');
        Route::delete('/{report}', [ReportController::class, 'destroy']);
    });

    // --------------------------------------------------------------------
    // LOST & FOUND (Barang Hilang & Temuan) - Full CRUD
    // --------------------------------------------------------------------
    Route::prefix('lost-found')->group(function () {
        Route::get('/', [LostFoundController::class, 'index']);
        Route::post('/', [LostFoundController::class, 'store']);
        Route::get('/statistics', [LostFoundController::class, 'statistics'])
            ->middleware('role:admin');
        Route::get('/{lostFoundItem}', [LostFoundController::class, 'show']);
        Route::put('/{lostFoundItem}', [LostFoundController::class, 'update']);
        Route::patch('/{lostFoundItem}/status', [LostFoundController::class, 'updateStatus'])
            ->middleware('role:admin');
        Route::post('/{lostFoundItem}/confirm-return', [LostFoundController::class, 'confirmReturn']);
        Route::delete('/{lostFoundItem}', [LostFoundController::class, 'destroy']);
    });

    // --------------------------------------------------------------------
    // TRAFFIC (Laporan Kemacetan) - Full CRUD
    // --------------------------------------------------------------------
    Route::prefix('traffic')->group(function () {
        Route::get('/', [TrafficController::class, 'index']);
        Route::post('/', [TrafficController::class, 'store'])
            ->middleware('role:admin,satpam,civitas');
        Route::get('/{trafficUpdate}', [TrafficController::class, 'show']);
        Route::put('/{trafficUpdate}', [TrafficController::class, 'update'])
            ->middleware('role:admin,satpam');
        Route::delete('/{trafficUpdate}', [TrafficController::class, 'destroy'])
            ->middleware('role:admin,satpam');
    });

    // --------------------------------------------------------------------
    // GATES (Pintu Gerbang) - Full CRUD
    // --------------------------------------------------------------------
    Route::prefix('gates')->middleware('role:admin,satpam')->group(function () {
        Route::post('/', [GateController::class, 'store']);
        Route::get('/{gate}', [GateController::class, 'show']);
        Route::put('/{gate}', [GateController::class, 'update']);
        Route::patch('/{gate}/status', [GateController::class, 'updateStatus']);
        Route::delete('/{gate}', [GateController::class, 'destroy'])
            ->middleware('role:admin');
    });

    // --------------------------------------------------------------------
    // CCTV - Full CRUD (Admin Only for CUD)
    // --------------------------------------------------------------------
    Route::prefix('cctv')->group(function () {
        Route::get('/summary', [CctvController::class, 'summary']);
        Route::get('/{cctv}', [CctvController::class, 'show']);
        
        // Admin only routes
        Route::middleware('role:admin')->group(function () {
            Route::post('/', [CctvController::class, 'store']);
            Route::put('/{cctv}', [CctvController::class, 'update']);
            Route::patch('/{cctv}/status', [CctvController::class, 'updateStatus']);
            Route::delete('/{cctv}', [CctvController::class, 'destroy']);
        });
    });

    // --------------------------------------------------------------------
    // USER MANAGEMENT (Admin Only) - Full CRUD
    // --------------------------------------------------------------------
    Route::prefix('users')->middleware('role:admin')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/statistics', [UserController::class, 'statistics']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::patch('/{user}/password', [UserController::class, 'updatePassword']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });
});
