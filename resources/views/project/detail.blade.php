@extends('layouts.app')

@section('content')
    <a href="{{ Route('project.update', ['id'=>$project->id]) }}">Update</a>
    @foreach($tasks as $task)
        <div>$task->id</div>
    @endforeach
@endsection