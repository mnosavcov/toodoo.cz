<div class="bs-callout bs-callout{{ $task->priority }}" id="callout-overview-not-both">
    <div class="dropdown pull-right">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            <span class="glyphicon glyphicon-option-horizontal"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </a>
        <ul class="dropdown-menu" role="menu">
            @if($task->status->code=='TODO')
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'TODO', 'to'=>'IN-PROGRESS', 'owner'=>$task->project->owner()]) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;In progress
                    </a>
                </li>
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'TODO', 'to'=>'REJECT', 'owner'=>$task->project->owner()]) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Reject
                    </a>
                </li>
            @elseif($task->status->code=='IN-PROGRESS')
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'IN-PROGRESS', 'to'=>'DONE', 'owner'=>$task->project->owner()]) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Done
                    </a>
                </li>
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'IN-PROGRESS', 'to'=>'REJECT', 'owner'=>$task->project->owner()]) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Reject
                    </a>
                </li>
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'IN-PROGRESS', 'to'=>'TODO', 'owner'=>$task->project->owner()]) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Todo
                    </a>
                </li>
            @elseif($task->status->code=='DONE')
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'DONE', 'to'=>'REJECT', 'owner'=>$task->project->owner()]) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Reject
                    </a>
                </li>
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'DONE', 'to'=>'TODO', 'owner'=>$task->project->owner()]) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Todo
                    </a>
                </li>
            @elseif($task->status->code=='REJECT')
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'REJECT', 'to'=>'DONE', 'owner'=>$task->project->owner()]) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Done
                    </a>
                </li>
                <li>
                    <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'REJECT', 'to'=>'TODO', 'owner'=>$task->project->owner()]) }}">
                        <span class="glyphicon glyphicon-transfer"></span>
                        &nbsp;Todo
                    </a>
                </li>
                @if($task->project->user_id==Auth::id())
                    <li>
                        <a href="{{ route('task.status.change', ['key'=>$task->key(), 'from'=>'REJECT', 'to'=>'DELETE', 'owner'=>$task->project->owner()]) }}">
                            <span class="glyphicon glyphicon-remove-sign text-danger"></span>
                            <strong class="text-danger">SMAZAT</strong>
                        </a>
                    </li>
                @endif
            @endif
            <li role="separator" class="divider"></li>
            @if($task->file->count())
                @foreach($task->file as $file)
                    <li class="nav-file">
                        <a href="{{ Route('task.file.get', ['id'=>$file->id, 'name'=>$file->filename]) }}"
                           title="{{ $file->filename }}" target="{{ $file->file_md5 }}"
                           class="item block-with-text">
                            @if($file->thumb)
                                <img class="img-thumbnail-micro"
                                     src="{{ $file->thumb }}">
                            @else
                                <div class="img-thumbnail-micro">
                                    <div class="in">
                                        {{ $file->extname }}
                                    </div>
                                </div>
                            @endif
                            {{ $file->filename }}
                        </a>
                    </li>
                @endforeach
            @else
                <li class="disabled" disabled="disabled">
                    <a href="#" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-paperclip"></span>
                        Žádné přílohy
                    </a>
                </li>
            @endif
            <li role="separator" class="divider"></li>
            <li>
                <a href="{{ route('task.update', ['key'=>$task->key(), 'owner'=>$task->project->owner()]) }}">
                    <span class="glyphicon glyphicon-pencil"></span>
                    &nbsp;Upravit
                </a>
            </li>
        </ul>
    </div>
    <h4 class="block-with-text">
        @if($task->status->code=='REJECT')<strike>@endif
            <a href="{{ route('task.detail', ['key'=>$task->key(), 'owner'=>$task->project->owner()]) }}"
               style="color: inherit"
               title="{{ $task->name }}">{{ $task->name }}
            </a>
            @if($task->status->code=='REJECT')</strike>@endif
    </h4>
    <p class="description">{!! nl2br(linkInText(e($task->description))) !!}</p>
</div>