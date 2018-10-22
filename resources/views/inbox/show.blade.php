@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">对话列表</div>
                    <div class="card-body">
                        {!! Form::open(['url'=>"/inbox/$dialogId/store" ,'method'=>'post']) !!}
                        {!! Form::textarea('body', null, ['class' => 'form-control form-group','rows'=>'4']) !!}
                        {!! Form::submit('发送私信',['class'=>'btn btn-primary float-right']) !!}
                        {!! Form::close() !!}
                        <div class="messages-list">
                            @foreach($messages as $message)
                                <div class="media media-message">
                                    <img width="48" class="mr-3 media-avatar img-thumbnail rounded" src="{{$message->fromUser->avatar}}">
                                    <div class="media-body">
                                        <h5 class="mt-0">
                                            <a href="#">
                                                {{$message->fromUser->name}}
                                            </a>
                                        </h5>
                                        <p>
                                            {{$message->body}}
                                            <span class="date float-right">{{$message->created_at->format('Y-m-d')}}</span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
