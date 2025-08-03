<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Email extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'email_address',
        'subject',
        'body',
        'sent_at',
        'status',
        'error_message'
    ];
    
    use LogsActivity;
    protected static $logOnlyDirty = true;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['email_address', 'subject', 'status'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Email has been {$eventName}")
            ->useLogName('email')
            ->dontSubmitEmptyLogs();
    }
    
}
