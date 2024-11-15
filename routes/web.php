<?php

use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\NeighborhoodController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('welcome.index');

Route::view('/about', 'about')->name('about.index');
Route::get('/shop', function() {
   return view('shop');
})->name('shop.index');



Route::get('/contact', function () {
    return view('contact');
})->name('contact.index');

Route::get('/states', [StateController::class, 'index'])->name('states.index');
Route::get('/states/{state}/municipalities', [MunicipalityController::class, 'get_municipalities_by_state'])->name('states.municipalities.index');

Route::get('/municipalities', [MunicipalityController::class, 'index'])->name('municipalities.index');
Route::get('/municipalities/{municipality}/neighborhoods', [NeighborhoodController::class, 'get_neighborhoods_by_municipality'])->name('municipalities.neighborhoods.index');

Route::get('/neighborhoods', [NeighborhoodController::class, 'index'])->name('neighborhoods.index');




