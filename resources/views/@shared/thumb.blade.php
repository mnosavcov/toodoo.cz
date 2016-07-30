<div class="thumbs">
    @foreach($files as $file)
        <a href="{{ Route('task.file.download', ['id'=>$file->id, 'name'=>$file->filename]) }}">
            @if($file->thumb)
                <img class="img-thumbnail"
                     src="{{ $file->thumb }}">
            @else
                <div class="img-thumbnail" style="width: 140px; height: 140px;">
                    {{ $file->extname }}
                </div>
            @endif
        </a>
    @endforeach
</div>