<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gender;
use App\Models\Product;
use Illuminate\Http\Request;

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
            'categories' => Category::all(),
            'products' => $products,
            'genders' => Gender::all(),
            'selectedCategory' => $selectedCategory
        ]);
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
            // Filtramos por los géneros seleccionados
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

        // Obtener productos filtrados
        $products = $query->get();

        return response()->json([
            'products' => $products
        ]);
    }


}
