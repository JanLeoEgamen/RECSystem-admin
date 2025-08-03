<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'capacity',
        'is_published',
        'user_id'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'event_registrations')
            ->withPivot(['status', 'notes'])
            ->withTimestamps();
    }

    //logs
    use LogsActivity;
    protected static $logOnlyDirty = true;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'description', 'start_date', 'end_date', 'location', 'capacity', 'is_published'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Event has been {$eventName}")
            ->useLogName('event')
            ->dontSubmitEmptyLogs();
    }
    
}