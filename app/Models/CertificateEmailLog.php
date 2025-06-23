<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateEmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_id',
        'member_id',
        'email_address',
        'sent_at',
        'status',
        'error_message'
    ];

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}