<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloodDonor extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $table = 'blood_donor';

    protected $fillable = [
        'name',
        'blood_group',
        'sex',
        'age',
        'last_donation_date',
        'phone',
    ];

    public function bloodBank(): BelongsTo
    {
        return $this->belongsTo(BloodBank::class, 'blood_group', 'blood_group');
    }

    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'last_donation_date' => 'date',
        ];
    }
}
