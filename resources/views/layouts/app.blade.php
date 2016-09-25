<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
          content="Webová aplikace pro správu projektů, zaměřená na jednoduché a přehledné ovládání."/>
    <meta name="keywords" content="todo,správa projektů,správa úkolů,CRM"/>

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
          href="{{ asset('/') }}css/scrollbar/jquery.mCustomScrollbar.min.css?v={{ config('app.version') }}">
    <link media="all" type="text/css" rel="stylesheet"
          href="{{ asset('/') }}css/jquery-ui/jquery-ui.min.css?v={{ config('app.version') }}">
    <link media="all" type="text/css" rel="stylesheet"
          href="{{ asset('/') }}css/main.css?v={{ config('app.version') }}">
    <script src="{{ asset('/') }}js/jquery/jquery.min.js?v={{ config('app.version') }}"></script>
    <script src="{{ asset('/') }}js/bootstrap/bootstrap.min.js?v={{ config('app.version') }}"></script>
    <script src="{{ asset('/') }}js/bootstrap/dropdowns-enhancement.js?v={{ config('app.version') }}"></script>
    <script src="{{ asset('/') }}js/scrollbar/jquery.mCustomScrollbar.concat.min.js?v={{ config('app.version') }}"></script>
    <script src="{{ asset('/') }}js/jquery-ui/jquery-ui.min.js?v={{ config('app.version') }}"></script>
    <script src="{{ asset('/') }}js/main.js?v={{ config('app.version') }}"></script>

    <!-- Facebook Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq)return;
            n = f.fbq = function () {
                n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq)f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window,
                document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', '257883844612371');
        fbq('track', "PageView");</script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=257883844612371&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->
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
                    <li><a href="{{ url('/login') }}">Přihlásit</a></li>
                    <li><a href="{{ url('/register') }}">Registrovat</a></li>
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
                            <li><a href="{{ url('/account') }}"><i class="glyphicon glyphicon-user"></i>&nbsp;Můj
                                    účet</a>
                            </li>
                            <li><a href="{{ url('/logout') }}"><i
                                            class="glyphicon glyphicon-log-out"></i>&nbsp;Odhlásit se</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@if (Auth::guest())
    @if(isset($page))
        <div class="container">
            @include('@shared.message')
            @yield('content')
        </div>
    @else
        @include('@shared.message')
        @yield('content')
    @endif
@else
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    @foreach(\App\Project::navList()->get() as $item)
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
                                    <a href="{{ route('project.detail', ['key'=>$item->key, 'owner'=>$item->owner()]) }}">
                                        <span class="glyphicon glyphicon-search"></span>
                                        &nbsp;Detail
                                    </a>
                                </li>
                                <li role="separator" class="divider"></li>
                                @if($item->file->count())
                                    @foreach($item->file as $file)
                                        <li class="nav-file">
                                            <a href="{{ Route('project.file.get', ['id'=>$file->id, 'name'=>$file->filename, 'owner'=>$file->project->owner()]) }}"
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
                                    <a href="{{ route('project.update', ['key'=>$item->key, 'owner'=>$item->owner()]) }}">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                        &nbsp;Upravit
                                    </a>
                                </li>
                            </ul>
                            <a href="{{ route('project.dashboard', ['key'=>$item->key, 'owner' => $item->owner()]) }}"
                               class="block-with-text priority{{ $item->priority }}"
                               title="{{ $item->short }}">
                                @if($item->participant->count())
                                    <span class="glyphicon glyphicon-user text-{{ $item->user->id==Auth::id()?'danger':'info' }}"></span>
                                    &nbsp;
                                @endif
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
                @if(Auth::user()->active==0 || Auth::user()->activation_token)
                    <p class="alert alert-danger">Aktivujte prosím Váš účet. <a
                                href="{{ route('account.reactivate') }}">Znovu odeslat aktivační email</a>.</p>
                @endif
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
@include('@shared.footer')
</body>
</html>
