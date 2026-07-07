<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public const CREATED_AT = null;

    protected $table = 'settings';

    protected $fillable = [
        'system_name',
        'system_email',
        'address',
        'phone',
        'currency',
    ];
}
