<?php
// app/Models/ClassMember.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id', 'user_id', 'status', 'joined_at'
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}