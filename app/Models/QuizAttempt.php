<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $dates = ['completed_at'];

    protected $fillable = ['quiz_id', 'member_id', 'started_at', 'completed_at', 'score'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function answers()
    {
    return $this->hasMany(QuizAttemptAnswer::class, 'attempt_id'); // Specify custom foreign key
    }
}