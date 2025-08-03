<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SurveyAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_id',
        'question_id',
        'answer'
    ];

    public function response()
    {
        return $this->belongsTo(SurveyResponse::class);
    }

    public function question()
    {
    return $this->belongsTo(SurveyQuestion::class, 'question_id');
    }

    // logs
    use LogsActivity;
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['response_id', 'question_id', 'answer'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Survey Answer has been {$eventName}")
            ->useLogName('survey_answer')
            ->dontSubmitEmptyLogs();
    }
    
}