<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttemptAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['attempt_id', 'question_id', 'answer', 'points_earned'];

    public function attempt()
    {
    return $this->belongsTo(QuizAttempt::class, 'attempt_id'); // Specify custom foreign key
    }

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class);
    }
}