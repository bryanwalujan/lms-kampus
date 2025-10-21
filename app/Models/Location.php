<?php
// app/Models/Location.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'latitude', 'longitude', 
        'radius', 'description', 'type', 'is_active'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'radius' => 'decimal:2',
    ];

    public function classes()
    {
        return $this->hasMany(ClassModel::class);
    }

    public function isWithinRadius($lat, $lon)
    {
        $distance = $this->haversineDistance($lat, $lon);
        return $distance <= $this->radius;
    }

    private function haversineDistance($lat2, $lon2)
    {
        $earthRadius = 6371000; // meters
        
        $lat1 = deg2rad($this->latitude);
        $lon1 = deg2rad($this->longitude);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
             cos($lat1) * cos($lat2) *
             sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

        public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function locationMaterials()
    {
        return $this->hasMany(LocationMaterial::class);
    }
}