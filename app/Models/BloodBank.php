<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BloodBank extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'blood_bank';

    protected $fillable = [
        'blood_group',
        'status',
    ];

    public function donors(): HasMany
    {
        return $this->hasMany(BloodDonor::class, 'blood_group', 'blood_group');
    }

    protected function casts(): array
    {
        return [
            'status' => 'integer',
        ];
    }
}
