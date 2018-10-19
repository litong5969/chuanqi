<?php

namespace App;


use App\Mailer\UserMailer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable {
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'confirmation_token','api_token','settings'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts=[
      'settings'=>'array'
    ];

    public function settings()
    {
    return new UserSetting($this);

    }

    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }

    //关注他人
    public function follows()
    {
        return $this->belongsToMany(Article::class, 'user_article')->withTimestamps();
    }
    
    public function followThis($article)
    {
        return $this->follows()->toggle($article);
        //toggle 点一次增加 再点一次删除
    }

    public function followed($article)
    {
        return !! $this->follows()->where('article_id', $article)->count();
    }

    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'follower_id', 'followed_id')
            ->withTimestamps();
    }
    public function followersUser()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'follower_id')
            ->withTimestamps();
    }
    public function followThisUser($user)
    {
        return $this->followers()->toggle($user);
    }
    
    public function instalments()
    {
        return $this->hasMany(Instalment::class);
    }

    //点赞
    public function votes()
    {
        return $this->belongsToMany(Instalment::class, 'votes')->withTimestamps();
    }

    public function voteFor($instalment)
    {
        return $this->votes()->toggle($instalment);
    }


    public function hasVotedFor($instalment)
    {
        return !! $this->votes()->where('instalment_id', $instalment)->count();

    }

    public function sendPasswordResetNotification($user)
    {
        (new UserMailer())->welcome($user);
    }

    //Message
    public function messages()
    {
        return $this->hasMany(Message::class, 'to_user_id');
    }
}
