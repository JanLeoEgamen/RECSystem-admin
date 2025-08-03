<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function signatories()
    {
        return $this->hasMany(CertificateSignatory::class)->orderBy('order');
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'certificate_member')
                    ->withPivot('issued_at', 'sent_at', 'pdf_path')
                    ->withTimestamps();
    }


    protected static function booted()
    {
        static::deleting(function ($certificate) {
            // Delete all associated PDF files
            foreach ($certificate->members as $member) {
                $path = $member->pivot->pdf_path;
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        });
    }

    //logs
    use LogsActivity;
    protected static $logOnlyDirty = true; 
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'content'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Certificate has been {$eventName}")
            ->useLogName('certificate')
            ->dontSubmitEmptyLogs();
    }
    
}

