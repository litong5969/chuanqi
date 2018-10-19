<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserFollowNotification;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use function in_array;
use function response;
use Auth;

class FollowersController extends Controller
{
    protected $user;

    /**
     * FollowersController constructor.
     * @param $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }


    public function index($id)
    {
        $user = $this->user->ById($id);
        $followers = $user->followersUser()->pluck('follower_id')->toArray();
        if(in_array(user('api')->id,$followers)){
            return response()->json(['followed'=>true]);
        }
        return response()->json(['followed'=>false]);
    }
    
    public function follow()
    {
        $userToFollow = $this->user->byId(request('user'));
        $followed=user('api')->followThisUser($userToFollow->id);

        if (count($followed['attached']) > 0) {
            $userToFollow->notify(new NewUserFollowNotification());
            $userToFollow->increment('followers_count');
            return response()->json(['followed' => true]);
        }
        $userToFollow->decrement('followers_count');
        return response()->json(['followed' => false]);
    }
}