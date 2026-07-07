<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Nurse extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE = 'nurse';

    protected $table = 'nurse';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id')->where('sender_role', self::ROLE);
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id')->where('receiver_role', self::ROLE);
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }
}
