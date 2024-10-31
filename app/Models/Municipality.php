<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipality extends Model
{
    public function neighborhoods() : HasMany{
        return $this->hasMany(Neighborhood::class);
    }

    public function state() : BelongsTo{
        return $this->belongsTo(State::class);
    }

}
