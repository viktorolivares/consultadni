<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DNIController;
use App\Http\Controllers\OddsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/*Consultas DNI*/
Route::get('/dni', [DNIController::class, 'dni'])->name('dni');
Route::get('/dni/{number}', [DNIController::class, 'getDni'])->name('consultadni');
Route::get('/dnimultiple', [DNIController::class, 'dniMultiple'])->name('dnimultiple');

/*Scraping Casas de Apuesta*/
Route::get('/odds', [OddsController::class, 'index'])->name('odds');
Route::get('/queryodds', [OddsController::class, 'odds'])->name('queryodds');
