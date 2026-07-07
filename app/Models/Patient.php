<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patient';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'sex',
        'age',
        'blood_group',
        'address',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function bedAllotments(): HasMany
    {
        return $this->hasMany(BedAllotment::class, 'patient_id');
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class, 'patient_id');
    }

    public function diagnosisReports(): HasMany
    {
        return $this->hasMany(DiagnosisReport::class, 'patient_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'patient_id');
    }

    protected function casts(): array
    {
        return [
            'age' => 'integer',
        ];
    }
}
