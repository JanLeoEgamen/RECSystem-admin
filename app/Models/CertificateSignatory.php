<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CertificateSignatory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['certificate_id', 'name', 'position', 'order'];

    //logs
    use LogsActivity;
    protected static $logOnlyDirty = true;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['certificate_id', 'name', 'position', 'order'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Certificate Signatory has been {$eventName}")
            ->useLogName('certificate_signatory')
            ->dontSubmitEmptyLogs();
    }
    
}

