<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberActivityLog extends Model
{
    public $timestamps = false; // using created_at manually
    protected $fillable = [
        'member_id',
        'applicant_id',
        'type',
        'action',
        'details',
        'meta',
        'performed_by',
        'created_at'
    ];

    protected $casts = [
        'meta' => 'array',
        'created_at' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by')->withDefault([
            'name' => 'System'
        ]);
    }
}
