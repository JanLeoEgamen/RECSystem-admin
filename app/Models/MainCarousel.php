<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MainCarousel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image',
        'title',
        'content',
        'user_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Accessor for full image URL
    public function getImageUrlAttribute()
    {
        return asset('storage/'.$this->image);
    }

    //logs
    use LogsActivity;
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['image', 'title', 'content', 'user_id', 'status'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Main Carousel has been {$eventName}")
            ->useLogName('main_carousel')
            ->dontSubmitEmptyLogs();
    }
    
}
