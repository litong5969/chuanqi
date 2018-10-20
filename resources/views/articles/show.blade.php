@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="card mb-3">
                    <div class="card-header">
                        {{$article->title}}
                        @foreach($article->tags as $tag)
                            <a class="tag float-right" href="/tag/{{$tag->id}}">{{$tag->name}}</a>
                        @endforeach
                    </div>

                    <div class="card-body content">
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
            </div>

            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-header question-follow">
                        <span><h5>{{$article->followers_count}}关注者</h5></span>
                    </div>
                    <div class="card-body">
                        <article-follow-button article="{{$article->id}}"></article-follow-button>
                        <a href="#editor" class="btn btn-outline-primary float-right">
                            接下此棒
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-md-offset-1" id="post">
                <div class="card mb-3">
                    <div class="card-header">
                        已传到第{{$article->instalments->count()+1}}棒
                    </div>

                    <div class="card-body">
                        @foreach($article->instalments as $instalment)
                            <div class="media">
                                <a href="#" class="mr-3">
                                    <img class="media-object rounded" width="64"
                                         src="{{$instalment->user->avatar}}" alt="64x64">
                                </a>
                                <div class="media-body">
                                    <h4 class="mt-0">
                                        <a href="/user/{{$instalment->user->name}}">
                                            {{$instalment->user->name}}
                                        </a>
                                    </h4>
                                    <p>{!! $instalment->body !!}<span class="float-right date">
                                            {{$article->created_at->format('Y-m-d')}}</span></p>

                                    <comments type="instalment" model="{{$instalment->id}}"
                                              count="{{$instalment->comments()->count()}}"></comments>

                                </div>
                                <div class="mr-3">
                                    <user-vote-button instalment="{{$instalment->id}}"
                                                      count="{{$instalment->votes_count}}"></user-vote-button>

                                </div>

                            </div>
                            <hr>
                        @endforeach
                        <div class="media" v-for="instalment in instalments">
                            <a href="#" class="mr-3">
                                <img class="media-object rounded" width="64"
                                     src="@{{$instalment.avatar}}" alt="64x64">
                            </a>
                            <div class="media-body">
                                <h4 class="mt-0">
                                    <a href="/user/@{{instalment.name}}">
                                        @{{instalment.name}}
                                    </a>
                                </h4>
                                @{!! instalment.body !!}
                            </div>
                            <div class="mr-3 float-right">
                                <user-vote-button instalment="@{{instalment.id}}"
                                                  count="@{{instalment.votes_count}}"></user-vote-button>
                            </div>
                        </div>

                        @if(Auth::check())
                            {!! Form::open(['url'=>"/instalment",'v-on:submit'=>'onSubmitForm']) !!}
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
                <div class="card mb-3">
                    <div class="card-header question-follow">
                        <h5>关于作者</h5>
                    </div>
                    <div class="card-body">
                        <div class="media">
                            <div class="mr-3">
                                <a href="#">
                                    <img class="rounded" width="36" src="{{$article->user->avatar}}"
                                         alt="{{$article->user->name}}">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="mt-0">
                                    <a href="">
                                        {{$article->user->name}}
                                    </a>
                                </h4>
                            </div>
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
    <script>
        new Vue({
            el: '#post',
            data: {
                instalments: [],
                newInstalment: {
                    name: '{{Auth::user()->name}}',
                    avatar: '{{Auth::user()->avatar}}',
                    body: ''
                },
                newPost: {
                    Article_id: '{{$article->id}}',
                    user_id: '{{Auth::user()->id}}',
                    body: ''
                }
            },
            methods: {
                onSubmitForm: function (e) {
                    e.preventDefault();
                    var instalment = this.newInstalment;
                    var post = this.newPost;
                    post.body = instalment.body;
                    axios.post('instalment', post, function () {
                        this.instalments(instalment);
                    });
                    this.newInstalment = {
                        name: '{{Auth::user()->name}}',
                        avatar: '{{Auth::user()->avatar}}',
                        body: ''
                    };

                }
            }
        })
    </script>
@endsection