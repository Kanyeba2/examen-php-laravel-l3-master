<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\AnimalApiController;
use App\Http\Controllers\Api\DemandeAdoptionApiController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthApiController::class, 'me']);
    Route::post('/auth/logout', [AuthApiController::class, 'logout']);

    Route::apiResource('animaux', AnimalApiController::class);
    Route::apiResource('demandes-adoption', DemandeAdoptionApiController::class)->only(['index', 'store', 'show', 'destroy']);
});

Route::get('/ping', function () {
    return response()->json([
        'code' => 200,
        'message' => 'API disponible',
        'data' => null,
    ]);
});
