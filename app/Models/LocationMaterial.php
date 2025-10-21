<?php
// app/Models/LocationMaterial.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id', 'material_id', 'radius_trigger',
        'priority', 'auto_play'
    ];

    protected $casts = [
        'radius_trigger' => 'decimal:2',
        'priority' => 'integer',
        'auto_play' => 'boolean',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function shouldTrigger($userLat, $userLon)
    {
        return $this->location->isWithinRadius($userLat, $userLon, $this->radius_trigger);
    }
}