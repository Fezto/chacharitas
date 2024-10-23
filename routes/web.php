<?php

use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\NeighborhoodController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome.index');

Route::view('/about', 'about')->name('about.index');

Route::get('/login', [LoginController::class, 'create'])->name('login.create');
Route::post('/login', function () {
    dd("pepe pecas");
})->name('login.store');

Route::get('/contact', function() {
    return view('contact');
})->name('contact.index');

Route::get('/states', [StateController::class, 'index'])->name('states.index');
Route::get('/municipalities', [MunicipalityController::class, 'index'])->name('municipalities.index');
Route::get('/neighborhoods', [NeighborhoodController::class, 'index'])->name('neighborhoods.index');



