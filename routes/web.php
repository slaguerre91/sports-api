<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\ResultsController;

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

Route::get('/',  [QueryController::class, "loadQueryOptions"]);
Route::get('/results', [ResultsController::class, "showResults"]);

