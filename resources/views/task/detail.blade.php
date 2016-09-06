@extends('layouts.app')

@section('content')
    <div class="pull-right btn-group">
        <a href="{{ Route('task.update', ['key'=>$task->key()]) }}" type="button" class="btn btn-primary"><span
                    class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;upravit</a>
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
            @if($task->status->code!='TODO')
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>$task->status->code, 'to'=>'TODO']) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Todo
                    </a>
                </li>
            @endif

            @if($task->status->code!='IN-PROGRESS')
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>$task->status->code, 'to'=>'IN-PROGRESS']) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;In progress
                    </a>
                </li>
            @endif

            @if($task->status->code!='DONE')
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>$task->status->code, 'to'=>'DONE']) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Done
                    </a>
                </li>
            @endif

            @if($task->status->code!='REJECT')
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>$task->status->code, 'to'=>'REJECT']) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Rejected
                    </a>
                </li>
            @endif
            <li role="separator" class="divider"></li>
            <li>
                <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>$task->status->code, 'to'=>'DELETE']) }}">
                    <span class="glyphicon glyphicon-remove-sign text-danger"></span>
                    <strong class="text-danger">SMAZAT</strong>
                </a>
            </li>
        </ul>
    </div>



    <h1 class="task-title">{{ $task->name }}&nbsp;<span class="label label-default">{{ $task->status->title }}</span></h1>

    @if(trim($task->description))
        <div class="panel panel-default">
            <div class="panel-heading">Popis úkolu</div>
            <div class="panel-body">
                {!! nl2br(linkInText(e($task->description))) !!}
            </div>
        </div>
    @endif

    @if(trim($task->description_secret) && trim(decrypt($task->description_secret)))
        <div class="panel panel-default">
            <div class="panel-heading">
                Skrytý popis úkolu
                &nbsp;
                <button type="button" class="btn btn-primary" id="btn-description-secret">
                    <span class="glyphicon glyphicon-resize-full"></span>&nbsp;zobrazit
                </button>
            </div>
            <div class="panel-body" id="description-secret">
                {!! nl2br(linkInText(e(decrypt($task->description_secret)))) !!}
            </div>
        </div>
    @endif

    @include('@shared.thumb', ['type'=>'task'])
@endsection