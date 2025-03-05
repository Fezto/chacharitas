<?php

use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\NeighborhoodController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('welcome.index');

Route::view('/about', 'about')->name('about.index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{id}', [ShopController::class, 'show'])->name('shop.show');

Route::post('/products/filter', [ShopController::class, 'filter'])->name('shop.filter');


Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)->name('verification.verify');

Route::get('/contact', function () {
    return view('contact');
})->name('contact.index');

// * API * //

Route::get('/states', [StateController::class, 'index'])->name('states.index');
Route::get('/states/{state}/municipalities', [MunicipalityController::class, 'get_municipalities_by_state'])->name('states.municipalities.index');

Route::get('/municipalities', [MunicipalityController::class, 'index'])->name('municipalities.index');
Route::get('/municipalities/{municipality}/neighborhoods', [NeighborhoodController::class, 'get_neighborhoods_by_municipality'])->name('municipalities.neighborhoods.index');

Route::get('/neighborhoods', [NeighborhoodController::class, 'index'])->name('neighborhoods.index');




