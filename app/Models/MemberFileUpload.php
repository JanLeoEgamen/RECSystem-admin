<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MemberFileUpload extends Model
{
    use HasFactory, LogsActivity;
    protected static $logOnlyDirty = true;

    protected $fillable = [
        'member_file_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'notes',
        'uploaded_at'
    ];

    protected $dates = [
        'uploaded_at',
        'created_at',
        'updated_at'
    ];

    public function memberFile()
    {
        return $this->belongsTo(MemberFile::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['file_name', 'file_type', 'file_size'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Member File Upload has been {$eventName}")
            ->useLogName('member_file_upload')
            ->dontSubmitEmptyLogs();
    }
}