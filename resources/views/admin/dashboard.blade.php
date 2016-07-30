@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ Route('admin.refresh') }}" class="pull-right"><span class="glyphicon glyphicon-refresh"></span></a>
            <h1>Admin</h1>
        </div>
    </div>

    <div class="row">
        <table class="table table-bordered">
            <tr>
                <td class="active col-xs-4">Poslední obnovení</td>
                <td class="col-xs-8">{{ $data['last_refresh'] }}</td>
            </tr>
        </table>
    </div>

    <h2>Uživatelé</h2>

    <div class="row">
        <table class="table table-bordered">
            <tr>
                <td class="active col-xs-4">Počet uživatelů</td>
                <td class="col-xs-8">{{ $data['users_count'] }}</td>
            </tr>
        </table>
    </div>

    <h2>FTP</h2>

    <div class="row">
        <table class="table table-bordered">
            @foreach($data['ftp'] as $d)
                <?php $dd = json_decode($d['data'], true) ?>
            <tr>
                <td class="active col-xs-4">{{ $dd['name'] }}</td>
                <td class="col-xs-8">{{ $dd['size'] }}</td>
            </tr>
                @endforeach
        </table>
    </div>
@endsection