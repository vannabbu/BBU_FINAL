<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $table = 'invoice';

    protected $fillable = [
        'patient_id',
        'total_amount',
        'discount',
        'vat',
        'grand_total',
        'status',
        'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'invoice_id');
    }

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'discount' => 'decimal:2',
            'vat' => 'decimal:2',
            'grand_total' => 'decimal:2',
            'date' => 'date',
        ];
    }
}
