<?php


namespace App;


class UserSetting {
    protected $user;
    protected $allowed = ['bio', 'weibo', 'weibo_url'];

    /**
     * UserSetting constructor.
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function merge(array $attributes)
    {
        $settings = array_merge($this->user->settings, array_only($attributes, $this->allowed));
        return $this->user->update(['settings' => $settings]);
    }

}