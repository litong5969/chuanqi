@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">消息通知</div>
                    <div class="card-body">
                        @foreach($messages as $messageGroup)

                            <div class="media {{$messageGroup->first()->shouldAddUnreadClass()?'unread':''}}">
                                @if(Auth::id()==$messageGroup->last()->from_user_id)
                                    <img width="48" class="mr-3 rounded" src="{{$messageGroup->last()->toUser->avatar}}">
                                @else
                                    <img width="48" class="mr-3 rounded" src="{{$messageGroup->last()->fromUser->avatar}}">
                                @endif
                                <div class="media-body">
                                    <h5 class="mt-0">
                                        <a href="#">
                                            @if(Auth::id()==$messageGroup->last()->from_user_id)
                                                {{$messageGroup->last()->toUser->name}}
                                            @else
                                                {{$messageGroup->last()->fromUser->name}}
                                            @endif
                                        </a>
                                    </h5>
                                    <p>
                                        <a href="/inbox/{{$messageGroup->first()->dialog_id}}">
                                            {{$messageGroup->first()->body}}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
