@if(Session::has('info'))
    <p class="alert alert-info">{!! nl2br(e(Session::get('info'))) !!}</p>
@endif

@if(Session::has('success'))
    <p class="alert alert-success">{{ Session::get('success') }}</p>
@endif

@if(Session::has('danger'))
    <p class="alert alert-danger">{{ Session::get('danger') }}</p>
@endif

@if(Session::has('warning'))
    <p class="alert alert-warning">{{ Session::get('warning') }}</p>
@endif

@if(Auth::user() && Auth::user()->free_size<20000000)
    <p class="alert alert-warning">
        zbývá {{ formatBytes(Auth::user()->free_size) }} volného místa z {{ formatBytes(Auth::user()->main_size + Auth::user()->paid_size) }} pro vaše soubory.
        <a href="{{ route('order.form') }}">Objednejte si více místa pro soubory</a>
    </p>
@endif
