@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 main">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="btn-group pull-right" role="group">
                            <a href="{{ Route('account.files', ['order'=>'time']) }}" class="btn btn-default">
                                <span class="glyphicon glyphicon-triangle-bottom"></span>
                                &nbsp;od nejstaršího
                            </a>
                            <a href="{{ Route('account.files', ['order'=>'size']) }}" class="btn btn-default">
                                <span class="glyphicon glyphicon-triangle-bottom"></span>
                                &nbsp;od největšího
                            </a>
                        </div>
                        Soubory
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                @if(!count($files))
                                    nemáte vložené žádné soubory
                                @else
                                    ...soubory...
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection