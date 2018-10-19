<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\InstalmentRepository;
use Auth;
use Illuminate\Http\Request;
use function user;

/**
 * Class CommentsController
 * @package App\Http\Controllers
 */
class CommentsController extends Controller {
    /**
     * @var ArticleRepository
     */
    protected $article;
    /**
     * @var InstalmentRepository
     */
    protected $instalment;
    /**
     * @var CommentRepository
     */
    protected $comment;

    /**
     * CommentsController constructor.
     * @param $article
     * @param $instalment
     * @param $comment
     */
    public function __construct(ArticleRepository $article, InstalmentRepository $instalment, CommentRepository $comment)
    {
        $this->article = $article;
        $this->instalment = $instalment;
        $this->comment = $comment;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function article($id)
    {
        return $this->article->getArticleCommentsById($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function instalment($id)
    {
        return $this->instalment->getInstalmentCommentsById($id);
    }

    /**
     * @return mixed
     */
    public function store()
    {
        $model = $this->getModelNameFromType(request('type'));
       return $comment = $this->comment->create([
            'commentable_id' => request('model'),
            'commentable_type' => $model,
            'user_id' => user('api')->id,
            'body' => request('body'),
        ]);
    }

    /**
     * @param $type
     * @return string
     */
    public function getModelNameFromType($type)
    {
        return $type === 'article' ? 'App\Article' : 'App\Instalment';
    }
}
