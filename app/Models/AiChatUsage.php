<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiChatUsage extends Model
{
    protected $table = 'ai_chat_usage';

    protected $fillable = [
        'usage_date',
        'identifier',
        'message_count',
    ];

    protected function casts(): array
    {
        return [
            'usage_date' => 'date',
            'message_count' => 'integer',
        ];
    }
}
