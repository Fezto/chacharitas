<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Neighborhood extends Model
{
    public function municipality(): BelongsTo{
        return $this->belongsTo(Municipality::class);
    }
}
