@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ Route('admin.refresh') }}" class="pull-right"><span class="glyphicon glyphicon-refresh"></span></a>
            <h1>Admin</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered">
                <tr>
                    <td class="active col-xs-4">Poslední obnovení</td>
                    <td class="col-xs-8">{{ $data['last_refresh'] }}</td>
                </tr>
            </table>
        </div>
    </div>

    <h2>Uživatelé</h2>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered">
                <tr>
                    <td class="active col-xs-4">Počet uživatelů / placených</td>
                    <td class="col-xs-8">{{ $data['users_count'] }} / {{ $data['users_purchased_count'] }}</td>
                </tr>
                <tr>
                    <td class="active col-xs-4">Poslední aktivita / registrace</td>
                    <td class="col-xs-8">{{ $data['users_last_activity_at'] }}
                        / {{ $data['users_last_register_at'] }}</td>
                </tr>
            </table>
        </div>
    </div>

    <h2>FTP</h2>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered">
                @foreach($data['ftp'] as $d)
                    <?php $dd = json_decode($d['data'], true) ?>
                    <tr>
                        <td class="active col-xs-2" rowspan="3"><strong>{{ $dd['name'] }}</strong></td>
                        <td class="active col-xs-4">
                            <strong>Kapacita disku</strong> /
                            <strong>Použito</strong> /
                            <strong>Volné místo</strong>
                        </td>
                        <td class="col-xs-2">{{ $dd['disc_size'] }}</td>
                        <td class="col-xs-2">{{ $dd['used_size'] }}</td>
                        <td class="col-xs-2"><strong class="text-danger">{{ $dd['free_size'] }}</strong></td>
                    </tr>
                    <tr>
                        <td class="active col-xs-4">
                            <strong>Maximální počet souborů</strong> /
                            <strong>Vloženo souborů</strong> /
                            <strong>Zbývá souborů</strong>
                        </td>
                        <td class="col-xs-2">{{ $dd['max_files'] }}</td>
                        <td class="col-xs-2">{{ $dd['uploaded_files'] }}</td>
                        <td class="col-xs-2"><strong class="text-danger">{{ $dd['free_files'] }}</strong></td>
                    </tr>
                    <tr>
                        <td class="active col-xs-2"><strong>Poslední nahraný soubor</strong></td>
                        <td class="col-xs-6" colspan="3">
                            <strong class="text-danger">{{ $dd['last_upload_at'] }}</strong>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <h2>Backup DB</h2>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered">
                <tr>
                    <td class="active col-xs-4">Počet záloh</td>
                    <td class="col-xs-8">{{ $data['backup_db']->count }}</td>
                </tr>
                <tr>
                    <td class="active col-xs-4">Čas nejnovější / nejstarší</td>
                    <td class="col-xs-8">{{ $data['backup_db']->last_backup_at }}</td>
                </tr>
                <tr>
                    <td class="active col-xs-4">Velikost nejnovější / nejstarší</td>
                    <td class="col-xs-8">{{ $data['backup_db']->success }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection