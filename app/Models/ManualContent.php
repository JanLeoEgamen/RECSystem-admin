<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ManualContent extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'title',
        'description',
        'type',
        'content',
        'video_url',
        'contact_email',
        'contact_phone',
        'contact_hours',
        'steps',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'steps' => 'array',
        'is_active' => 'boolean'
    ];

    const TYPE_TUTORIAL_VIDEO = 'tutorial_video';
    const TYPE_FAQ = 'faq';
    const TYPE_USER_GUIDE = 'user_guide';
    const TYPE_SUPPORT = 'support';

    public static function getTypes()
    {
        return [
            self::TYPE_TUTORIAL_VIDEO => 'Tutorial Video',
            self::TYPE_FAQ => 'FAQ',
            self::TYPE_USER_GUIDE => 'User Guide',
            self::TYPE_SUPPORT => 'Support'
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }

    public function getTypeDisplayAttribute()
    {
        return self::getTypes()[$this->type] ?? ucfirst(str_replace('_', ' ', $this->type));
    }

    /**
     * Activity Log Config
     */
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'title',
                'description',
                'type',
                'content',
                'video_url',
                'contact_email',
                'contact_phone',
                'contact_hours',
                'steps',
                'is_active',
                'sort_order'
            ])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Manual Content has been {$eventName}")
            ->useLogName('manual_content')
            ->dontSubmitEmptyLogs();
    }
}
