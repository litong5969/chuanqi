@extends('layouts.app')
@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">创建文章</div>

                    <div class="card-body">
                        {!! Form::open(['url'=>"/articles/$article->id",'method'=>'PATCH']) !!}
                        {{--                        {{method_field('PATCH')}}--}}
                        <div class="form-group">
                            <!--- Title Field --->
                            {!! Form::label('title', '标题:') !!}
                            {!! Form::text('title', $article->title, ['class' => 'form-control']) !!}
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
                            <select class="js-example-placeholder-multiple form-control" name="tags[]"
                                    multiple="multiple">
                                @foreach($article->tags as $tag)
                                    <option value="{{$tag->id}}" selected="selected">{{$tag->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!--- Body Field --->
                        <div class="form-group">
                        {!! Form::label('Body', '正文:') !!}
                        <!-- UE编辑器容器 -->
                            <script id="container" name="body"
                                    type="text/plain">{!!$article->body!!}</script>
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
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container', {
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft', 'justifycenter', 'justifyright', 'link', 'insertimage', 'fullscreen']
            ],
            autoHeightEnabled: true,
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode: true,
            initialFrameHeight:220,
            wordCount: true,
            maximumWords:10000,
            minFrameHeight:140,
            imagePopup: false,
            autotypeset: {indent: true, imageBlockLine: 'center'},
        });
        ue.ready(function () {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
        // select2内容
        $(document).ready(function () {
            function formatTag(tag) {
                return "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" +
                tag.name ? tag.name : "Laravel" +
                    "</div></div></div>";
            }

            function formatTagSelection(tag) {
                return tag.name || tag.text;
            }

            $(".js-example-placeholder-multiple").select2({
                tags: true,
                placeholder: '选择相关话题',
                minimumInputLength: 2,
                ajax: {
                    url: '/api/tags',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {q: params.term};
                    },
                    processResults: function (data, params) {
                        return {results: data};
                    },
                    cache: true
                },

                templateResult: formatTag,
                templateSelection: formatTagSelection,
                escapeMarkup: function (markup) {
                    return markup;
                }

            });

        });


    </script>

@endsection

