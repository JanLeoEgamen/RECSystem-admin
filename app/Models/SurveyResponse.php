<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SurveyResponse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'survey_id',
        'member_id'
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function answers()
    {
    return $this->hasMany(SurveyAnswer::class, 'response_id');
    }

    // logs
    use LogsActivity;
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['survey_id', 'member_id'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Survey Response has been {$eventName}")
            ->useLogName('survey_response')
            ->dontSubmitEmptyLogs();
    }
    
}