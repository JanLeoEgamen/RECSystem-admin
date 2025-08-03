<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'member_id',
        'status',
        'notes'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // logs
    use LogsActivity;
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['event_id', 'member_id', 'status', 'notes'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Event Registration has been {$eventName}")
            ->useLogName('event_registration')
            ->dontSubmitEmptyLogs();
    }
    
}