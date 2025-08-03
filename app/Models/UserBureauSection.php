<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class UserBureauSection extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id',
        'bureau_section_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bureauSection()
    {
        return $this->belongsTo(UserBureauSection::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['user_id', 'bureau_section_id'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "User Bureau Section has been {$eventName}")
            ->useLogName('user_bureau_section')
            ->dontSubmitEmptyLogs();
    }
}
