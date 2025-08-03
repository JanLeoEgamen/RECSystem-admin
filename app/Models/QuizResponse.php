<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class QuizResponse extends Model
{
    use HasFactory, SoftDeletes;

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

    // logs
    use LogsActivity;
    protected static $logOnlyDirty = true;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['quiz_id', 'member_id', 'total_score'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Quiz Response has been {$eventName}")
            ->useLogName('quiz_response')
            ->dontSubmitEmptyLogs();
    }
}