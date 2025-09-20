<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Applicant extends Model
{
    use HasFactory, SoftDeletes;

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
        'has_license',
        'email_address',
        'emergency_contact',
        'emergency_contact_number',
        'relationship',
        'reference_number',
        'payment_proof_path',
        'payment_status',
        'gcash_name',
        'gcash_number',
        'license_class',
        'license_number',
        'callsign',
        'license_expiration_date',
        'user_id',
        'region',
        'province',
        'municipality',
        'barangay',
        'house_building_number_name',
        'zip_code',
        'street_address',
        'is_student',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function member()
    {
        return $this->hasOne(Member::class);
    }

    //logs
    use LogsActivity;
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'last_name', 'first_name', 'middle_name', 'suffix', 'sex', 'birthdate', 'civil_status', 'citizenship', 'blood_type', 'cellphone_no', 'telephone_no', 'has_license', 'email_address', 'emergency_contact', 'emergency_contact_number', 'relationship', 'reference_number', 'payment_proof_path', 'payment_status', 'license_class', 'license_number', 'callsign', 'license_expiration_date', 'user_id', 'region', 'province', 'municipality', 'barangay', 'house_building_number_name', 'zip_code', 'street_address', 'is_student'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Applicant has been {$eventName}")
            ->useLogName('applicant')
            ->dontSubmitEmptyLogs();
    }
}
