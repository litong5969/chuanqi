@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
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
                        <comments type="article"
                                  model="{{$article->id}}"
                                  count="{{$article->comments()->count()}}">
                        </comments>
                        @if(Auth::check() && Auth::user()->owns($article))
                            <button class="btn btn-link float-right"><a href="/articles/{{$article->id}}/edit">编辑</a>
                            </button>
                            {!! Form::open(['url'=>"/articles/$article->id",'method'=>'DELETE','class'=>'delete-form']) !!}
                            {!! Form::submit('删除',['class'=>'btn btn-link float-right']) !!}
                            {!! Form::close() !!}
                        @endif

                    </div>
                </div>
                <div class="card">
                    <div class="card-body card-blog">
                        <siema ref="siema" class="siema" :current.sync="curSlide" :playing.sync="playing" auto-play
                               :ready="true" :options="options" @init="initFunc" @change="changeFunc">

                            @foreach($article->instalments as $instalment)
                                <div class="media slide">
                                    <a href="#" class="mr-3">
                                        <img class="card-avatar rounded"
                                             src="{{$instalment->user->avatar}}" alt="64x64">
                                    </a>
                                    <br>
                                    @guest
                                        <div class="mx-2 center-block">
                                            <a class="btn btn-outline-secondary" style="width: 60px"
                                               href={{route('login')}} role="button">{{$instalment->votes_count}}</a>
                                        </div>
                                    @else
                                        <div class="mx-2 center-block">
                                            <user-vote-button instalment="{{$instalment->id}}"
                                                              count="{{$instalment->votes_count}}"></user-vote-button>
                                        </div>
                                    @endguest
                                    <div class="media-body">
                                        <h4 class="mt-0">
                                            <a href="/user/{{$instalment->user->name}}">
                                                {{$instalment->user->name}}
                                            </a>
                                        </h4>
                                        <p>{!! $instalment->body !!}<span class="float-right date">
                                            {{$instalment->created_at->format('Y-m-d')}}</span></p>
                                        <div class="card-function ml-1">
                                            <div><i class="fa fa-comments-o float-left icon" aria-hidden="true"></i>
                                                <comments class="float-left" type="instalment" model="{{$instalment->id}}"
                                                          count="{{$instalment->comments()->count()}}"></comments>
                                            </div>
                                            <a class="btn btn-link float-left" href="/instalments/{{$instalment->id}}"><i
                                                        class="fa fa-magic" aria-hidden="true"></i>
                                                在此接棒</a>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                            @endforeach
                        </siema>
                        <div class="btn" @click="$refs.siema.prev()">Prev</div>
                        <div class="btn" @click="$refs.siema.next()">Next</div>
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
                            <article-follow-button article="{{$instalment->article->id}}"></article-follow-button>
                        @endguest
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