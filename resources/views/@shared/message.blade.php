@if(Session::has('success'))
    <p class="alert alert-info">{{ Session::get('success') }}</p>
@endif