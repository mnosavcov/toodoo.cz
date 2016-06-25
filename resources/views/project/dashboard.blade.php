@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="label label-default">todo</div>
                        <a href="{{ Route('task.add', ['key'=>$project->key]) }}" class="no-hover pull-right">
                            New Task&nbsp;<span class="glyphicon glyphicon-plus-sign"></span>
                        </a>
                    </div>
                </div>
            </div>
            @foreach($tasks->where('task_status_id', App\TaskStatus::where('code', 'TODO')->first(['id'])->id) as $task)
                @include('@shared.taskbox')
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
            @foreach($tasks->where('task_status_id', App\TaskStatus::where('code', 'IN-PROGRESS')->first(['id'])->id) as $task)
                @include('@shared.taskbox')
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
            @foreach($tasks->where('task_status_id', App\TaskStatus::where('code', 'DONE')->first(['id'])->id) as $task)
                @include('@shared.taskbox')
            @endforeach

            @foreach($tasks->where('task_status_id', App\TaskStatus::where('code', 'REJECT')->first(['id'])->id) as $task)
                @include('@shared.taskbox')
            @endforeach
        </div>
    </div>
@endsection