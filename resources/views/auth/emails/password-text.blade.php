@extends('layouts.email-text')

@section('content')
    Na základě Vašeho požadavku Vám zasíláme odkaz pro obnovení hesla.
    Zkopírujte přiložený odkaz do prohlížeče
    {{ url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}
@endsection