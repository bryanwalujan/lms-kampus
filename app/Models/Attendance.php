<?php
// app/Models/Attendance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id', 'class_member_id', 'user_id', 'status',
        'checkin_latitude', 'checkin_longitude', 'checkin_distance',
        'checkin_time', 'checkout_latitude', 'checkout_longitude',
        'checkout_distance', 'checkout_time', 'duration_minutes',
        'auto_checkin', 'notes'
    ];

    protected $casts = [
        'checkin_latitude' => 'decimal:8',
        'checkin_longitude' => 'decimal:8',
        'checkin_distance' => 'decimal:2',
        'checkout_latitude' => 'decimal:8',
        'checkout_longitude' => 'decimal:8',
        'checkout_distance' => 'decimal:2',
        'checkin_time' => 'datetime',
        'checkout_time' => 'datetime',
        'duration_minutes' => 'integer',
        'auto_checkin' => 'boolean',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function classMember()
    {
        return $this->belongsTo(ClassMember::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isCheckedIn()
    {
        return !is_null($this->checkin_time);
    }

    public function isCheckedOut()
    {
        return !is_null($this->checkout_time);
    }

    public function calculateDuration()
    {
        if ($this->checkin_time && $this->checkout_time) {
            $duration = $this->checkout_time->diffInMinutes($this->checkin_time);
            $this->update(['duration_minutes' => $duration]);
            return $duration;
        }
        return null;
    }

    public function scopeForSchedule($query, $scheduleId)
    {
        return $query->where('schedule_id', $scheduleId);
    }

    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'present' => 'success',
            'late' => 'warning',
            'excused' => 'info',
            'absent' => 'danger',
            default => 'secondary'
        };
    }
}