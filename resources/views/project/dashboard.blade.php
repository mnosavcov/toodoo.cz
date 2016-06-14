@extends('layouts.app')

@section('content')
    <a href="{{ Route('project.detail', ['id'=>$project->id]) }}">Detail</a>
    <a href="{{ Route('project.update', ['id'=>$project->id]) }}">Update</a>

    @foreach($tasks as $task)
        <div>{{ $task->name }}</div>
    @endforeach
@endsection