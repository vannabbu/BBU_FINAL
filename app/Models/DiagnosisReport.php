<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiagnosisReport extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'diagnosis_report';

    protected $fillable = [
        'patient_id',
        'laboratorist_id',
        'report_type',
        'document_url',
        'description',
        'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function laboratorist(): BelongsTo
    {
        return $this->belongsTo(Laboratorist::class, 'laboratorist_id');
    }

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }
}
