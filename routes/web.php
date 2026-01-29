<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/sector/{id}', [SectorController::class, 'verSector'])->name('sector.ver');
// Cambiamos 'verSector' por 'verSectorConEstado'
Route::get('/sector/{id}', [SectorController::class, 'verSectorConEstado'])->name('sector.ver');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
