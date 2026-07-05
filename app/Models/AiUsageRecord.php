<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiUsageRecord extends Model
{
    protected $fillable = [
        'provider',
        'model',
        'tokens_used',
        'estimated_cost',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tokens_used' => 'integer',
            'estimated_cost' => 'decimal:6',
        ];
    }
}
