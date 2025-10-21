<?php
// app/Models/Schedule.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id', 'location_id', 'date', 'start_time', 'end_time',
        'topic', 'notes', 'status', 'session_number', 'requires_attendance'
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'requires_attendance' => 'boolean',
    ];

    protected $appends = ['is_today', 'is_past', 'full_datetime_start', 'full_datetime_end'];

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function getIsTodayAttribute()
    {
        return $this->date->isToday();
    }

    public function getIsPastAttribute()
    {
        return $this->date->isPast();
    }

    public function getFullDatetimeStartAttribute()
    {
        return Carbon::parse($this->date . ' ' . $this->start_time);
    }

    public function getFullDatetimeEndAttribute()
    {
        return Carbon::parse($this->date . ' ' . $this->end_time);
    }

    public function isOngoing()
    {
        $now = Carbon::now();
        return $this->full_datetime_start->lte($now) && 
               $this->full_datetime_end->gte($now);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->format('Y-m-d'))
                     ->orderBy('date')
                     ->orderBy('start_time');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date', now()->format('Y-m-d'));
    }

    public function attendanceRate()
    {
        $totalMembers = $this->class->members()->active()->count();
        $present = $this->attendances()->where('status', 'present')->count();
        
        return $totalMembers > 0 ? ($present / $totalMembers) * 100 : 0;
    }
}