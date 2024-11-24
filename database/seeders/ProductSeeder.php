<?php

namespace Database\Seeders;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Gender;
use App\Models\Material;
use App\Models\Size;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws FileNotFoundException
     */
    public function run()
    {
        // Leer el archivo JSON
        $data = json_decode(File::get(resource_path('json/products.json')), true);

        foreach ($data as $productData) {
            // Validar que los campos principales no sean null
            if (empty($productData['name']) || empty($productData['brand']) || empty($productData['category'])) {
                continue; // Saltar este producto si falta información esencial
            }

            // Buscar o crear la marca
            $brand = Brand::firstOrCreate(['name' => $productData['brand']]);

            // Crear el producto
            $product = Product::create([
                'name' => $productData['name'],
                'price' => $productData['price'] ?? 0,
                'quantity' => $productData['quantity'] ?? 0,
                'brand_id' => $brand->id,
                'user_id' => $productData['user_id'] ?? 1,
            ]);

            // Relacionar categoría
            $category = Category::firstOrCreate(['name' => $productData['category']]);
            $product->categories()->sync([$category->id]);

            // Relacionar colores
            if (!empty($productData['colors'])) {
                $colors = is_array($productData['colors']) ? $productData['colors'] : [$productData['colors']];
                $colorIds = [];
                foreach ($colors as $color) {
                    if (!empty($color)) {
                        $colorIds[] = Color::firstOrCreate(['name' => $color])->id;
                    }
                }
                $product->colors()->sync($colorIds);
            }

            // Relacionar géneros
            if (!empty($productData['gender'])) {
                $genders = is_array($productData['gender']) ? $productData['gender'] : [$productData['gender']];
                $genderIds = [];
                foreach ($genders as $gender) {
                    if (!empty($gender)) {
                        $genderIds[] = Gender::firstOrCreate(['name' => $gender])->id;
                    }
                }
                $product->genders()->sync($genderIds);
            }

            // Relacionar materiales
            if (!empty($productData['material'])) {
                $materials = is_array($productData['material']) ? $productData['material'] : [$productData['material']];
                $materialIds = [];
                foreach ($materials as $material) {
                    if (!empty($material)) {
                        $materialIds[] = Material::firstOrCreate(['name' => $material])->id;
                    }
                }
                $product->materials()->sync($materialIds);
            }

            // Relacionar tallas (validar que no sea null)
            if (!empty($productData['size'])) {
                $sizes = is_array($productData['size']) ? $productData['size'] : [$productData['size']];
                $sizeIds = [];
                foreach ($sizes as $size) {
                    if (!empty($size)) {
                        $sizeIds[] = Size::firstOrCreate(['name' => $size])->id;
                    }
                }
                $product->sizes()->sync($sizeIds);
            }
        }
    }
}
