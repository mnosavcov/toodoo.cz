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
                                    </tbody>
                                </table>

                                <table class="table table-bordered">
                                    <caption>
                                        <a href="{{ Route('account.refresh') }}" class="pull-right"><span class="glyphicon glyphicon-refresh"></span></a>
                                        Soubory
                                    </caption>
                                    <tbody>
                                    <tr>
                                        <th class="col-xs-4 active">Místo celkem</th>
                                        <td class="col-xs-8">{{ formatBytes($user->main_size + $user->purchased_size) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-xs-4 active">Použité místo</th>
                                        <td class="col-xs-8">{{ formatBytes($user->used_size) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-xs-4 active">Zbývá místo</th>
                                        <td class="col-xs-8">{{ formatBytes($user->free_size) }}</td>
                                    </tr>
                                    </tbody>
                                </table>

                                <a href="{{ route('account.invite') }}">Pozvat přátele</a>. získám tak 10MB prostoru pro své soubory navíc.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection