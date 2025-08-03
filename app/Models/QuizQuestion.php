<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class QuizQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quiz_id',
        'question',
        'type',
        'options',
        'correct_answers',
        'order',
        'points'
    ];

    protected $casts = [
        'options' => 'array',
        'correct_answers' => 'array'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
    return $this->hasMany(QuizAnswer::class, 'question_id');
    }

    // logs
    use LogsActivity;
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['quiz_id', 'question', 'type', 'options', 'correct_answers', 'order', 'points'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Quiz Question has been {$eventName}")
            ->useLogName('quiz_question')
            ->dontSubmitEmptyLogs();
    }
}