<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'name', 'bio', 'topic_picture',
        'questions_count', 'followers_count',
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }
}
