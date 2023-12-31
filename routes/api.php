<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('storeAgenda', [AgendaController::class, 'storeAgenda']);
Route::post('updateAgenda/{id}', [AgendaController::class, 'updateAgenda']);
Route::post('removeAgenda/{id}', [AgendaController::class, 'removeAgenda']);
Route::get('getAgenda', [AgendaController::class, 'getAgenda']);

