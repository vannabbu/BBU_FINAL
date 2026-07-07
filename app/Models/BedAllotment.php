<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BedAllotment extends Model
{
    use HasFactory;

    protected $table = 'bed_allotment';

    protected $fillable = [
        'bed_id',
        'patient_id',
        'allotment_time',
        'discharge_time',
    ];

    public function bed(): BelongsTo
    {
        return $this->belongsTo(Bed::class, 'bed_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    protected function casts(): array
    {
        return [
            'allotment_time' => 'datetime',
            'discharge_time' => 'datetime',
        ];
    }
}
