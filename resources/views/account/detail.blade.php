@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 main">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{ Route('account.edit') }}" class="pull-right"><span
                                    class="glyphicon glyphicon-pencil"></span></a>
                        My account
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection