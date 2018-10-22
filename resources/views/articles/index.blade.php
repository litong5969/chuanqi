@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-shadow" style="margin-top:-4px;">
        <div class="container">
            <h1 class="display-4">来啊快活啊
                @guest
                    <a class="m-3 btn btn-success btn-lg float-right" href={{route('register')}} role="button">现在注册</a>
                    <a class="m-3 btn btn-outline-primary btn-lg float-right" href={{route('login')}} role="button">登录</a>
                    @else
                <a class="btn btn-primary btn-lg float-right" href={{route('articles.create')}} role="button">创建文章</a>
            @endguest
            </h1>
            <p class="lead">接力写作</p>
            {{--<hr class="my-4">--}}
            {{--<p>用故事拯救世界</p>--}}
            {{--<p class="lead">发发发--}}
            {{--</p>--}}
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-md-9 card-blog">
                @foreach($articles as $article)
                    <div class="media my-4">
                        <div class="mr-3">
                            <a href="">
                                <img width="64" src="{{$article->user->avatar}}" alt="{{$article->user->name}}"
                                     class="card-avatar rounded">
                            </a>
                        </div>

                            <div class="media-conversation-meta">
                                    <span class="media-conversation-replies">
                                        <a href="/articles/{{$article->id}}">{{count($article->instalments)}}</a>
                                        接棒
                                    </span>
                            </div>

                        <div class="media-body ml-3">
                            <h4 class="mt-0">
                                <a href="/articles/{{$article->id}}">
                                    {{$article->title}}
                                </a>

                            </h4>
                            <p>{{$article->user->name}}
                                <t class="date float-right">{{$article->created_at->format('Y-m-d')}}</t>
                            </p>
                        </div>

                    </div>

                @endforeach
                {{--<div style="margin:0 auto;">{!! $articles->render() !!}</div>--}}
            </div>
        </div>
    </div>

    <style>
        .card img {
            width: 100%;
        }
    </style>
@endsection