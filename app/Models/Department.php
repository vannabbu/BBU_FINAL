<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $table = 'department';

    protected $fillable = [
        'name',
        'description',
    ];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class, 'department_id');
    }

    public function beds(): HasMany
    {
        return $this->hasMany(Bed::class, 'department_id');
    }
}
