<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'is_published',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class)
            ->withPivot(['is_read', 'read_at'])
            ->withTimestamps();
    }



    // logs
    use LogsActivity;
    protected static $logOnlyDirty = true;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'content', 'is_published'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Announcement has been {$eventName}")
            ->useLogName('announcement')
            ->dontSubmitEmptyLogs();
    }




}