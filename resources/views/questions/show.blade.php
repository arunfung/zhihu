@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
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
                    <div class="actions panel-footer">
                        @if(Auth::check() && Auth::user()->owns($question))
                            <span class="edit"><a href="/questions/{{$question->id}}/edit">编辑</a></span>
                            {!! Form::open(['method'=>'DELETE','url'=>'/questions/'.$question->id,'class'=>'delete-form']) !!}
                                <button class="button is-naked delete-button">
                                    删除
                                </button>
                            {!! Form::close() !!}
                        @endif
                        <comments type="question" model="{{$question->id}}" count="{{$question->comments()->count()}}"></comments>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h2>{{ $question->followers_count }}</h2>
                        <span>关注者</span>
                    </div>
                    <div class="panel-body">
                        @if(Auth::check())
                        {{--<a href="/question/{{$question->id}}/follow" class="btn btn-default {{ Auth::user()->followed($question->id) ? 'btn-success' : '' }}">--}}
                            {{--{{ Auth::user()->followed($question->id) ? '已关注' : '关注' }}--}}
                        {{--</a>--}}
                            <question-follow-button question="{{$question->id}}"></question-follow-button>
                        @else
                            <a href="{{url('login')}}" class="btn btn-default">
                                关注问题
                            </a>
                        @endif

                        <a href="#editor" class="btn btn-primary pull-right">
                            撰写答案
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{$question->answers_count}}个答案
                    </div>
                    <div class="panel-body">
                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="media-left">
                                    <user-vote-button answer="{{$answer->id}}" :count="{{$answer->votes_count}}"></user-vote-button>
                                    {{--<a href="">--}}
                                        {{--<img width="36" src="{{ $answer->user->avatar }}" alt="{{ $question->user->name }}">--}}
                                    {{--</a>--}}
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="/user/{{ $answer->user->name }}">
                                            {{ $answer->user->name }}
                                        </a>
                                    </h4>
                                    {!! $answer ->body !!}
                                </div>
                                <comments type="answer" model="{{$answer->id}}" count="{{$answer->comments()->count()}}"></comments>
                            </div>
                        @endforeach
                        @if(Auth::check())
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
                        @else
                            <a href="{{url('/login')}}" class="btn btn-success btn-block">登录提交答案</a>
                        @endif
                    </div >

                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h5>关于作者</h5>
                    </div>
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img width="36" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="">
                                        {{$question->user->name}}
                                    </a>
                                </h4>
                            </div>
                            <div class="user-statics">
                                <div class="statics-item text-center">
                                    <div class="statics-text">问题</div>
                                    <div class="statics-count">{{$question->user->questions_count}}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">回答</div>
                                    <div class="statics-count">{{$question->user->answers_count}}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">关注者</div>
                                    <div class="statics-count">{{$question->user->followers_count}}</div>
                                </div>
                            </div>
                        </div>
                        @if(Auth::check() && Auth::id() != $question->user_id)
                            <user-follow-button user="{{$question->user_id}}"></user-follow-button>
                            <send-message user="{{$question->user_id}}"></send-message>
                        @elseif(!Auth::check())
                            <a href="{{url('login')}}" class="btn btn-default">
                                关注他
                            </a>
                            <a href="{{url('login')}}" class="btn btn-default pull-right">发送私信</a>
                        @else
                        @endif


                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
