@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ Route('project.detail', ['id'=>$project->key]) }}">Detail</a>
            <a href="{{ Route('project.update', ['id'=>$project->key]) }}">Update</a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="row" style="padding-bottom: 8px;">
                <div class="col-sm-12">
                    <div class="label label-default"
                         style="width: auto; display: block; padding: 10px 15px; text-align: left;">todo
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
            <div class="row" style="padding-bottom: 8px;">
                <div class="col-sm-12">
                    <div class="label label-default"
                         style="width: auto; display: block; padding: 10px 15px; text-align: left;">in work
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
            <div class="row" style="padding-bottom: 8px;">
                <div class="col-sm-12">
                    <div class="label label-default"
                         style="width: auto; display: block; padding: 10px 15px; text-align: left;">done / reject
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