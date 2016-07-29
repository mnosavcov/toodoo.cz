@extends('layouts.app')

@section('content')
    <a href="{{ Route('task.update', ['key'=>$task->key()]) }}" class="pull-right"><span
                class="glyphicon glyphicon-pencil"></span></a>
    task.detail
    <br>

    @foreach($files as $file)
        <a href="{{ Route('task.file.download', ['id'=>$file->id, 'name'=>$file->filename]) }}">
            @if(starts_with($file->mime_type, 'image/'))
                <img src="{{ Route('task.file.get', ['id'=>$file->id, 'name'=>$file->filename]) }}" width="250"><br>
            @else
                {{ $file->filename }}<br>
            @endif
        </a>
    @endforeach
@endsection