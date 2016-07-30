<div class="thumbs">
    @foreach($files as $file)
        <a href="{{ Route($type.'.file.get', ['id'=>$file->id, 'name'=>$file->filename]) }}">
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
    @endforeach
</div>