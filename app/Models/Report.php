<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $table = 'report';

    protected $fillable = [
        'type',
        'generated_by',
        'description',
    ];
}
