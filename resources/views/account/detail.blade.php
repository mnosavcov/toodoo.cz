@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 main">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{ Route('account.edit') }}" class="pull-right"><span
                                    class="glyphicon glyphicon-pencil"></span></a>
                        Můj účet
                    </div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <table class="table table-bordered">
                                    <caption>informace o účtu</caption>
                                    <tbody>
                                    <tr>
                                        <th class="col-xs-4 active">Jméno</th>
                                        <td class="col-xs-8">{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="active">Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="active">Aktivní mailing</th>
                                        <td>
                                            @if($user->mailing_enabled)
                                                <span class="glyphicon glyphicon-ok text-success"></span>
                                            @else
                                                <span class="glyphicon glyphicon-remove text-danger"></span>
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table class="table table-bordered">
                                    <caption>
                                        <a href="{{ Route('account.refresh') }}" class="pull-right"><span
                                                    class="glyphicon glyphicon-refresh"></span></a>
                                        Soubory
                                    </caption>
                                    <tbody>
                                    <tr>
                                        <th class="col-xs-4 active">Místo zdarma</th>
                                        <td class="col-xs-8">{{ formatBytes($user->main_size) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-xs-4 active">Místo koupené</th>
                                        <td class="col-xs-8">
                                            @if($user->purchased_size)
                                                {{ formatBytes($user->purchased_size) }}
                                            @else
                                                -
                                            @endif
                                            @if($user->purchase_expire_at>time())
                                                (platné do: {{ date('d.m.Y', $user->purchase_expire_at) }})
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-xs-4 active">Místo celkem</th>
                                        <td class="col-xs-8 text-danger">
                                            <strong>{{ formatBytes($user->main_size + $user->purchased_size) }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-xs-4 active">Použité místo</th>
                                        <td class="col-xs-8">{{ formatBytes($user->used_size) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-xs-4 active">Zbývá místo</th>
                                        <td class="col-xs-8 text-danger">
                                            <strong>{{ formatBytes($user->free_size) }}</strong></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <p>
                                    <a href="{{ route('account.order.detail') }}">Seznam objednávek</a>
                                </p>
                                <p>
                                    <span class="glyphicon glyphicon-arrow-right text-primary"></span>
                                    <a href="{{ route('account.order.form') }}"><strong>Objednat více místa pro
                                            soubory</strong></a>
                                    <br>
                                    <a href="{{ route('account.invite') }}">Pozvat přátele</a>. získám tak 10MB prostoru
                                    pro své soubory navíc.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection