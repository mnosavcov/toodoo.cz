@extends('layouts.app')

@section('content')
    <a href="{{ Route('project.detail', ['id'=>$project->key]) }}">Detail</a>
    <a href="{{ Route('project.update', ['id'=>$project->key]) }}">Update</a>

    @foreach($tasks as $task)
        <div>{{ $task->name }}</div>
    @endforeach
@endsection