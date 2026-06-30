<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'branch_id',
        'full_name',
        'national_id',
        'mobile',
        'doctor_id',
        'specialty',
        'appointment_date',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'doctor_id' => 'integer',
            'branch_id' => 'integer',
        ];
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public static function statusLabels(): array
    {
        return [
            self::STATUS_PENDING => 'قيد الانتظار',
            self::STATUS_APPROVED => 'موافق عليه',
            self::STATUS_CANCELLED => 'ملغي',
        ];
    }

    public function bookingTargetLabel(): string
    {
        if ($this->doctor) {
            return $this->doctor->name.' — '.$this->doctor->specialty;
        }

        return $this->specialty ?? '—';
    }
}
