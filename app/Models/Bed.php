<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bed extends Model
{
    use HasFactory;

    protected $table = 'bed';

    protected $fillable = [
        'department_id',
        'bed_number',
        'type',
        'status',
        'description',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function allotments(): HasMany
    {
        return $this->hasMany(BedAllotment::class, 'bed_id');
    }

    public function activeAllotment(): HasOne
    {
        return $this->hasOne(BedAllotment::class, 'bed_id')->whereNull('discharge_time');
    }
}
