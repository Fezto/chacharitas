<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
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
