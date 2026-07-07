<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    public const CREATED_AT = 'timestamp';
    public const UPDATED_AT = null;

    protected $table = 'payment';

    protected $fillable = [
        'invoice_id',
        'payment_method',
        'transaction_id',
        'amount',
        'timestamp',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'timestamp' => 'datetime',
        ];
    }
}
