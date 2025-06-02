<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailLog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'recipient_email',
        'recipient_name',
        'template_id',
        'subject',
        'body',
        'status',
        'error_message',
        'sent_at',
        'user_id',
        'attachments',  // ADD THIS LINE
    ];

    protected $casts = [
        'attachments' => 'array', // Cast attachments as array automatically
    ];

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
