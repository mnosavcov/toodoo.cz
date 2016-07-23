<div class="bs-callout bs-callout{{ $task->priority }}" id="callout-overview-not-both">
    <div class="navbar-wrap">
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle btn btn-default" data-toggle="dropdown" role="button" aria-expanded="false">
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
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <h4 class="block-with-text">
        <a href="{{ route('task.detail', ['key'=>$task->key()]) }}" style="color: inherit"
           title="{{ $task->name }}">{{ $task->name }}</a>
    </h4>
    <p class="description">{!! nl2br(linkInText(e($task->description))) !!}</p>
</div>