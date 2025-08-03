<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions; 

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
    // logs
    use LogsActivity;
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['response_id', 'question_id', 'answer', 'score', 'is_correct'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Quiz Answer has been {$eventName}")
            ->useLogName('quiz_answer')
            ->dontSubmitEmptyLogs();
    }
}