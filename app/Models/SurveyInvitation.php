<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SurveyInvitation extends Model
{
    use HasFactory;

    protected $fillable = ['survey_id', 'member_id', 'token', 'sent_at', 'answered_at', 'results_sent_at'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invitation) {
            $invitation->token = Str::random(60);
        });
    }
}
