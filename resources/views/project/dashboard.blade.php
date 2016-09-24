@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="label label-default">
                            todo
                            @if($todo->count())
                                &nbsp;({{ $todo->count() }})
                            @endif
                        </div>
                        <a href="{{ Route('task.add', ['key'=>$project->key, 'owner'=>$project->owner()]) }}" class="no-hover pull-right">
                            Nový úkol&nbsp;<span class="glyphicon glyphicon-plus-sign"></span>
                        </a>
                    </div>
                </div>
            </div>
            @foreach($todo as $task)
                @include('@shared.taskbox')
            @endforeach
        </div>
        <div class="col-sm-4">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="label label-default">
                            in progress
                            @if($inProgress->count())
                                &nbsp;({{ $inProgress->count() }})
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @foreach($inProgress as $task)
                @include('@shared.taskbox')
            @endforeach
        </div>
        <div class="col-sm-4">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="label label-default">
                            done
                            @if($done->count())
                                &nbsp;({{ $done->count() }})
                            @endif
                            /
                            reject
                            @if($reject->count())
                                &nbsp;({{ $reject->count() }})
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div  style="opacity: 0.5">
            @foreach($done as $task)
                @include('@shared.taskbox')
            @endforeach
            </div>

            @if($reject->count())
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="label label-default">
                                reject&nbsp;({{ $reject->count() }})
                            </div>
                        </div>
                    </div>
                </div>

                <div  style="opacity: 0.5">
                @foreach($reject as $task)
                    @include('@shared.taskbox')
                @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection