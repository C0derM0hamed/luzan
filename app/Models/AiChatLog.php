<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiChatLog extends Model
{
    protected $fillable = [
        'session_id',
        'ip_address',
        'user_message',
        'assistant_message',
        'model',
        'tokens_used',
        'status',
        'error_message',
    ];

    protected function casts(): array
    {
        return [
            'tokens_used' => 'integer',
        ];
    }
}
