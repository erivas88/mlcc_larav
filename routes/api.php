<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MarkerController;

// Ruta para el sector completo
Route::post('/get-markers', [MarkerController::class, 'getAllMarkers']);

// Ruta para el subsistema específico
Route::post('/get-sector-markers', [MarkerController::class, 'getMarkersBySubsistema']);