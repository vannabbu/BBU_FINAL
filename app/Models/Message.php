<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public const CREATED_AT = 'timestamp';
    public const UPDATED_AT = null;

    public const ROLE_MODELS = [
        Admin::ROLE => Admin::class,
        Accountant::ROLE => Accountant::class,
        Doctor::ROLE => Doctor::class,
        Nurse::ROLE => Nurse::class,
        Laboratorist::ROLE => Laboratorist::class,
        Pharmacist::ROLE => Pharmacist::class,
    ];

    protected $table = 'message';

    protected $fillable = [
        'sender_role',
        'sender_id',
        'receiver_role',
        'receiver_id',
        'message_text',
        'is_read',
        'timestamp',
    ];

    public function senderRecord(): ?Model
    {
        return $this->resolveRoleRecord($this->sender_role, $this->sender_id);
    }

    public function receiverRecord(): ?Model
    {
        return $this->resolveRoleRecord($this->receiver_role, $this->receiver_id);
    }

    protected function casts(): array
    {
        return [
            'sender_id' => 'integer',
            'receiver_id' => 'integer',
            'is_read' => 'boolean',
            'timestamp' => 'datetime',
        ];
    }

    private function resolveRoleRecord(?string $role, mixed $id): ?Model
    {
        $modelClass = self::ROLE_MODELS[$role] ?? null;

        if ($modelClass === null || $id === null) {
            return null;
        }

        return $modelClass::query()->find($id);
    }
}
