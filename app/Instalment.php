<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instalment extends Model
{
    protected $fillable = [
        'article_id', 'body', 'user_id','leg'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    //是否隐藏
    public function scopePublished($query)
    {
        return $query->where('is_hidden', 'F');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}
