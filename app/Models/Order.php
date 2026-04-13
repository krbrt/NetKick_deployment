<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'user_id', 'first_name', 'last_name', 'phone', 'address', 'shipping_address',
        'subtotal', 'discount_amount', 'total_amount', 'voucher_code',
        'total_price', 'status', 'payment_method', 'notes'
    ];

    // Computed attribute for backward compatibility
    public function getTotalAmountAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    // Isang order ay may maraming items
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Isang order ay pag-aari ng isang user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Extract GCash ref or payment notes for display
     */
    public function getReferenceNumberAttribute(): ?string
    {
        if (str_contains($this->notes ?? '', 'GCash Ref:')) {
            preg_match('/GCash Ref:\s*([A-Za-z0-9]+)/', $this->notes, $matches);
            return $matches[1] ?? null;
        }
        return null;
    }
}

