@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $question->title }}
                        @foreach($question->topics as $topic)
                            <a class="topic pull-right" href="/topic/{{$topic->id}}">{{$topic->name}}</a>
                        @endforeach
                    </div>
                    <div class="panel-body content">
                        {!! $question->body !!}
                    </div>
                    @if(Auth::check() && Auth::user()->owns($question))
                        <div class="actions panel-footer">
                            <span class="edit"><a href="/questions/{{$question->id}}/edit">编辑</a></span>
                            {!! Form::open(['method'=>'DELETE','url'=>'/questions/'.$question->id,'class'=>'delete-form']) !!}
                                <button class="button is-naked delete-button">
                                    删除
                                </button>
                            {!! Form::close() !!}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{$question->answers_count}}个答案
                    </div>
                    <div class="panel-body">

                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="media-left">
                                    <a href="">
                                        <img width="36" src="{{ $answer->user->avatar }}" alt="{{ $question->user->name }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="/user/{{ $answer->user->name }}">
                                            {{ $answer->user->name }}
                                        </a>
                                    </h4>
                                    {!! $answer ->body !!}
                                </div>
                            </div>
                        @endforeach

                        {!! Form::open(['url'=>'/questions/'.$question->id.'/answer']) !!}
                        <div class="form-group {{ $errors->has('body') ? ' has-error' : '' }}">
                            <!-- 编辑器容器 -->
                            <label for="title">描述</label>
                            <script id="container" name="body"  type="text/plain" >
                                {!! old('body') !!}
                            </script>
                            @if ($errors->has('body'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button class="btn btn-success pull-right" type="submit">提交答案</button>
                        {{--</form>--}}
                        {{ Form::close() }}
                    </div >

                </div>
            </div>
        </div>
    </div>
@section('js')
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container', {
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode:true,
            wordCount:false,
            imagePopup:false,
            autotypeset:{ indent: true,imageBlockLine: 'center' }
        });

        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{csrf_token()}}'); // 设置 CSRF token.
        });
    </script>
@endsection
@endsection
