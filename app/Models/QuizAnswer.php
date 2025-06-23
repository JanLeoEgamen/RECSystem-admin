<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_id',
        'question_id',
        'answer',
        'score',
        'is_correct'
    ];

    public function response()
    {
    return $this->belongsTo(QuizResponse::class, 'response_id');
    }

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class);
    }
}