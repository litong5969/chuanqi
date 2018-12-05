@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-shadow">
        <div class="container">
            <h1 class="iFont-4">来啊，用故事拯救世界<i class="fa fa-pied-piper-alt" aria-hidden="true"></i>
                @guest
                    <a class="m-3 btn btn-success btn-lg float-right" href={{route('register')}} role="button">现在注册</a>
                    <a class="m-3 btn btn-primary btn-lg float-right" href={{route('login')}} role="button">登录</a>
                @else
                    <a class="btn btn-primary btn-lg float-right"
                       href={{route('articles.create')}} role="button">创建文章</a>
                @endguest
            </h1>
            <h6 class="display-6">接力写作</h6>
            {{--<p class ="lead">接力写作</p>--}}
            {{--<hr class="my-4">--}}
            {{--<p>用故事拯救世界</p>--}}
            {{--<p class="lead">发发发--}}
            {{--</p>--}}
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-md-9 card-blog">
                <ul class="nav nav-tabs mt-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">最新世界线</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#articles" role="tab" data-toggle="tab">文章列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#messages" role="tab" data-toggle="tab">待定</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#settings" role="tab" data-toggle="tab">待定</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane in active" id="articles">
                        @foreach($articles as $article)
                            <div class="media my-4">

                                <div class="media-conversation-meta ml-3">
                                    <span class="media-conversation-replies">
                                        共
                                        <a href="/articles/{{$article->id}}">{{count($article->instalments)}}</a>
                                        棒
                                    </span>
                                </div>

                                <div class="media-body ml-3">
                                    <div class="mt-0 col-md-12">
                                        <a class="display-6" href="/articles/{{$article->id}}">
                                            {{$article->title}}

                                        <h6 class="display-7 mt-2" style="color: #3D3D3D">
                                            {!!   str_limit(strip_tags($article->body), 120, '... ... ') !!}
                                        </h6>
                                        </a>
                                    </div>
                                </div>

                                <div class="blog-signature float-right" align="right">
                                    <a href="#" class="mx-2 float-right">
                                        <img class="card-avatar rounded-circle"
                                             src="{{$article->user->avatar}}" alt="64x64">
                                    </a>
                                    <div class="float-right">
                                        {{$article->user->name}}<br>
                                        {{$article->created_at->format('Y-m-d')}}
                                    </div>
                                </div>

                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
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