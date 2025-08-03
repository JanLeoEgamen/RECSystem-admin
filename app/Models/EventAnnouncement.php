<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EventAnnouncement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'event_name',
        'event_date',
        'year',
        'caption',
        'image',
        'user_id',
        'status'
    ];

    protected $dates = ['event_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Accessor for formatted event date
    public function getFormattedEventDateAttribute()
    {
        return $this->event_date->format('F j, Y');
    }

    //logs
    use LogsActivity;
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['event_name', 'event_date', 'year', 'caption', 'image', 'user_id', 'status'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Event Announcement has been {$eventName}")
            ->useLogName('event_announcement')
            ->dontSubmitEmptyLogs();
    }

}
