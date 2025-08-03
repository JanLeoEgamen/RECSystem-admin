<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EmailLog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'recipient_email',
        'recipient_name',
        'template_id',
        'subject',
        'body',
        'status',
        'error_message',
        'sent_at',
        'user_id',
        'attachments',  
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    use LogsActivity;
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['recipient_email', 'subject', 'status'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Email Log has been {$eventName}")
            ->useLogName('email_log')
            ->dontSubmitEmptyLogs();
    }
}
