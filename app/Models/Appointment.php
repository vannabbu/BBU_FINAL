<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointment';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'status',
        'remarks',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function scopeForDoctorAt(Builder $query, int $doctorId, mixed $appointmentDate): Builder
    {
        return $query->where('doctor_id', $doctorId)->where('appointment_date', $appointmentDate);
    }

    protected function casts(): array
    {
        return [
            'appointment_date' => 'datetime',
        ];
    }
}
