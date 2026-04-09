<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_number',
        'type',
        'data',
        'start_date',
        'end_date',
        'generated_by'
    ];

    /**
     * I-convert ang JSON data sa array automatically.
     */
    protected $casts = [
        'data' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Kunin ang Admin na nag-generate ng report.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}