@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="card mb-3 card-blog">
                    {{--<div class="card-header" style="text-align: center;">--}}
                    {{--{{$instalment->article->title}}--}}
                    {{--@foreach($instalment->article->tags as $tag)--}}
                    {{--<a class="tag float-right" href="/tag/{{$tag->id}}">{{$tag->name}}</a>--}}
                    {{--@endforeach--}}
                    {{--</div>--}}

                    <div class="card-body content">
                        <div class="my-3" style="text-align: center;">{{$instalment->article->title}}</div>
                        <hr>
                        {!!  $instalment->article->body!!}
                    </div>

                    <div class="actions">
                        <div class="card-function ml-1">
                            <i class="fa fa-comments-o float-left icon" aria-hidden="true"></i>
                            <comments type="article" class="float-left"
                                      model="{{$instalment->article->id}}"
                                      count="{{$instalment->article->comments()->count()}}">
                            </comments>
                            <a class="btn btn-link float-left button"
                               href="/articles/{{$instalment->article->id}}"><i
                                        class="fa fa-magic" aria-hidden="true"></i>
                                在此接棒</a>
                            @if(Auth::check() && Auth::user()->owns($instalment->article))
                                <i class="fa fa-pencil float-left icon ml-3" aria-hidden="true"></i>
                                <a class="btn btn-link float-left button"
                                            href="/articles/{{$instalment->article->id}}/edit">编辑</a>
                                <i class="fa fa-times float-left icon  ml-3" aria-hidden="true"></i>
                                {!! Form::open(['url'=>"/articles/$instalment->article->id",'method'=>'DELETE','class'=>'delete-form float-left']) !!}
                                {!! Form::submit('删除',['class'=>'btn btn-link float-left button']) !!}
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body card-blog">
                        @foreach($instalments as $instal)
                            <div class="card-leg col-md-12 col-sm-offset-4 text-center">
                                {{$instal->leg}}.
                            </div><br>
                            <div class="media my-2">
                                <div class="px-0">
                                    <a href="#" class="mx-2">
                                        <img class="card-avatar rounded"
                                             src="{{$instal->user->avatar}}" alt="64x64">
                                    </a>
                                    <br>
                                    @guest
                                        <div class="mx-2 center-block">
                                            <a class="btn btn-outline-secondary" style="width: 60px"
                                               href={{route('login')}} role="button">{{$instal->votes_count}}</a>
                                        </div>
                                    @else
                                        <div class="mx-2 center-block">
                                            <user-vote-button instalment="{{$instal->id}}"
                                                              count="{{$instal->votes_count}}"></user-vote-button>
                                        </div>
                                    @endguest
                                </div>
                                <div class="media-body">
                                    <p class="px-2">{!! $instal->body !!}<br>
                                        <span class="mt-1 float-right blog-signature" align="right">
                                        {{$instal->user->name}}<br>
                                            {{$instal->created_at->format('Y-m-d')}}
                                    </span>
                                    </p>
                                    <div class="card-function ml-1">
                                        <div><i class="fa fa-comments-o float-left icon" aria-hidden="true"></i>
                                            <comments class="float-left" type="instalment" model="{{$instal->id}}"
                                                      count="{{$instal->comments()->count()}}"></comments>
                                        </div>
                                        <a class="btn btn-link float-left" href="/instalments/{{$instal->id}}"><i
                                                    class="fa fa-magic" aria-hidden="true"></i>
                                            在此接棒</a>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <hr>
                        @endforeach
                        @if(Auth::check())
                            {!! Form::open(['url'=>"/instalments",'v-on:submit'=>'onSubmitForm']) !!}
                            {!! Form::hidden('article_id',$instalment->article->id) !!}
                            {!! Form::hidden('prev_id',$instalment->id) !!}
                            {!! Form::hidden('leg',$instalment->leg) !!}
                        <!--- Body Field --->
                            <div class="form-group">
                                <!-- UE编辑器容器 -->
                                <script id="container" name="body" type="text/plain">{!!old('body')!!}</script>
                                @if($errors->has('body'))
                                    <ul class="list-group">
                                        @foreach($errors->get('body') as $error)
                                            <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            {!! Form::submit('提交',['class'=>'btn btn-primary form-control']) !!}
                            {!! Form::close() !!}
                        @else
                            <a href="/login" class="btn btn-primary btn-block">登录接棒</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mb-3 card-article-profile">
                    <div class="card-body">
                        <ul class="fa-ul">
                            <li><i class="fa-li fa fa-sitemap" aria-hidden="true"></i>
                                世界线分支数：{{$worldlineCounts}}</li>
                            <li><i class="fa-li fa fa-server  fa-rotate-270" aria-hidden="true"></i>
                                总接棒数：{{$instalment->article->instalments->count()}}</li>
                            <li><i class="fa-li fa fa-thumbs-up" aria-hidden="true"></i>
                                获赞数：{{$instalment->article->votes_count}}</li>
                            <li><i class="fa-li fa fa-users" aria-hidden="true"></i>
                                关注者：{{$instalment->article->followers_count}}</li>
                            <li><i class="fa-li fa fa-magic" aria-hidden="true"></i>
                                @if($instalment->article->instalments->count()>0)
                                    最远已传至第{{$biggestLeg}}棒
                                @else
                                    还没有人接棒
                                @endif</li>
                        </ul>
                        <hr>
                        @guest
                            <a class="btn btn-primary float-left" href={{route('login')}} role="button">关注该文</a>
                        @else
                            <article-follow-button article="{{$instalment->article->id}}"></article-follow-button>
                        @endguest
                        <a href="/articles/{{$instalment->article_id}}" class="btn btn-outline-primary float-right">
                            进入文章
                        </a>
                    </div>
                </div>
                @if($instalment->is_the_last=='T')
                    <div class="card mb-3 card-worldline">
                        <div class="card-body">
                            <h5 class="display-6" style="text-align: center; color:#ff7100;">
                                当前世界线<br>{{$worldlineValue}}</h5>
                        </div>
                    </div>
                @endif
                <div class="card card-profile">
                    <div class="card-image">
                        <a href="#"><img class="img" height="250" src="/images/heros/cell1.jpg">
                            <div class="card-caption"> 村民 lv1</div>
                        </a>
                        <div class="ripple-cont"></div>
                    </div>
                    <div class="card-body">
                        <div class="media">
                            <div class="mr-3">
                                <a href="#">
                                    <img class="card-avatar" src="{{$instalment->article->user->avatar}}"
                                         alt="{{$instalment->article->user->name}}">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="mt-0">
                                    <a href="">
                                        {{$instalment->article->user->name}}
                                    </a>
                                </h4>
                                @if($instalment->article->user->settings['weibo']!=null)
                                    <a href="{{$instalment->article->user->settings['weibo']}}"><i
                                                class="fa fa-weibo"
                                                aria-hidden="true"></i> {{$instalment->article->user->settings['weibo']}}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="mt-2">
                            <p>{{$instalment->article->user->settings['bio']}}</p>
                        </div>
                        <div class="user-statics text-center">
                            <div class="statics-item text-center">
                                <a href="#" class="statics-count">文章</a>
                                <div class="statics-count">{{$instalment->article->user->articles_count}}</div>
                            </div>
                            <div class="statics-item text-center">
                                <a href="#" class="statics-count">接棒</a>
                                <div class="statics-count">{{$instalment->article->user->instalments_count}}</div>
                            </div>
                            <div class="statics-item text-center">
                                <a href="#" class="statics-count">粉丝</a>
                                <div class="statics-count">{{$instalment->article->user->followers_count}}</div>
                            </div>
                        </div>
                        @guest
                            <a class="btn btn-primary float-left" href={{route('login')}} role="button">关注TA</a>
                            <a class="btn btn-outline-primary float-right"
                               href={{route('login')}} role="button">发送私信</a>
                        @else
                            <user-follow-button class="float-left"
                                                user="{{$instalment->article->user_id}}"></user-follow-button>
                            <send-message class="float-right"
                                          user="{{$instalment->article->user_id}}"></send-message>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card img {
            width: 100%;
        }
    </style>
@endsection

@section('js')
    @include('vue.ue')
@endsection