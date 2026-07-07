<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticeboard extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $table = 'noticeboard';

    protected $fillable = [
        'title',
        'notice',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }
}
