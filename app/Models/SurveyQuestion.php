<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity; 
use Spatie\Activitylog\LogOptions;

class SurveyQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'survey_id',
        'question',
        'type',
        'options',
        'order'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function answers()
    {
    return $this->hasMany(SurveyAnswer::class, 'question_id');
    }

    // logs
    use LogsActivity;
    protected static $logOnlyDirty = true;  
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['survey_id', 'question', 'type', 'options', 'order'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Survey Question has been {$eventName}")
            ->useLogName('survey_question')
            ->dontSubmitEmptyLogs();
    }
}