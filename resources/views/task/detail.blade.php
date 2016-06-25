@extends('layouts.app')

@section('content')
    <a href="{{ Route('task.update', ['key'=>$task->key()]) }}" class="pull-right">Update</a>
    task.detail
@endsection