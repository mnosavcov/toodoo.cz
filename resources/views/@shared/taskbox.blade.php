<div class="bs-callout bs-callout{{ $task->priority }}" id="callout-overview-not-both">
    <div class="dropdown pull-right">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            <span class="glyphicon glyphicon-option-horizontal"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </a>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{ route('task.update', ['key'=>$task->key()]) }}">
                    <span class="glyphicon glyphicon-pencil"></span>
                    &nbsp;Upravit
                </a>
            </li>
            <li class="dropdown-submenu disabled" disabled="disabled">
                <a href="#" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-paperclip"></span>
                    Soubory
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">přidat funkčnost</a></li>
                </ul>
            </li>

            @if($task->status->code=='TODO')
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'TODO', 'to'=>'IN-PROGRESS']) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;In progress
                    </a>
                </li>
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'TODO', 'to'=>'REJECT']) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Reject
                    </a>
                </li>
            @elseif($task->status->code=='IN-PROGRESS')
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'IN-PROGRESS', 'to'=>'DONE']) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Done
                    </a>
                </li>
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'IN-PROGRESS', 'to'=>'REJECT']) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Reject
                    </a>
                </li>
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'IN-PROGRESS', 'to'=>'TODO']) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Todo
                    </a>
                </li>
            @elseif($task->status->code=='DONE')
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'DONE', 'to'=>'REJECT']) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Reject
                    </a>
                </li>
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'DONE', 'to'=>'TODO']) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Todo
                    </a>
                </li>
            @elseif($task->status->code=='REJECT')
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'REJECT', 'to'=>'TODO']) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Todo
                    </a>
                </li>
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'REJECT', 'to'=>'DELETE']) }}">
                        <span class="glyphicon glyphicon-remove-sign text-danger"></span>
                        <strong class="text-danger">DELETE</strong>
                    </a>
                </li>
            @endif
        </ul>
    </div>
    <h4 class="block-with-text">
        <a href="{{ route('task.detail', ['key'=>$task->key()]) }}" style="color: inherit"
           title="{{ $task->name }}">{{ $task->name }}</a>
    </h4>
    <p class="description">{!! nl2br(linkInText(e($task->description))) !!}</p>
</div>