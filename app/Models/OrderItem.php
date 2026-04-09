<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    // Dinagdagan natin ang fillable para sa product snapshots (name at image)
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',   // Snapshot ng pangalan ng sapatos
        'product_image',  // Snapshot ng itsura ng sapatos
        'quantity',
        'price',
        'size'
    ];

    /**
     * Ang Order kung saan kabilang ang item na ito.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Ang orihinal na Product record (kung hindi pa nabubura).
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
