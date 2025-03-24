<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'url', 'description', 'order'];

    /**
     * Relación con el modelo Product (Uno a Muchos inversa).
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
