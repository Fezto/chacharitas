<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Shipment;
use Illuminate\Support\Facades\Route;

Route::get('/debug-shipping', function() {
    $data = [
        'users_count' => User::count(),
        'products_count' => Product::count(),
        'shipments_count' => Shipment::count(),
        'current_user' => auth()->user() ? auth()->user()->name : 'Not logged in',
        'sample_product' => Product::first() ? [
            'id' => Product::first()->id,
            'name' => Product::first()->name,
            'create_shipping_url' => route('shipping.create', Product::first())
        ] : 'No products',
        'last_shipment' => Shipment::latest()->first() ? [
            'id' => Shipment::latest()->first()->id,
            'status' => Shipment::latest()->first()->status,
            'created_at' => Shipment::latest()->first()->created_at
        ] : 'No shipments yet'
    ];
    
    return response()->json($data, 200, [], JSON_PRETTY_PRINT);
});

Route::get('/test-shipping-form/{product}', function(Product $product) {
    return view('shipping.create', compact('product'));
})->name('test.shipping.form');
