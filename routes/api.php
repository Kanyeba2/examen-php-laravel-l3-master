<?php
//importations des controllers pour l'authentification, les animaux et les demandes d'adoption
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\AnimalApiController;
use App\Http\Controllers\Api\DemandeAdoptionApiController;
use Illuminate\Support\Facades\Route;
// cette partie fait la route pour l'authentification de l'utilisateur (login, logout, me) et les routes pour les animaux et les demandes d'adoption
Route::post('/auth/login', [AuthApiController::class, 'login']);
//cette partie fait la route 
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
