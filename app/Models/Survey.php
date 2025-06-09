<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Str;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'slug', 'user_id'];

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

    public function invitations()
    {
        return $this->hasMany(SurveyInvitation::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($survey) {
            $survey->slug = Str::slug($survey->title) . '-' . Str::random(6);
        });
    }
}
