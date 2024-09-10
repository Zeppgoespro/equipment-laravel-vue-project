<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('equipment', EquipmentController::class);
Route::post('equipment/bulk', [EquipmentController::class, 'storeBulk']);
Route::apiResource('equipment-type', EquipmentTypeController::class);
