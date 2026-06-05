<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $fillable = [
        'vehicle_category_id',
        'name',
        'slug',
        'subtitle',
        'seat_count',
        'price',
        'price_text',
        'thumbnail',
        'gallery',
        'colors',
        'highlights',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'colors' => 'array',
            'highlights' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id');
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(VehicleSpecification::class)->orderBy('sort_order');
    }
}
