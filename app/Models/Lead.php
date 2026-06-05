<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = [
        'vehicle_id',
        'type',
        'status',
        'name',
        'phone',
        'email',
        'city',
        'appointment_at',
        'message',
        'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'appointment_at' => 'datetime',
        ];
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
