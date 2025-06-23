<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_published',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class)->orderBy('order');
    }

    public function responses()
    {
        return $this->hasMany(SurveyResponse::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'survey_member')
            ->withTimestamps();
    }


    
}