<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Member extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected static $logOnlyDirty = true;

    protected $fillable = [
        'status',
        'last_name',
        'first_name',
        'middle_name',
        'suffix',
        'sex',
        'birthdate',
        'civil_status',
        'citizenship',
        'blood_type',
        'cellphone_no',
        'telephone_no',
        'email_address',
        'emergency_contact',
        'emergency_contact_number',
        'relationship',
        'rec_number',
        'license_class', 
        'license_number',
        'license_expiration_date',
        'callsign',
        'applicant_id',
        'section_id',
        'membership_type_id',
        'user_id',
        'region',
        'province',
        'municipality',
        'barangay',
        'street_address',
        'house_building_number_name',
        'zip_code',
        'membership_start',
        'membership_end',
        'is_lifetime_member',
        'last_renewal_date',


    ];

// In your Member model
protected $dates = [
    'birthdate',
    'license_expiration_date',
    'membership_end',
    'membership_start',
    'last_renewal_date',
    'created_at',
    'updated_at',
    'deleted_at'
];




    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function bureau()
    {
        return $this->hasOneThrough(Bureau::class, Section::class);
    }

    public function membershipType()
    {
        return $this->belongsTo(MembershipType::class);
    }

    public function certificates()
    {
        return $this->belongsToMany(Certificate::class)
                    ->withPivot(['issued_at', 'sent_at', 'pdf_path'])
                    ->withTimestamps();
    }


    public function userAsMember()
    {
        return $this->hasOne(User::class, 'member_id');
    }

    public function announcements()
    {
        return $this->belongsToMany(Announcement::class)
            ->withPivot(['is_read', 'read_at'])
            ->withTimestamps()
            ->orderBy('created_at', 'desc');
    }
    
    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'survey_member')
            ->withTimestamps();
    }


    public function surveyResponses()
    {
        return $this->hasMany(SurveyResponse::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_registrations')
            ->withPivot(['status', 'notes'])
            ->withTimestamps();
    }

    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'quiz_member')
            ->withTimestamps();
    }

    public function quizResponses()
    {
        return $this->hasMany(QuizResponse::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class)
            ->withPivot(['is_viewed', 'viewed_at'])
            ->withTimestamps()
            ->orderBy('created_at', 'desc');
    }

    public function isExpired()
    {
        if ($this->is_lifetime_member) {
            return false;
        }
        
        if (!$this->membership_end) {
            return false;
        }
        
        return now()->gt($this->membership_end);
    }

    public function renewals()
    {
        return $this->hasMany(Renewal::class);
    }

    public function latestRenewal()
    {
        return $this->hasOne(Renewal::class)->latestOfMany();
    }

    
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'status', 
                'last_name', 
                'first_name', 
                'middle_name', 
                'suffix',
                'birthdate',
                'license_expiration_date',
                'membership_start',
                'membership_end',
                'last_renewal_date',
                'created_at',
                'updated_at',
                'deleted_at'
            ])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Member has been {$eventName}")
            ->useLogName('member')
            ->dontSubmitEmptyLogs();
    }

    public function canBeViewedBy(User $user)
    {
        // Admins can view any member's logs
        if ($user->hasPermissionTo('view members')) {
            return true;
        }
        
        // Members can only view their own logs
        return $user->id === $this->id;
    }
}
