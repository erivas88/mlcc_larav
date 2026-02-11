<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\EstacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/glosario', function () {
    return view('glosario');
});

// El {id_subsistema?} con signo de interrogación indica que puede o no estar presente
Route::get('/sector/{id}/{id_subsistema?}', [SectorController::class, 'verSectorConEstado'])->name('sector.detalle');

Route::get('/estacion/{id}', [EstacionController::class, 'verEstacion'])->name('estacion.detalle');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
