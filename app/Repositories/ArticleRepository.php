<?php


namespace App\Repositories;

use App\Tag;
use App\Article;

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
        return Article::published()->latest('updated_at')->with('user')->get();
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
}