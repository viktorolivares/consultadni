<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DniController;
use App\Http\Controllers\OddsController;
use App\Http\Controllers\MethodPayController;

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
Route::get('/dni', [DniController::class, 'dni'])->name('dni');
Route::get('/age', [DniController::class, 'age'])->name('age');
Route::get('/services', [DniController::class, 'services'])->name('services');
Route::get('/dni/{number}', [DniController::class, 'getDni'])->name('consultadni');
Route::get('/dnimultiple', [DniController::class, 'dniMultiple'])->name('dnimultiple');


/*Passarella*/
Route::get('/mp_niubiz', [MethodPayController::class, 'niubiz'])->name('niubiz');


/*Web Scraping*/
Route::get('/odds', [OddsController::class, 'index'])->name('odds');
Route::get('/queryodds', [OddsController::class, 'odds'])->name('queryodds');

