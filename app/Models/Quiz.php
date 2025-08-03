<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'is_published',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    public function responses()
    {
        return $this->hasMany(QuizResponse::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'quiz_member')
            ->withTimestamps();
    }

    // logs
    use LogsActivity;
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'description', 'is_published'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Quiz has been {$eventName}")
            ->useLogName('quiz')
            ->dontSubmitEmptyLogs();
    }

}