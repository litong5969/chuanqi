<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use Auth;
use Illuminate\Http\Request;
use function user;


class ArticleFollowController extends Controller
{

protected $article;
    /**
     * ArticleFollowController constructor.
     */
    public function __construct(ArticleRepository $article)
    {
        $this->middleware('auth');
        $this->article=$article;
    }

    public function follow($article)
    {
        Auth::user()->followThis($article);
            return back();
    }

    public function follower(Request $request)
    {
        if (user('api')->followed($request->get('article'))){
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    public function followThisArticle(Request $request)
    {
        $article = $this->article->byId($request->get('article'));
        $followed = user('api')->followThis($article->id);
        if (count($followed['detached']) > 0) {
            $article->decrement('followers_count');
            return response()->json(['followed' => false]);
        }
        $article->increment('followers_count');
        return response()->json(['followed' => true]);
    }
}
