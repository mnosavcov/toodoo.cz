<ul class="thumbs">
    @foreach($files as $file)
        <li>
            <ul class="js-hide menu">
                <li>
                    <a href="{{ Route($type.'.file.download', ['id'=>$file->id, 'name'=>$file->filename, 'owner'=>$file->task->project->owner()]) }}"
                       title="download">
                        <span class="glyphicon glyphicon-download"></span>
                    </a>
                </li>
                @if($file->task->project->user_id==Auth::id())
                    <li class="pull-left"><a
                                href="javascript:void(0);"
                                title="odstranit"
                                onclick="location_confirm('opravdu smazat soubor?', '{{ Route($type.'.file.delete', ['id'=>$file->id, 'name'=>$file->filename]) }}')">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a></li>
                @endif
            </ul>
            <a href="{{ Route($type.'.file.get', ['id'=>$file->id, 'name'=>$file->filename, 'owner'=>$file->task->project->owner()]) }}"
               title="{{ $file->filename }}" target="{{ $file->file_md5 }}" class="item">
                @if($file->thumb)
                    <img class="img-thumbnail"
                         src="{{ $file->thumb }}">
                @else
                    <div class="img-thumbnail">
                        <div class="in">
                            {{ $file->extname }}
                        </div>
                    </div>
                @endif
            </a>
            <div class="filename block-with-text">{{ $file->filename }}</div>
            <div class="info">
                <div class="size pull-right">{{ formatBytes($file->filesize) }}</div>
                <div class="date pull-left">{{ date('d.m.Y H:i', $file->created_at->timestamp) }}</div>
            </div>
        </li>
    @endforeach
</ul>
<div class="clearfix"></div>
<script>
    $('ul.thumbs a.item, ul.thumbs .menu').hover(function () {
        $(this).parent().find('.menu').stop().fadeIn(150);
    }, function () {
        $(this).parent().find('.menu').stop().fadeOut();
    })
</script>