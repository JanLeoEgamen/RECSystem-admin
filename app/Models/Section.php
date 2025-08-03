<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['section_name', 'bureau_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function bureau()
    {
        return $this->belongsTo(Bureau::class);
    }


    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'user_bureau_section')
            ->withPivot('bureau_id');
    }

    // logs
    use LogsActivity;
    protected static $logOnlyDirty = true;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['section_name'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Section has been {$eventName}")
            ->useLogName('section')
            ->dontSubmitEmptyLogs();
    }

}
