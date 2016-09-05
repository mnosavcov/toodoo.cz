@extends('layouts.app')

@section('content')
    <div id="hp">
        <div class="container-fluid bg-primary">
            <div class="container">
                <div class="row row-top">
                    <div class="col-xs-12 col-sm-6 img-wrap">
                        <img src="/img/hp01.png" class="img01">
                        <h3 class="text-">Nápad nemusíte držet v hlavě...</h3>
                    </div>
                    <div class="col-xs-12 col-sm-6 img-wrap">
                        <img src="/img/hp02.png" class="img02">
                        <h3 class="text-">...uložíte jej do systému...</h3>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row row-bottom">
                        <div class="col-xs-12 col-sm-6 img-wrap">
                            <img src="/img/hp03.png" class="img03">
                            <h3 class="text-">...a pracujete v klidu na projektech...</h3>
                        </div>
                        <div class="col-xs-12 col-sm-6 img-wrap">
                            <img src="/img/hp04.png" class="img04">
                            <h3 class="text-">...dokud nemáte hotovo</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row row-button">
                <div class="col-sm-3 col-sm-offset-2 col-xs-12">
                        <a href="{{ url('register') }}" class="btn btn-primary btn-block btn-lg">Registrovat</a>
                </div>
                <div class="visible-xs-block">&nbsp;</div>
                <div class="col-sm-3 col-sm-offset-2 col-xs-12">
                    <a href="{{ url('login') }}" class="btn btn-default btn-block btn-lg">Přihlásit</a>
                </div>
            </div>
        </div>
    </div>
@endsection