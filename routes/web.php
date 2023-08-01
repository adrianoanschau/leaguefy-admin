<?php

use Illuminate\Support\Facades\Route;
use Leaguefy\LeaguefyAdmin\Controllers;
use Inertia\Inertia;

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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('index');

Route::resource('games', Controllers\GamesController::class);
Route::resource('teams', Controllers\TeamsController::class);
Route::resource('tournaments', Controllers\TournamentsController::class);
Route::resource('tournaments/{tournament}/stages', Controllers\StagesController::class)->only(['index', 'store', 'update', 'destroy']);
Route::post('tournaments/{tournament}/stages/connect', Controllers\StagesController::class.'@connect')
    ->name('stages.connect');

Route::post('settings/route-prefix/change', Controllers\SettingsController::class.'@routePrefixChange')->name('settings.route-prefix.change');
Route::post('settings/route-prefix/remove', Controllers\SettingsController::class.'@routePrefixRemove')->name('settings.route-prefix.remove');

Route::post('settings/brand/change', Controllers\SettingsController::class.'@brandChange')->name('settings.brand.change');
Route::post('settings/styles/change', Controllers\SettingsController::class.'@stylesChange')->name('settings.styles.change');
