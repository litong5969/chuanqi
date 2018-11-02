@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="card mb-3">
                    <div class="card-header">
                        {{$instalment->article->title}}
                        @foreach($instalment->article->tags as $tag)
                            <a class="tag float-right" href="/tag/{{$tag->id}}">{{$tag->name}}</a>
                        @endforeach
                    </div>

                    <div class="card-body content">
                        {!!  $instalment->article->body!!}
                    </div>

                    <div class="actions">
                        <comments type="article"
                                  model="{{$instalment->article->id}}"
                                  count="{{$instalment->article->comments()->count()}}">
                        </comments>
                        @if(Auth::check() && Auth::user()->owns($instalment->article))
                            <button class="btn btn-link float-right"><a
                                        href="/articles/{{$instalment->article->id}}/edit">编辑</a>
                            </button>
                            {!! Form::open(['url'=>"/articles/$instalment->article->id",'method'=>'DELETE','class'=>'delete-form']) !!}
                            {!! Form::submit('删除',['class'=>'btn btn-link float-right']) !!}
                            {!! Form::close() !!}
                        @endif

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        @if($instalment->article->instalments->count()>0)
                            已传到第{{$instalment->article->instalments->count()}}棒
                        @else
                            还没有人接棒
                        @endif
                        <h6 class="float-right mt-1">当前世界线：{{$worldLine}}</h6>
                    </div>

                    <div class="card-body card-blog">
                        {{--<siema ref="siema" class="siema" :current.sync="curSlide" :playing.sync="playing" auto-play :ready="true" :options="options" @init="initFunc" @change="changeFunc">--}}
                        {{--                        @while($instalment->prev_instalment==null)--}}
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
                                            <a class="btn btn-outline-secondary" style="width: 60px" href={{route('login')}} role="button">{{$instal->votes_count}}</a>
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
                                    <comments type="instalment" model="{{$instal->id}}"
                                              count="{{$instal->comments()->count()}}"></comments>

                                </div>
                                <div class="mx-2">

                                </div>
                                <hr>
                            </div>
                            {{--                            {!!  $instalment=\App\Instalment::find($instalment->prev_instalment)!!}--}}
                            {{--@endwhile--}}

                            <hr>
                        @endforeach
                        {{--</siema>--}}


                        {{--<div class="btn" @click="$refs.siema.prev()">Prev</div>--}}
                        {{--<div class="btn" @click="$refs.siema.next()">Next</div>--}}
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
                <div class="card mb-3">
                    <div class="card-header question-follow">
                        <span><h5>{{$instalment->article->followers_count}}关注者</h5></span>
                    </div>
                    <div class="card-body">
                        @guest
                                <a class="btn btn-primary float-left" href={{route('login')}} role="button">关注该文</a>
                            <a class="btn btn-outline-primary float-right" href={{route('login')}} role="button">登录接棒</a>
                        @else
                            <article-follow-button article="{{$instalment->article->id}}"></article-follow-button>
                            <a href="#editor" class="btn btn-outline-primary float-right">
                                接下此棒
                            </a>
                        @endguest
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
                                    <i class="fa fa-weibo" aria-hidden="true"></i><a
                                            href="{{$instalment->article->user->settings['weibo']}}">{{$instalment->article->user->settings['weibo']}}</a>
                                @endif
                            </div>
                        </div>
                        <div class="mt-2">

                            <p>{{$instalment->article->user->settings['bio']}}</p>
                        </div>
                        <div class="user-statics text-center">
                            <div class="statics-item text-center">
                                <div class="statics-text">文章</div>
                                <div class="statics-count">{{$instalment->article->user->articles_count}}</div>
                            </div>
                            <div class="statics-item text-center">
                                <div class="statics-text">接棒</div>
                                <div class="statics-count">{{$instalment->article->user->instalments_count}}</div>
                            </div>
                            <div class="statics-item text-center">
                                <div class="statics-text">粉丝</div>
                                <div class="statics-count">{{$instalment->article->user->followers_count}}</div>
                            </div>
                        </div>
                        @guest
                            <a class="btn btn-primary float-left" href={{route('login')}} role="button">关注TA</a>
                            <a class="btn btn-outline-primary float-right" href={{route('login')}} role="button">发送私信</a>
                        @else
                            <user-follow-button class="float-left"
                                                user="{{$instalment->article->user_id}}"></user-follow-button>
                            <send-message class="float-right" user="{{$instalment->article->user_id}}"></send-message>
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