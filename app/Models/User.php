<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;



class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles,  SoftDeletes; // Add SoftDeletes trait
    

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'last_name',
        'middle_name',
        'first_name',
        'birthdate',
        'email',
        'password',
        'member_id',
        'login_attempts',
        'is_locked',     
        'locked_at', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_locked' => 'boolean', 
            'locked_at' => 'datetime', 
        ];
    }
    
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
    
    public function communities()
    {
        return $this->hasMany(Community::class);
    }
    
    public function eventAnnouncements()
    {
        return $this->hasMany(EventAnnouncement::class);
    }
    
    public function faqs()
    {
        return $this->hasMany(FAQ::class);
    }
    
    public function mainCarousels()
    {
        return $this->hasMany(MainCarousel::class);
    }


    public function supporters()
    {
        return $this->hasMany(Supporter::class);
    }

    public function bureaus()
    {
        return $this->hasMany(Bureau::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function membershipTypes()
    {
        return $this->hasMany(MembershipType::class);
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'user_id');
    }


    public function assignedBureaus()
    {
        return $this->belongsToMany(Bureau::class, 'user_bureau_section')
            ->withPivot('section_id');
    }

    public function assignedSections()
    {
        return $this->belongsToMany(Section::class, 'user_bureau_section')
            ->withPivot('bureau_id');
    }

    // logs
    use LogsActivity;
    protected static $logOnlyDirty = true;
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['last_name', 'first_name', 'birthdate', 'email', 'member_id', 'is_locked', 'login_attempts'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "User has been {$eventName}")
            ->useLogName('user')
            ->dontSubmitEmptyLogs();
    }
    
    public function isPasswordInHistory($newPassword)
    {
        // Get last 5 passwords from password history (excluding current password)
        $passwordHistory = $this->passwordHistory()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Check against the last 5 historical passwords
        foreach ($passwordHistory as $oldPassword) {
            if (Hash::check($newPassword, $oldPassword->password)) {
                return true;
            }
        }

        // Also check current password (this should be the fi   rst check that fails in NewPasswordController)
        if (Hash::check($newPassword, $this->password)) {
            return true;
        }

        return false;
    }

    /**
     * Add password to history
     */
    public function addPasswordToHistory($password)
    {
        // Add the new password to history
        $this->passwordHistory()->create([
            'password' => $password, // This should already be hashed when passed in
        ]);

        // Get all password histories ordered by creation date (newest first)
        $allHistories = $this->passwordHistory()
            ->orderBy('created_at', 'desc')
            ->get();

        // If we have more than 5 entries, delete the excess oldest ones
        if ($allHistories->count() > 5) {
            // Get the IDs of entries beyond the first 5 (the oldest ones)
            $entriesToDelete = $allHistories->slice(5)->pluck('id')->toArray();
            
            // Delete the oldest entries
            if (!empty($entriesToDelete)) {
                $this->passwordHistory()->whereIn('id', $entriesToDelete)->delete();
            }
        }
    }

    /**
     * Password history relationship
     */
    public function passwordHistory()
    {
        return $this->hasMany(PasswordHistory::class);
    }

    public function resetLoginAttempts()
    {
        $this->update([
            'login_attempts' => 0,
            'is_locked' => false,
            'locked_at' => null
        ]);
    }

    public function incrementLoginAttempts()
    {
        $this->increment('login_attempts');
        
        if ($this->login_attempts >= 3) {
            $this->update([
                'is_locked' => true,
                'locked_at' => now()
            ]);
        }
        
        return $this;
    }

}