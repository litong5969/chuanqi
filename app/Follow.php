<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model {
    protected $table = 'user_article';
    protected $fillable = ['user_id', 'article_id'];
}
