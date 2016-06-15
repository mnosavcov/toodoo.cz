@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <a href="{{ Route('project.detail', ['id'=>$project->key]) }}">Detail</a>
                <a href="{{ Route('project.update', ['id'=>$project->key]) }}">Update</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="label label-default">todo</div>
                    </div>
                </div>
            </div>
            @foreach($tasks as $task)
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $task->name }}</div>
                    <div class="panel-body">{{ $task->description }}</div>
                </div>
                <div class="panel  panel-default">
                    <div class="panel-heading">{{ $task->name }}</div>
                    <div class="panel-body">{{ $task->description }}</div>
                </div>
                <div class="panel  panel-default">
                    <div class="panel-heading">{{ $task->name }}</div>
                    <div class="panel-body">{{ $task->description }}</div>
                </div>
            @endforeach
        </div>
        <div class="col-sm-4">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="label label-default">in progress</div>
                    </div>
                </div>
            </div>
            @foreach($tasks as $task)
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $task->name }}</div>
                    <div class="panel-body">{{ $task->description }}</div>
                </div>
                <div class="panel  panel-default">
                    <div class="panel-heading">{{ $task->name }}</div>
                    <div class="panel-body">{{ $task->description }}</div>
                </div>
                <div class="panel  panel-default">
                    <div class="panel-heading">{{ $task->name }}</div>
                    <div class="panel-body">{{ $task->description }}</div>
                </div>
            @endforeach
        </div>
        <div class="col-sm-4">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="label label-default">done / reject</div>
                    </div>
                </div>
            </div>
            @foreach($tasks as $task)
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $task->name }}</div>
                    <div class="panel-body">{{ $task->description }}</div>
                </div>
                <div class="panel  panel-default">
                    <div class="panel-heading">{{ $task->name }}</div>
                    <div class="panel-body">{{ $task->description }}</div>
                </div>
                <div class="panel  panel-default">
                    <div class="panel-heading">{{ $task->name }}</div>
                    <div class="panel-body">{{ $task->description }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection