<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TooDoo.cz</title>

    <link media="all" type="text/css" rel="stylesheet"
          href="{{ asset('/') }}css/bootstrap/bootstrap.min.css?v={{ config('app.version') }}">
    {{-- <link media="all" type="text/css" rel="stylesheet" href="{{ asset('/') }}css/bootstrap/bootstrap-theme.min.css"> --}}
    <link media="all" type="text/css" rel="stylesheet"
          href="{{ asset('/') }}css/bootstrap/dashboard.css?v={{ config('app.version') }}">
    <link media="all" type="text/css" rel="stylesheet"
          href="{{ asset('/') }}css/bootstrap/docs.min.css?v={{ config('app.version') }}">
    <link media="all" type="text/css" rel="stylesheet"
          href="{{ asset('/') }}css/bootstrap/dropdowns-enhancement.css?v={{ config('app.version') }}">
    <link media="all" type="text/css" rel="stylesheet"
          href="{{ asset('/') }}css/main.css?v={{ config('app.version') }}">
    <link media="all" type="text/css" rel="stylesheet"
          href="{{ asset('/') }}css/scrollbar/jquery.mCustomScrollbar.min.css?v={{ config('app.version') }}">
    <script src="{{ asset('/') }}js/jquery/jquery.min.js?v={{ config('app.version') }}"></script>
    <script src="{{ asset('/') }}js/bootstrap/bootstrap.min.js?v={{ config('app.version') }}"></script>
    <script src="{{ asset('/') }}js/bootstrap/dropdowns-enhancement.js?v={{ config('app.version') }}"></script>
    <script src="{{ asset('/') }}js/scrollbar/jquery.mCustomScrollbar.concat.min.js?v={{ config('app.version') }}"></script>
    <script src="{{ asset('/') }}js/main.js?v={{ config('app.version') }}"></script>
</head>
<body id="app-layout">
<div id="no-mobile-element"></div>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-79877449-1', 'auto');
    ga('send', 'pageview');
</script>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                TooDoo.cz
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            @if (Auth::check())
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="visible-xs-inline">menu</span>
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('project.add') }}">
                                    <span class="glyphicon glyphicon-plus-sign"></span>
                                    &nbsp;Nový projekt
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('account.files') }}">
                                    <span class="glyphicon glyphicon-file"></span>
                                    &nbsp;Soubory
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('account.trash') }}">
                                    <span class="glyphicon glyphicon-trash"></span>
                                    &nbsp;Koš
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
        @endif

        <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    @if (Auth::user()->is_admin())
                        <li>
                            <a href="{{ Route('admin.dashboard') }}">
                                <span class="glyphicon glyphicon-cog"></span>
                                <span class="visible-xs-inline-block">admin</span>
                            </a>
                        </li>
                    @endif
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/account') }}"><i class="glyphicon glyphicon-user"></i>&nbsp;My account</a>
                            </li>
                            <li><a href="{{ url('/logout') }}"><i
                                            class="glyphicon glyphicon-log-out"></i>&nbsp;Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@if (Auth::guest())
    @yield('content')
@else
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    @foreach(\App\Project::navList() as $item)
                        <li @if(isset($project->id) && $project->id==$item->id) class="active project-nav-wrap"
                            @else class="project-nav-wrap" @endif style="margin-bottom: 1px;">
                            <a href="#"
                               class="dropdown-toggle pull-right project-nav"
                               title="{{ $item->short }}" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                <span class="sign mobile-hidden caret"></span>
                                <span class="sign mobile-inline-block glyphicon glyphicon-option-horizontal"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('project.detail', ['key'=>$item->key]) }}">
                                        <span class="glyphicon glyphicon-search"></span>
                                        &nbsp;Detail
                                    </a>
                                </li>
                                <li role="separator" class="divider"></li>
                                @if($item->file->count())
                                    @foreach($item->file as $file)
                                        <li class="nav-file">
                                            <a href="{{ Route('project.file.get', ['id'=>$file->id, 'name'=>$file->filename]) }}"
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
                                    <a href="{{ route('project.update', ['key'=>$item->key]) }}">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                        &nbsp;Upravit
                                    </a>
                                </li>
                            </ul>
                            <a href="{{ route('project.dashboard', ['key'=>$item->key]) }}"
                               class="block-with-text priority{{ $item->priority }}"
                               title="{{ $item->short }}">
                                @if(($todocount = $item->todoCount()) | ($inprogresscount = $item->inprogressCount()))
                                    <span class="pull-right">
                                        &nbsp;<span class="badge">
                                            {{ $todocount }}/{{ $inprogresscount }}
                                        </span>
                                    </span>
                                @endif
                                {{ $item->name }}
                            </a>


                            <div class="clearfix"></div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                @include('@shared.message')
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        $('body').addClass('js-enabled');
        if ($('#no-mobile-element').css('display') == 'none') {
            $('body').addClass('mobile-device');
        }
        $(".bs-callout p.description,.acc-files .descr").mCustomScrollbar({
            theme: "dark-3",
            autoHideScrollbar: true,
            scrollButtons: {"enable": true},
            contentTouchScroll: false
        });
    </script>
@endif
</body>
</html>
