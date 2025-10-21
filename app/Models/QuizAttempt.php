<?php
// app/Models/QuizAttempt.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id', 'user_id', 'class_member_id', 'attempt_number',
        'score', 'percentage', 'time_spent', 'started_at',
        'completed_at', 'status', 'answers'
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'percentage' => 'decimal:2',
        'time_spent' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'answers' => 'array',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classMember()
    {
        return $this->belongsTo(ClassMember::class);
    }

    public function isPassed()
    {
        return $this->percentage >= $this->quiz->passing_score;
    }

    public function calculateScore()
    {
        $score = 0;
        $totalScore = 0;

        foreach ($this->quiz->questions as $question) {
            $userAnswer = $this->answers[$question->id] ?? null;
            
            if ($question->isCorrectAnswer($userAnswer)) {
                $score += $question->score;
            }
            $totalScore += $question->score;
        }

        $this->score = $score;
        $this->percentage = $totalScore > 0 ? ($score / $totalScore) * 100 : 0;
        $this->status = 'completed';
        $this->completed_at = now();
        $this->save();

        return $this;
    }
}