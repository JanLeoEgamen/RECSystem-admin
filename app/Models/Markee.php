<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Markee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'header',
        'content',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    use LogsActivity;
    protected static $logOnlyDirty = true;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['header', 'content', 'status'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Markee has been {$eventName}")
            ->useLogName('markee')
            ->dontSubmitEmptyLogs();
    }
    
}
