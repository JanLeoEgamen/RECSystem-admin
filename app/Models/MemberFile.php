<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MemberFile extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected static $logOnlyDirty = true;

    protected $fillable = [
        'title',
        'description',
        'assigned_by',
        'member_id',
        'due_date',
        'is_required'
    ];

    protected $dates = [
        'due_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function uploads()
    {
        return $this->hasMany(MemberFileUpload::class);
    }

    public function latestUpload()
    {
        return $this->hasOne(MemberFileUpload::class)->latestOfMany();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'description', 'due_date', 'is_required'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Member File has been {$eventName}")
            ->useLogName('member_file')
            ->dontSubmitEmptyLogs();
    }
}