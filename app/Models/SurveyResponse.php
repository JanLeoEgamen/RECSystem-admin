<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'member_id'
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function answers()
    {
    return $this->hasMany(SurveyAnswer::class, 'response_id');
    }
}