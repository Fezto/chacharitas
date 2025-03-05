<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property int|null $quantity
 * @property int $user_id
 * @property int $brand_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attribute> $attributes
 * @property-read int|null $attributes_count
 * @property-read \App\Models\Brand $brand
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Color> $colors
 * @property-read int|null $colors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gender> $genders
 * @property-read int|null $genders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Material> $materials
 * @property-read int|null $materials_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Size> $sizes
 * @property-read int|null $sizes_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUserId($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($product) {
            if (request()->hasFile('image')) {
                $image = request()->file('image');
                $filename = "FotoProducto{$product->id}.jpeg";

                // Guarda la imagen con el nombre personalizado
                $path = $image->storeAs('productos', $filename, 'public');
                $product->image = $path;
            }
        });
    }

    public function getApproximateLocationAttribute()
    {
        return $this->user->address->neighborhood->municipality;
    }

    public function attributes() : BelongsToMany
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function brand() : BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function colors() : BelongsToMany
    {
        return $this->belongsToMany(Color::class);
    }

    public function genders() : BelongsToMany
    {
        return $this->belongsToMany(Gender::class);
    }

    public function materials() : BelongsToMany
    {
        return $this->belongsToMany(Material::class);
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
