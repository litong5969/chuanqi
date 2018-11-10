<?php


namespace App\Repositories;

use App\Instalment;
use App\Tag;
use App\Article;
use Illuminate\Support\Facades\DB;

/**
 * Class ArticleRepository
 * @package App\Repositories
 */
//直接调用Article模型的类
class ArticleRepository {
    /**
     * @param $id
     * @return mixed
     */
    public function byIdWithTagsAndInstalments($id)
    {
        return Article::where('id', $id)->with('tags', 'instalments')->first();
    }

    public function create(array $attributes)
    {
        return Article::create($attributes);
    }


    public function byId($id)
    {
        return Article::find($id);
    }

    public function getArticlesFeed()
    {
        return Article::published()->latest('created_at')->with('user')->get();
    }

    public function getArticleCommentsById($id)
    {
        $article = Article::with('comments', 'comments.user')->where('id', $id)->first();
        return $article->comments;
    }

    public function normalizeTag(array $tags)
    {

        return collect($tags)->map(function ($tag) {
            if (is_numeric($tag)) {
                //计数加一
                Tag::find($tag)->increment('articles_count');
                return (int)$tag;
            }
            $newTag = Tag::create(['name' => $tag, 'articles_count' => 1]);
            return $newTag->id;
        })->toArray();
    }

    public function worldlineCounts($id)
    {
        return $worldlineCounts = Instalment::where('article_id', $id)->where('is_the_last', 'T')->get()->count();
    }

    public function biggestLeg($id)
    {
        return Instalment::where('article_id', $id)->max('leg');
    }

    public function getAllLastInstalments($id)
    {
        return Instalment::where('article_id', $id)->where('is_the_last', 'T')->get();
    }

    public function getAllLastIds($id)
    {
        $lasts = Instalment::where('article_id', $id)->where('is_the_last', 'T')->get();
        $last_ids = [];
        foreach ($lasts as $last) {
            $last_ids = array_prepend($last_ids, $last->id);
        }
        return $last_ids;
    }

    public function getPrevInstalmentId($id)
    {
        $instalment = DB::table('instalment_instalment')->where('next_id', $id)->first();
        return $instalment->prev_id;
    }

    public function instalmentById($id)
    {
        return Instalment::find($id);
    }
}