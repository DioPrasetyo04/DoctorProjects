<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingTransactionController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\HospitalSpecialistController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\SpecialistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('token-login', 'tokenLogin');
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('user', [AuthController::class, 'user']);

    Route::middleware('role:manager')->group(function () {
        Route::apiResource('specialists', SpecialistController::class);
        Route::apiResource('doctors', DoctorController::class);
        Route::apiResource('hospitals', HospitalController::class);

        Route::controller(HospitalSpecialistController::class)->group(function () {
            Route::post('hospitals/{hospital}/specialists', 'attach');
            Route::delete('hospitals/{hospital}/specialists/{specialist}', 'detach');
        });

        Route::controller(BookingTransactionController::class)->group(function () {
            Route::apiResource('transactions', BookingTransactionController::class);
            Route::patch('transactions/{id}/status', 'updateStatus');
        });
    });

    Route::middleware('role:customer')->group(function () {
        Route::controller(DoctorController::class)->group(function () {
            Route::get('doctors-filter', 'filterBySpecialistAndHospital');
            Route::get('doctors/{doctorId}/available-slots', 'availableSlots');
        });

        Route::controller(MyOrderController::class)->group(function () {
            Route::get('my-orders', 'index');
            Route::post('my-orders', 'store');
            Route::get('my-orders/{id}', 'show');
        });
    });

    Route::middleware('role:customer|manager')->group(function () {
        Route::apiResource('specialists', SpecialistController::class)->only(['index', 'show']);
        Route::apiResource('hospitals', HospitalController::class)->only(['index', 'show']);
        Route::apiResource('doctors', DoctorController::class)->only(['index', 'show']);
    });
});
