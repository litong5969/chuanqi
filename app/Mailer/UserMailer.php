<?php


namespace App\Mailer;

use Auth;

class UserMailer extends Mailer {
    public function followNotifyEmail($email)
    {
        $data = [
            'url' => 'chuanqi.pao',
            'name' => Auth::guard('api')->user()->name,
        ];
        $this->sentTo('chuanqi_app_new_user_follow', $email, $data);
    }

    public function passwordReset($email, $token)
    {
        $data = [
            'url' => route('password.reset', ['token' => $token]),
        ];
        $this->sentTo('chuanqi_app_password_reset', $email, $data);
    }

    public function welcome(User $user)
    {
        $data = [
            'url' => route('email.verify', ['token' => $user->confirmation_token]),
            'name' => $user->name,
        ];
        $this->sentTo('chuanqi_app_register', $user->email, $data);
    }
}