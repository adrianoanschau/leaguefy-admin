<?php

use Illuminate\Support\Facades\Route;
use Leaguefy\LeaguefyAdmin\Controllers;

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

Route::get('/', function () {
    return view('leaguefy-admin::index');
});

Route::resource('games', Controllers\GamesController::class);
Route::resource('teams', Controllers\TeamsController::class);
Route::resource('tournaments', Controllers\TournamentsController::class);
Route::resource('tournaments/{tournament}/stages', Controllers\StagesController::class)->only(['index', 'store', 'destroy']);
Route::delete('tournaments/{tournament}/stages',Controllers\StagesController::class.'@index')->name('stages.index');
Route::post('tournaments/{tournament}/stages/connect', Controllers\StagesController::class.'@connect')
    ->name('stages.connect');
