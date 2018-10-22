<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('titlesearch')){
            $items = Article::search($request->titlesearch)
                ->paginate(20);
        }else{
            $items = Article::paginate(20);
        }
        return view('articles.search',compact('items'));
    }
}
