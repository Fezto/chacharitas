<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $city
 * @property int $municipality_id
 * @property string|null $settlement
 * @property int|null $postal_code
 * @property-read \App\Models\Municipality|null $municipality
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Neighborhood newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Neighborhood newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Neighborhood query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Neighborhood whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Neighborhood whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Neighborhood whereMunicipalityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Neighborhood whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Neighborhood wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Neighborhood whereSettlement($value)
 * @mixin \Eloquent
 */
class Neighborhood extends Model
{

    public function municipality(): BelongsTo{
        return $this->belongsTo(Municipality::class);
    }
}
