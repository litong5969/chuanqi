<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\CreateArticleRequest;
use App\Repositories\ArticleRepository;
use function compact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function redirect;
use function view;



class ArticlesController extends Controller {

    protected $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->articleRepository=$articleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $this->articleRepository->getArticlesFeed();
        return view('articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateArticleRequest $request)
    {


        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id()];
        $article = $this->articleRepository->create($data);
        if($request->get('tags')!=null){
            $tags = $this->articleRepository->normalizeTag($request->get('tags'));
            //多对多操作，写入第三张表
            $article->tags()->attach($tags);
        }

        return redirect()->route('articles.show', [$article->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = $this->articleRepository->byIdWithTagsAndInstalments($id);//把搜索到的tag内容附加到结果里
        $worldlineCounts=$this->articleRepository->worldlineCounts($id);
        $biggestLeg=$this->articleRepository->biggestLeg($id);
        return view('articles.show', compact('article','worldlineCounts','biggestLeg'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = $this->articleRepository->byId($id);
        if(Auth::user()->owns($article)){
            return view('articles.edit', compact('article'));

        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateArticleRequest $request, $id)
    {

        $article = $this->articleRepository->byId($id);
        $tags = $this->articleRepository->normalizeTag($request->get('tags'));
        $article->update([
            'title'=>$request->get('title'),
            'body'=>$request->get('body')
        ]);
        $article->tags()->sync($tags);
        return redirect()->route('articles.show', [$article->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = $this->articleRepository->byId($id);
        if (Auth::user()->owns($article)){
            $article->delete();
            return redirect('/articles/');
        }

        abort(403, 'Forbidden');
    }



}
