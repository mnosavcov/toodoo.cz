<ul class="thumbs">
    @foreach($files as $file)
        <li>
            <a href="{{ Route($type.'.file.get', ['id'=>$file->id, 'name'=>$file->filename]) }}"
               title="{{ $file->filename }}">
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