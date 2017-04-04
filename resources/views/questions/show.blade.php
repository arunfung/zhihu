@extends('layouts.app')

@section('content')
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
                    <div class="panel-body">
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
        </div>
    </div>
@endsection
