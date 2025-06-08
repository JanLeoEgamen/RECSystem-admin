<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'question', 'type', 'points', 'order'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
    return $this->hasMany(QuizAnswer::class, 'question_id');
    }

    public function correctAnswers()
    {
    return $this->hasMany(QuizAnswer::class, 'question_id')->where('is_correct', true);
    }
}