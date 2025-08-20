<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'seller_id',
        'buyer_id',
        'tracking_number',
        'fedex_shipment_id',
        'service_type',
        'status',
        'shipping_cost',
        'currency',
        'label_url',
        'label_pdf_path',
        'sender_address',
        'recipient_address',
        'weight',
        'dimensions',
        'shipped_at',
        'estimated_delivery',
        'delivered_at',
        'fedex_response',
        'notes',
    ];

    protected $casts = [
        'sender_address' => 'array',
        'recipient_address' => 'array',
        'dimensions' => 'array',
        'fedex_response' => 'array',
        'shipped_at' => 'datetime',
        'estimated_delivery' => 'datetime',
        'delivered_at' => 'datetime',
        'shipping_cost' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'created']);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'created' => 'info',
            'in_transit' => 'primary',
            'delivered' => 'success',
            'exception' => 'danger',
            'cancelled' => 'secondary',
            default => 'secondary'
        };
    }

    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pendiente',
            'created' => 'Creado',
            'in_transit' => 'En tránsito',
            'delivered' => 'Entregado',
            'exception' => 'Problema',
            'cancelled' => 'Cancelado',
            default => 'Desconocido'
        };
    }
}