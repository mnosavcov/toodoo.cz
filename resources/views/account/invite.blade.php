@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 main">
                <div class="panel panel-default">
                    <div class="panel-heading">Odeslat pozvánku</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/account/invite') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('mail_text') ? ' has-error' : '' }}">
                                <label for="mail_text" class="col-md-2 control-label">Text</label>

                                <div class="col-md-8">
                                    <textarea id="mail_text" class="form-control" name="mail_text"
                                              rows="10">{{ $mail_text }}</textarea>

                                    @if ($errors->has('mail_text'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('mail_text') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('emails') ? ' has-error' : '' }}">
                                <label for="emails" class="col-md-2 control-label">Emaily <span
                                            class="glyphicon glyphicon-question-sign text-primary" data-toggle="tooltip"
                                            data-placement="bottom" title="více emailů oddělte čárkou"></span></label>

                                <div class="col-md-8">
                                    <input id="emails" type="text" class="form-control" name="emails"
                                           placeholder="více emailů oddělte čárkou">

                                    @if ($errors->has('emails'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('emails') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-2">
                                    <button type="submit" class="btn btn-primary" name="submit" value="send">
                                        <i class="fa fa-btn fa-sign-in"></i> Odeslat pozvánku
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection