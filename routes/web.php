<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiDataController;
use App\Http\Controllers\GameController;
use App\Models\Servant;
use Illuminate\Http\Request;




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
    return view('welcome');
});

Route::get('/import-servants', [ApiDataController::class, 'importServants']);



Route::get('/juego', [GameController::class, 'showGame'])->name('juego');

//
Route::get('/personajeSecreto', [GameController::class, 'personajeSecreto']);

Route::post('/comprobar', [GameController::class, 'comprobar'])->name('comprobar');

Route::get('/autocompletar', [GameController::class, 'search'])->name('autocompletar');

Route::get('/asignarpersonajeSecreto', [GameController::class, 'asignarPersonajeSecreto']);

Route::get('/personaje-secreto', [GameController::class, 'mostrarPersonajeSecreto']);






