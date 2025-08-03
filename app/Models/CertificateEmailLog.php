<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CertificateEmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_id',
        'member_id',
        'email_address',
        'sent_at',
        'status',
        'error_message'
    ];

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    use LogsActivity;
    protected static $logOnlyDirty = true;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['certificate_id', 'member_id', 'email_address', 'status'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Certificate Email Log has been {$eventName}")
            ->useLogName('certificate_email_log')
            ->dontSubmitEmptyLogs();
    }
    
}