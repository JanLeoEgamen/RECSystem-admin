<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MembershipType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['type_name', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    // logs
    use LogsActivity;
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['type_name'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Membership Type has been {$eventName}")
            ->useLogName('membership_type')
            ->dontSubmitEmptyLogs();
    }

}
