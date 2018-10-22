@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-md-9 card-blog">
                @if($items->count())
                    @foreach($items as $key => $item)
                        <div class="media my-4">
                            <div class="mr-3">
                                <a href="">
                                    <img width="64" src="{{$item->user->avatar}}" alt="{{$item->user->name}}"
                                         class="card-avatar rounded">
                                </a>
                            </div>

                            <div class="media-conversation-meta">
                                    <span class="media-conversation-replies">
                                        <a href="/articles/{{$item->id}}">{{count($item->instalments)}}</a>
                                        接棒
                                    </span>
                            </div>

                            <div class="media-body ml-3">
                                <h4 class="mt-0">
                                    <a href="/articles/{{$item->id}}">
                                        {{$item->title}}
                                    </a>

                                </h4>
                                <p>{{$item->user->name}}
                                    <t class="date float-right">{{$item->created_at->format('Y-m-d')}}</t>
                                </p>
                            </div>

                        </div>
                    @endforeach
                @else
                    <h3 colspan="4">没有搜索到你需要的结果</h3>
                @endif
                {{--<div style="margin:0 auto;">{!! $articles->render() !!}</div>--}}
            </div>
        </div>
    </div>


@endsection


