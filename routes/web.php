<?php

use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\NeighborhoodController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome')->name('welcome.index');

Route::view('/about', 'about')->name('about.index');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{id}', [ShopController::class, 'show'])->name('shop.show');

Route::post('/products/filter', [ShopController::class, 'filter'])->name('shop.filter');


Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed'])
    ->name('verification.verify');

// Ruta para mostrar la vista de verificación de email
Route::view('/email/verify', 'email-verify')
    ->middleware('auth')
    ->name('verification.notice');

// Ruta para reenviar el link de verificación
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/contact', function () {
    return view('contact');
})->name('contact.index');

Route::get('/add-product', function () {
    return view('add-product');
})/* ->middleware(['auth', 'verified']) */->name('add-product.index');


Route::get('/shipping/{product}', [ShippingController::class, 'index'])
    ->name('shipping.index');

// Envía el POST de cotización
Route::post('/shipping/{product}/quote', [ShippingController::class, 'quote'])
    ->name('shipping.quote');

// Rutas de perfil dummy


Route::get('/profile/edit', function () {
    return view('profile'); // Crea esta vista según necesites
})->name('profile.index');

Route::get('/profile/password', function () {
    return view('profile.password'); // Crea esta vista para cambiar contraseña
})->name('profile.password');

Route::get('/profile/settings', function () {
    return view('profile.settings'); // Crea esta vista para configuración
})->name('profile.settings');

Route::put('/profile/update', function (\Illuminate\Http\Request $request) {
    // Aquí procesarías la actualización del perfil.
    // Por ahora solo redirigimos de vuelta a la edición con un mensaje dummy.
    return redirect()->route('profile.index')->with('status', 'Perfil actualizado');
})->name('profile.update');


// * Envios * //

Route::get('/test-fedex', [ShippingController::class, 'test']);
Route::get('/shipping/{product}', [ShippingController::class, 'index'])->name('shipping.index');
Route::post('/shipping/{product}/quote', [ShippingController::class, 'quote'])->name('shipping.quote');
Route::post('/shipping/{product}/purchase', [ShippingController::class, 'purchase'])->name('shipping.purchase');


// * API * //

Route::get('/states', [StateController::class, 'index'])->name('states.index');
Route::get('/states/{state}/municipalities', [MunicipalityController::class, 'get_municipalities_by_state'])->name('states.municipalities.index');

Route::get('/municipalities', [MunicipalityController::class, 'index'])->name('municipalities.index');
Route::get('/municipalities/{municipality}/neighborhoods', [NeighborhoodController::class, 'get_neighborhoods_by_municipality'])->name('municipalities.neighborhoods.index');

Route::get('/neighborhoods', [NeighborhoodController::class, 'index'])->name('neighborhoods.index');




