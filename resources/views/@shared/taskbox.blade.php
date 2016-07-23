<div class="bs-callout bs-callout{{ $task->priority }}" id="callout-overview-not-both">
    <h4>
        <a href="{{ route('task.detail', ['key'=>$task->key()]) }}" style="color: inherit">{{ $task->name }}</a>
    </h4>
    <p>{!! nl2br(linkInText(e($task->description))) !!}</p>
</div>