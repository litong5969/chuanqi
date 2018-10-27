@extends('layouts.app')
@section('content')
    @include('vendor.ueditor.assets')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">创建文章</div>

                    <div class="card-body">
                        {!! Form::open(['url'=>'/articles']) !!}
                        <div class="form-group">
                            <!--- Title Field --->
                            {!! Form::label('title', '标题:') !!}
                            {!! Form::text('title', old('title'), ['class' => 'form-control']) !!}
                            @if($errors->has('title'))
                                <ul class="list-group">
                                    @foreach($errors->get('title') as $error)
                                        <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        {{--多选--}}

                        <div class="form-group">
                            <select class="js-example-placeholder-multiple form-control"
                                    name="tags[]"
                                    multiple="multiple">
                            </select>
                        </div>

                        <!--- Body Field --->
                        <div class="form-group">
                        {!! Form::label('Body', '正文:') !!}
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
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('js')
    @include('vue.ue')
    @include('vue.select2')

@endsection

