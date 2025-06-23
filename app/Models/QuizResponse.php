<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'member_id',
        'total_score'
    ];

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
    return $this->hasMany(QuizAnswer::class, 'response_id');
    }
}