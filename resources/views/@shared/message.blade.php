@if(Session::has('success'))
    <p class="alert alert-info">{{ Session::get('success') }}</p>
@endif

@if(Auth::user() && Auth::user()->free_size<20000000)
    <p class="alert alert-warning">zbývá {{ formatBytes(Auth::user()->free_size) }} volného místa z {{ formatBytes(Auth::user()->main_size + Auth::user()->purchased_size) }} pro vaše soubory</p>
@endif
