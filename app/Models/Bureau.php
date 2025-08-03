<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Bureau extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['bureau_name', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function members()
    {
        return $this->hasManyThrough(Member::class, Section::class);
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'user_bureau_section')
            ->withPivot('section_id');
    }

    use LogsActivity;
    protected static $logOnlyDirty = true; 
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['bureau_name'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Bureau has been {$eventName}")
            ->useLogName('bureau')
            ->dontSubmitEmptyLogs();
    }
}
