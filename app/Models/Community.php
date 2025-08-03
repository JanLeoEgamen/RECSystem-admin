<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Community extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'image',
        'user_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    //logs
    use LogsActivity;
    protected static $logOnlyDirty = true;


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['content', 'image', 'user_id', 'status'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Community has been {$eventName}")
            ->useLogName('community')
            ->dontSubmitEmptyLogs();
    }

}
