<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FAQ extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'faqs'; // Explicitly set the table name

    protected $fillable = [
        'question',
        'answer',
        'user_id',
        'status'
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
            ->logOnly(['question', 'answer', 'user_id', 'status'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "FAQ has been {$eventName}")
            ->useLogName('faq')
            ->dontSubmitEmptyLogs();
    }

}
