<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiDataController;
use App\Http\Controllers\GameController;
use App\Models\Servant;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/import-servants', [ApiDataController::class, 'importServants']);



Route::get('/juego', [GameController::class, 'showGame'])->name('juego');

//
Route::get('/personajeSecreto', [GameController::class, 'personajeSecreto']);

Route::post('/comprobar', [GameController::class, 'comprobar'])->name('comprobar');

Route::get('/autocompletar', [GameController::class, 'search'])->name('autocompletar');

Route::get('/asignarpersonajeSecreto', [GameController::class, 'asignarPersonajeSecreto']);

Route::get('/personaje-secreto', [GameController::class, 'mostrarPersonajeSecreto']);

Route::get('/home', [GameController::class, 'showHome'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



require __DIR__.'/auth.php';
