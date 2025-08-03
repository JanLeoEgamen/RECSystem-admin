<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Renewal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'reference_number',
        'receipt_path',
        'status',
        'remarks',
        'processed_by',
        'processed_at'
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // logs
    use LogsActivity;
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['member_id', 'reference_number', 'status', 'remarks'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Renewal has been {$eventName}")
            ->useLogName('renewal')
            ->dontSubmitEmptyLogs();
    }
    
}