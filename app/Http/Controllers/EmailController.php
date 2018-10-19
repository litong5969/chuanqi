<?php

namespace App\Http\Controllers;

use App\User;
use function flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function is_null;
use function redirect;
use function str_random;


class EmailController extends Controller
{
    public function verify($token)
    {
        $user= User::where('confirmation_token',$token)->first();

        if(is_null($user)){
            flash('邮箱验证失败', 'danger')->important();
            return redirect('/');
        }

        $user->is_active=1;
        $user->confirmation_token=str_random(40);
        $user->save();
        Auth::login($user);
        flash('邮箱验证成功', 'success')->important();
        return redirect('/home');
    }
}
