<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
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
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    public function responses()
    {
        return $this->hasMany(QuizResponse::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'quiz_member')
            ->withTimestamps();
    }
}