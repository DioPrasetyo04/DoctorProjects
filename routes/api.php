<?php

use App\Http\Controllers\BookingTransactionController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\HospitalSpecialistController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\SpecialistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('specialists', SpecialistController::class);

Route::controller(DoctorController::class)->group(function () {
    Route::apiResource('doctors', DoctorController::class);
    Route::get('doctors-filter', 'filterBySpecialistAndHospital');
    Route::get('doctors/{doctorId}/available-slots', 'availableSlots');
});

Route::apiResource('hospitals', HospitalController::class);

Route::controller(HospitalSpecialistController::class)->group(function () {
    Route::post('hospitals/{hospital}/specialists', 'attach');
    Route::delete('hospitals/{hospital}/specialists/{specialist}', 'detach');
});

Route::controller(BookingTransactionController::class)->group(function () {
    Route::apiResource('transactions', BookingTransactionController::class);
    Route::patch('transactions/{id}/status', 'updateStatus');
});

Route::controller(MyOrderController::class)->group(function () {
    Route::get('my-orders', 'index');
    Route::post('my-orders', 'store')->middleware('auth:sanctum');
    Route::get('my-orders/{id}', 'show');
});
