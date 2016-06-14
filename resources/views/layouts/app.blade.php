<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TooDoo.cz</title>

    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('/') }}css/bootstrap.min.css">
    {{-- <link media="all" type="text/css" rel="stylesheet" href="{{ asset('/') }}css/bootstrap-theme.min.css"> --}}
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('/') }}css/dashboard.css">
    <script src="{{ asset('/') }}js/jquery.min.js"></script>
    <script src="{{ asset('/') }}js/bootstrap.min.js"></script>
</head>
<body id="app-layout">
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
        {{--
        <ul class="nav navbar-nav">
            <li><a href="{{ url('/home') }}">Home</a></li>
        </ul>
        --}}

        <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
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
                    <li><a href="{{ route('project.add') }}">Nový projekt&nbsp;<span
                                    class="glyphicon glyphicon-plus-sign"></span></a></li>
                    @foreach(\App\Project::where('user_id', Auth::user()->id)->orderBy('priority', 'DESC')->orderBy('name', 'ASC')->get() as $item)
                        <li @if(isset($project->id) && $project->id==$item->id) class="active" @endif><a
                                    href="{{ route('project.dashboard', ['id'=>$item->id]) }}"
                                    title="{{ $item->short }}">{{ $item->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                @yield('content')
            </div>
        </div>
    </div>
@endif
</body>
</html>
