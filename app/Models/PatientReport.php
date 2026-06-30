<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientReport extends Model
{
    protected $fillable = [
        'patient_name',
        'email',
        'phone',
        'title',
        'file_path',
        'file_type',
        'notes',
        'uploaded_by',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function scopeForEmail(Builder $query, string $email): Builder
    {
        return $query->where('email', $email);
    }

    public function isImage(): bool
    {
        return in_array($this->file_type, ['jpg', 'jpeg', 'png']);
    }

    public function isPdf(): bool
    {
        return $this->file_type === 'pdf';
    }
}
