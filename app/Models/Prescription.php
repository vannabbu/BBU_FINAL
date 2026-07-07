<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prescription extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $table = 'prescription';

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'case_history',
        'medication',
        'description',
        'date',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }
}
