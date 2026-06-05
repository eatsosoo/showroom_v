<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleSpecification extends Model
{
    protected $fillable = [
        'vehicle_id',
        'group_name',
        'name',
        'value',
        'sort_order',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
