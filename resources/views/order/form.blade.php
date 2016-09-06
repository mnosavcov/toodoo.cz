@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xs-12 col-xs-offset-0 col-md-8 col-md-offset-2">
                    <h1>Objednávka</h1>
                    <a href="{{ route('account.detail') }}" class="pull-right"><span
                                class="glyphicon glyphicon-arrow-left"></span> zpět na můj účet</a>

                    <p>
                        Zde si můžete objednat více místa pro své soubory.
                    </p>

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('order.save') }}">
                        {{ csrf_field() }}

                        <div class="panel panel-default">
                            <div class="panel-heading">Objednávka</div>

                            <div class="panel-body">
                                <strong>aktuální objednávka:</strong>

                                @if($user->paid_expire_at>time())
                                    Do {{ date('d.m.Y', $user->paid_expire_at) }}
                                    máte objednáno {{ formatBytes($user->ordered_size) }}.
                                    @if($user->renew_active)
                                        Objednávka bude k uvedenému datu obnovena na
                                        další {{ $user->ordered_period=='yearly' ? 'rok' : 'měsíc' }}.
                                    @else
                                        Objednávka nebude obnovena a k uvedenému datu bude ukončena.
                                    @endif
                                @else
                                    nemáte žádnou aktivní objednávku
                                @endif
                                <hr>

                                @for($i=0; $i<count($offer); $i+=2)
                                    <div class="form-group">
                                        <div class="col-md-4 col-md-offset-2">
                                            @include('order.@item', ['item'=>(isset($offer[$i])?$offer[$i]:'')])
                                        </div>
                                        <div class="col-md-4">
                                            @include('order.@item', ['item'=>(isset($offer[$i+1])?$offer[$i+1]:null)])
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Odeslat objednávku
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection