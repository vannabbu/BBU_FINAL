<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $table = 'email_template';

    protected $fillable = [
        'task',
        'subject',
        'body',
    ];
}
