<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Gender;
use App\Models\Material;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('gender_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Gender::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('color_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Color::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('material_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Material::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_size', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Size::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('size_product');
        Schema::dropIfExists('material_product');
        Schema::dropIfExists('color_product');
        Schema::dropIfExists('gender_product');
    }
};
