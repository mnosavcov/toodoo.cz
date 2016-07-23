<div class="bs-callout bs-callout{{ $task->priority }}" id="callout-overview-not-both">
    <h4 class="block-with-text">
        <a href="{{ route('task.detail', ['key'=>$task->key()]) }}" style="color: inherit" title="{{ $task->name }}">{{ $task->name }}</a>
    </h4>
    <p class="description">{!! nl2br(linkInText(e($task->description))) !!}</p>
</div>