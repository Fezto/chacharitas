<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    public function municipalities() : HasMany
    {
        return $this->hasMany(Municipality::class);
    }
}
