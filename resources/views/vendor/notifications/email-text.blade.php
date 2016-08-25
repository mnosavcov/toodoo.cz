@if ($level == 'error')
    Pozor!
@else
    Dobrý den,
@endif
{{-- Intro --}}
{!! $plainText !!}
{{-- Salutation --}}
S pozdravem
tým {{ config('app.name') }}
{{-- Sub Copy --}}
(c) {{ date('Y') }} {{ config('app.name') }} všechna práva vyhrazena.
