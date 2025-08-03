<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_type',
        'file_size',
        'url',
        'is_published',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class)
            ->withPivot(['is_viewed', 'viewed_at'])
            ->withTimestamps();
    }

    public function getFileIconAttribute()
    {
        switch($this->file_type) {
            case 'application/pdf':
                return 'fa-file-pdf';
            case 'application/msword':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                return 'fa-file-word';
            case 'image/jpeg':
            case 'image/png':
            case 'image/gif':
                return 'fa-file-image';
            default:
                return 'fa-file';
        }
    }

    //logs
    use LogsActivity;
    protected static $logOnlyDirty = true;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'description', 'file_path', 'file_type', 'file_size', 'url', 'is_published'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Document has been {$eventName}")
            ->useLogName('document')
            ->dontSubmitEmptyLogs();
    }
    
}