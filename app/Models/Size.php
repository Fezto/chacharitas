<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Size extends Model
{
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
