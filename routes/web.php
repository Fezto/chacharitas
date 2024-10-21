<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/about', 'about');

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', function () {
    dd("pepe pecas");
});
