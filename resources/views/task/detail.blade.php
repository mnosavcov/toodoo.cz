@extends('layouts.app')

@section('content')
    <a href="{{ Route('task.update', ['key'=>$task->key()]) }}" class="pull-right"><span
                class="glyphicon glyphicon-pencil"></span></a>
    task.detail
    <br>

    @foreach($files as $file)
        <a href="{{ Route('task.file.get', ['id'=>$file->id, 'name'=>$file->filename]) }}">
            {{ $file->filename }}<br>
        </a>
    @endforeach
@endsection