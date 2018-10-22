<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
class Article extends Model
{
    use Searchable;
    protected $fillable = [
        'title', 'body', 'user_id'
    ];
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function instalments()
    {
        return $this->hasMany(Instalment::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_article')->withTimestamps();
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    //是否隐藏
    public function scopePublished($query)
    {
        return $query->where('is_hidden', 'F');
    }

    public function searchableAs()
    {
        return 'items_index';
    }
}
