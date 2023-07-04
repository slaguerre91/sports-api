<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\ResultsController;

/*
Web Routes
*/

// Welcome page
Route::get('/',  [QueryController::class, "loadQueryOptions"]);
// Results Page
Route::get('/results', [ResultsController::class, "showResults"]);
// Error Page
Route::get('/error', function () {
    return view('error');
});

