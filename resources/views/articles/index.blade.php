@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-md-8">
                @foreach($articles as $article)
                    <div class="media my-4">
                        <div class="mr-3">
                            <a href="">
                                <img width="48" src="{{$article->user->avatar}}" alt="{{$article->user->name}}" class="rounded">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="mt-0">
                                <a href="/articles/{{$article->id}}">
                                    {{$article->title}}
                                </a>
                            </h4>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <style>
        .card img {
            width: 100%;
        }
    </style>
@endsection