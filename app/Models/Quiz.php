<?php
// app/Models/Quiz.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'class_id', 'created_by', 'location_id',
        'instructions', 'total_questions', 'time_limit', 'passing_score',
        'status', 'start_date', 'end_date', 'max_attempts', 'randomize_questions',
        'show_results_immediately', 'is_active'
    ];

    protected $casts = [
        'passing_score' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'randomize_questions' => 'boolean',
        'show_results_immediately' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where('is_active', true);
    }

    public function isAvailableForUser($user)
    {
        $now = now();
        
        return $this->status === 'active' &&
               $this->is_active &&
               (!$this->start_date || $this->start_date->lte($now)) &&
               (!$this->end_date || $this->end_date->gte($now)) &&
               $this->class->members()->where('user_id', $user->id)->exists();
    }

    public function getAverageScoreAttribute()
    {
        return $this->attempts()
                    ->where('status', 'completed')
                    ->avg('percentage') ?? 0;
    }
}