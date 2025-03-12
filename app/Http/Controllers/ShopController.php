<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gender;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filtrar por una única categoría si está presente en la URL
        $selectedCategory = $request->query('category');
        if (!empty($selectedCategory)) {
            $query->whereHas('categories', function ($q) use ($selectedCategory) {
                $q->where('categories.id', $selectedCategory);
            });
        }

        // Recuperar productos
        $products = $query->get();

        return view('shop', [
            'categories'       => Category::all(),
            'products'         => $products,
            'genders'          => Gender::all(),
            'selectedCategory' => $selectedCategory
        ]);
    }

    public function show(Request $request)
    {
        // Se carga el producto con sus relaciones para tener acceso a la dirección y demás datos.
        $product = Product::with([
            'user.address.neighborhood.municipality.state',
            'categories',
            'genders'
        ])->findOrFail($request->id);

        // Obtenemos el código postal desde la dirección del usuario
        $postalCode = $product->user->address->neighborhood->postal_code ?? null;

        // Si existe código postal, intentamos obtener coordenadas a través de la API;
        // de lo contrario, usamos coordenadas predeterminadas.

        $coordinates = $postalCode
            ? $this->getCoordinatesByPostalCode($postalCode)
            : $this->getDefaultCoordinates();

        return view('product', [
            'product'     => $product,
            'map_center'  => $coordinates,
            'postal_code' => $postalCode
        ]);
    }

    private function getCoordinatesByPostalCode($postalCode)
    {
        return Cache::remember("postal_{$postalCode}", now()->addMonth(), function() use ($postalCode) {
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address'    => "{$postalCode}, Mexico",
                'components' => "country:MX|postal_code:{$postalCode}",
                'key'        => config('services.google.maps_key')
            ]);

            $data = $response->json();

            return $data['status'] === 'OK'
                ? $data['results'][0]['geometry']['location']
                : $this->getDefaultCoordinates();
        });
    }

    private function getDefaultCoordinates()
    {
        // Coordenadas de Querétaro (puedes cambiarlas según tus necesidades)
        return ['lat' => 20.588793, 'lng' => -100.389887];
    }

    public function filter(Request $request)
    {
        $query = Product::query();

        // Filtro por categoría
        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('categories.id', $request->categories);
            });
        }

        // Filtro por género
        if ($request->has('genders') && !empty($request->genders)) {
            $query->whereHas('genders', function ($q) use ($request) {
                $q->whereIn('genders.id', $request->genders);
            });
        }

        // Filtro por precio
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        if ($request->has('order_by') && !empty($request->order_by)) {
            $order_by_id = $request->order_by;

            switch ($order_by_id) {
                case 1:
                    $query->orderBy('name');
                    break;
                case 2:
                    $query->orderBy('price');
                    break;
                case 3:
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->orderBy('id');
            }
        }

        $products = $query->get();

        return response()->json([
            'products' => $products
        ]);
    }

    // Si en algún otro contexto necesitas una función genérica de geocodificación, puedes usar esta:
    private function getCoordinates($location)
    {
        $cacheKey = 'geo_' . md5($location);

        return Cache::remember($cacheKey, now()->addDay(), function() use ($location) {
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $location,
                'key'     => config('services.google.maps_key'),
                'region'  => 'mx'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'OK') {
                    return $data['results'][0]['geometry']['location'];
                }
            }

            return $this->getDefaultCoordinates();
        });
    }
}
