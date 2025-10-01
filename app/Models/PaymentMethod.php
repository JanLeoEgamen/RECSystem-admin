<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'mode_of_payment_name',
        'account_name',
        'account_number',
        'mode_of_payment_qr_image',
        'is_published',
        'amount',
    ];

    // Activity logs
    use LogsActivity;
    protected static $logOnlyDirty = true;
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['mode_of_payment_name', 'account_name', 'account_number'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Payment method has been {$eventName}")
            ->useLogName('payment_method')
            ->dontSubmitEmptyLogs();
    }
} 