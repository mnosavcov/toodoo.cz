@extends('layouts.email')

@section('content')
    Na základě Vašeho požadavku Vám zasíláme odkaz pro obnovení hesla.<br>
    Klikněte na přiložený odkaz:
    <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
@endsection