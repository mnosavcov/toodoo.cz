@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <h1>Welcome</h1>
                <p>Pro fungování je třeba <a href="{{ url('login') }}">přihlásit se</a></p>

                <p>verze {{ config('app.version') }}</p>

                <p><a href="{{ route('terms-and-conditions') }}">podmínky užití</a></p>
            </div>
        </div>
    </div>
@endsection