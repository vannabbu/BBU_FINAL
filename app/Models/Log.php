<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    public const CREATED_AT = 'timestamp';
    public const UPDATED_AT = null;

    protected $table = 'log';

    protected $fillable = [
        'user_role',
        'user_id',
        'action',
        'ip_address',
        'timestamp',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'timestamp' => 'datetime',
        ];
    }
}
