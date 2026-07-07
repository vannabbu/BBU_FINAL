<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medicine extends Model
{
    use HasFactory;

    protected $table = 'medicine';

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'total_quantity',
        'expiry_date',
        'company',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MedicineCategory::class, 'category_id');
    }

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'total_quantity' => 'integer',
            'expiry_date' => 'date',
        ];
    }
}
