<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EmailTemplate extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'subject', 'body'];

    public function emailLogs()
    {
        return $this->hasMany(EmailLog::class, 'template_id');
    }

    //logs
    use HasFactory;
    use LogsActivity;
    protected static $logOnlyDirty = true;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'subject'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Email Template has been {$eventName}")
            ->useLogName('email_template')
            ->dontSubmitEmptyLogs();
    }

}
