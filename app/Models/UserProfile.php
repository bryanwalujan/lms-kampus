<?php
// app/Models/UserProfile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'avatar', 'nim_nidn', 'department',
        'birth_date', 'bio', 'last_latitude', 'last_longitude',
        'last_checkin'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'last_latitude' => 'decimal:8',
        'last_longitude' => 'decimal:8',
        'last_checkin' => 'datetime',
    ];

    protected $appends = ['avatar_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return Storage::url($this->avatar);
        }
        return asset('images/default-avatar.png');
    }

    public function updateLocation($lat, $lon)
    {
        $this->update([
            'last_latitude' => $lat,
            'last_longitude' => $lon,
            'updated_at' => now()
        ]);
    }
}