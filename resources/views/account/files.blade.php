@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 main">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="btn-group pull-right" role="group">
                            <a href="{{ Route('account.files', ['order'=>'time']) }}"
                               class="btn btn-default{{$order=='time'?' disabled':''}}">
                                <span class="glyphicon glyphicon-triangle-bottom"></span>
                                &nbsp;od nejstaršího
                            </a>
                            <a href="{{ Route('account.files', ['order'=>'size']) }}"
                               class="btn btn-default{{$order=='size'?' disabled':''}}">
                                <span class="glyphicon glyphicon-triangle-bottom"></span>
                                &nbsp;od největšího
                            </a>
                        </div>
                        Soubory
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            @if(!count($files))
                                <div class="row">
                                    nemáte vložené žádné soubory
                                </div>
                            @else
                                <ul class="thumbs acc-files">
                                    @foreach($files as $file)
                                        <li class="col-xs-12 col-md-6">
                                            <ul class="js-hide menu">
                                                <li>
                                                    <a href="{{ Route($file['type'].'.file.download', ['id'=>$file['file_id'], 'name'=>$file['file_filename']]) }}"
                                                       title="download">
                                                        <span class="glyphicon glyphicon-download"></span>
                                                    </a>
                                                </li>
                                                <li class="pull-left"><a
                                                            href="javascript:void(0);"
                                                            title="odstranit"
                                                            onclick="location_confirm('opravdu smazat soubor?', '{{ Route($file['type'].'.file.delete', ['id'=>$file['file_id'], 'name'=>$file['file_filename']]) }}')">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </a></li>
                                            </ul>
                                            <div class="pull-left">
                                                <a href="{{ Route($file['type'].'.file.get', ['id'=>$file['file_id'], 'name'=>$file['file_filename']]) }}"
                                                   title="{{ $file['file_filename'] }}" target="{{ $file['file_md5'] }}"
                                                   class="item">
                                                    @if($file['file_thumb'])
                                                        <img class="img-thumbnail"
                                                             src="{{ $file['file_thumb'] }}">
                                                    @else
                                                        <div class="img-thumbnail">
                                                            <div class="in">
                                                                {{ $file['file_extname'] }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </a>
                                                <div class="filename block-with-text"
                                                     title="{{ $file['file_filename'] }}">{{ $file['file_filename'] }}</div>
                                                <div class="info">
                                                    <div class="date">{{ date('d.m.Y H:i', $file['file_created_at']) }}</div>
                                                    <div class="size">{{ formatBytes($file['file_filesize']) }}</div>
                                                </div>
                                            </div>
                                            <div class="description col-xs-12 col-md-6 col-lg-8">
                                                @if($file['trashed'])
                                                    &nbsp;<span class="label label-danger">ODSTRANĚNÝ</span>
                                                @endif
                                                <span class="label label-default">
                                                    @if($file['type']=='task')
                                                        úkol
                                                    @else
                                                        projekt
                                                    @endif
                                                </span>
                                                <h2 class="block-with-text">
                                                    @if($file['type']=='task')
                                                        <a href="{{ route('task.detail', ['key'=>$file['key']]) }}">
                                                            @else
                                                                <a href="{{ route('project.detail', ['key'=>$file['key']]) }}">
                                                                    @endif
                                                                    {{ $file['title'] }}
                                                                </a>
                                                </h2>
                                                <div class="clearfix"></div>
                                                <div class="descr">{!! nl2br(linkInText(e($file['description']))) !!}</div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <div class="clearfix"></div>
                            {{ $link }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('ul.thumbs a.item, ul.thumbs .menu').hover(function () {
            $(this).closest('li').find('.menu').stop().fadeIn(150);
        }, function () {
            $(this).closest('li').find('.menu').stop().fadeOut();
        })
    </script>
@endsection