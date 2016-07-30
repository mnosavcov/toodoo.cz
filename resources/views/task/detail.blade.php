@extends('layouts.app')

@section('content')
    <a href="{{ Route('task.update', ['key'=>$task->key()]) }}" class="pull-right"><span
                class="glyphicon glyphicon-pencil"></span></a>
    task.detail
    <br>

    @include('@shared.thumb', ['type'=>'task'])
@endsection