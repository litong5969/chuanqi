@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-8 col-md-offset-1 my-3">
                <div class="card mb-3 card-blog">
                    <div class="card-body content">
                        <div class="my-3"
                             style="text-align: center;">{{$article->title}}
                            @foreach($article->tags as $tag)
                                <a class="tag float-right" href="/tag/{{$tag->id}}">{{$tag->name}}</a>
                            @endforeach</div>
                        <hr>
                        {!!  $article->body!!}
                    </div>
                    <div class="actions">
                        <div class="card-function ml-1">
                            <i class="fa fa-comments-o float-left icon" aria-hidden="true"></i>
                            <comments type="article" class="float-left"
                                      model="{{$article->id}}"
                                      count="{{$article->comments()->count()}}">
                            </comments>
                            <a class="btn btn-link float-left button"
                               href="/articles/{{$article->id}}"><i
                                        class="fa fa-magic" aria-hidden="true"></i>
                                在此接棒</a>
                            @if(Auth::check() && Auth::user()->owns($article))
                                <i class="fa fa-pencil float-left icon ml-3" aria-hidden="true"></i>
                                <a class="btn btn-link float-left button"
                                   href="/articles/{{$article->id}}/edit">编辑</a>
                                <i class="fa fa-trash float-left icon  ml-3" aria-hidden="true"></i>
                                {!! Form::open(['url'=>"/articles/$article->id",'method'=>'DELETE','class'=>'delete-form float-left']) !!}
                                {!! Form::submit('删除',['class'=>'btn btn-link float-left button']) !!}
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body card-blog">
                        @if($worldLines!=null)
                            {{--<siema ref="siema" class="siema" :current.sync="curSlide" :playing.sync="playing" auto-play--}}
                            {{--:ready="true" :options="options" @init="initFunc" @change="changeFunc">--}}
                            <div class="card-leg col-md-12 col-sm-offset-4 display-6 text-center">
                                共{{count($worldLines)}}条分支
                            </div>
                            @foreach($worldLines as $worldLine)
                                <hr>
{{--                                @php($lastid=array_last(array_first($worldLine))->id)--}}
                                <a class="btn btn-black float-left mr-4" href="/instalments/{{array_last(array_first($worldLine))->id}}">{{array_last($worldLine)}}</a>
                                <div class="media slide">
                                    @foreach(array_first($worldLine) as $anInstalment)
                                             <div class="float-left">
                                            {{--<h5 class="display-7 ml-3">{{$anInstalment->leg}}.</h5>--}}
                                            <a href="/instalments/{{$anInstalment->id}}" class="mr-3">
                                                <img class="card-avatar rounded"
                                                     src="{{$anInstalment->user->avatar}}" alt="64x64">
                                            </a>
                                            <h5 class="display-7 mt-2 ml-1">
                                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                {{$anInstalment->votes_count}}
                                            </h5>
                                        </div>
                                    @endforeach
                                </div>

                            @endforeach
                        @else
                            <div class="card-leg col-md-12 col-sm-offset-4 display-6 text-center">
                                还未发展出任何世界线
                            </div>
                        @endif
                    </div>
                </div>


                <div class="card-body card-blog">
                    <div class="card-leg col-md-12 col-sm-offset-4 display-6 text-center">
                        从头来过.
                    </div>
                    <hr>
                @if(Auth::check())
                    {!! Form::open(['url'=>"/instalments",'v-on:submit'=>'onSubmitForm']) !!}
                    {!! Form::hidden('article_id',$article->id) !!}
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
                        <a href="/login" class="btn btn-primary btn-block">登录开启新宇宙</a>
                    @endif
                </div>

            </div>
            <div class="col-md-3 my-3">
                <div class="card mb-3 card-article-profile">
                    <div class="card-body">
                        <ul class="fa-ul">
                            <li><i class="fa-li fa fa-sitemap" aria-hidden="true"></i>
                                世界线分支数：{{$worldLineCounts}}</li>
                            <li><i class="fa-li fa fa-server  fa-rotate-270" aria-hidden="true"></i>
                                总接棒数：{{$article->instalments->count()}}</li>
                            <li><i class="fa-li fa fa-thumbs-up" aria-hidden="true"></i>
                                获赞数：{{$article->votes_count}}</li>
                            <li><i class="fa-li fa fa-users" aria-hidden="true"></i>
                                关注者：{{$article->followers_count}}</li>
                            <li><i class="fa-li fa fa-magic" aria-hidden="true"></i>
                                @if($article->instalments->count()>0)
                                    最远已传至第{{$biggestLeg}}棒
                                @else
                                    还没有人接棒
                                @endif</li>
                        </ul>
                        <hr>
                        @guest
                            <a class="btn btn-primary float-left" href={{route('login')}} role="button">关注该文</a>
                        @else
                            <article-follow-button article="{{$article->id}}"></article-follow-button>
                        @endguest
                        @if($worldLines!=null)
                        <a class="btn btn-black float-right"
                           href="/instalments/{{last(array_first(array_random($worldLines)))->id}}">随机世界线</a>
                        @endif
                        {{--<a href="/articles/{{$instalment->article_id}}" class="btn btn-outline-primary float-right">--}}
                        {{--进入文章--}}
                        {{--</a>--}}
                    </div>
                </div>
                <div class="card card-profile">
                    <div class="card-image">
                        <a href="#"><img class="img" height="250" src="/images/heros/cell1.jpg">
                            <div class="card-caption"> 村民 lv1</div>
                        </a>
                        <div class="ripple-cont"></div>
                    </div>
                    <div class="card-body" style="margin-top: 30px">
                        <div class="media">
                            <div class="mr-3">
                                <a href="#">
                                    <img class="card-avatar" src="{{$article->user->avatar}}"
                                         alt="{{$article->user->name}}">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="mt-0">
                                    <a href="">
                                        {{$article->user->name}}
                                    </a>
                                </h4>
                                @if($article->user->settings['weibo']!=null)
                                    <i class="fa fa-weibo" aria-hidden="true"></i><a
                                            href="{{$article->user->settings['weibo']}}">{{$article->user->settings['weibo']}}</a>
                                @endif
                            </div>
                        </div>
                        <div class="mt-2">

                            <p>{{$article->user->settings['bio']}}</p>
                        </div>
                        <div class="user-statics text-center">
                            <div class="statics-item text-center">
                                <div class="statics-text">文章</div>
                                <div class="statics-count">{{$article->user->articles_count}}</div>
                            </div>
                            <div class="statics-item text-center">
                                <div class="statics-text">接棒</div>
                                <div class="statics-count">{{$article->user->instalments_count}}</div>
                            </div>
                            <div class="statics-item text-center">
                                <div class="statics-text">粉丝</div>
                                <div class="statics-count">{{$article->user->followers_count}}</div>
                            </div>
                        </div>
                        <user-follow-button user="{{$article->user_id}}"></user-follow-button>
                        <send-message class="float-right" user="{{$article->user_id}}"></send-message>
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