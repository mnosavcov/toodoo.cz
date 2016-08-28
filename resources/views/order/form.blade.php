@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Objednávka</div>

                <div class="panel-body">
                    <strong>aktuální objednávka:</strong>

                    @if($user->purchase_expire_at>time())
                        Do {{ date('d.m.Y', $user->purchase_expire_at) }}
                        máte objednáno {{ formatBytes($user->order_size) }}.
                        @if($user->renew_active)
                            Objednávka bude k uvedenému datu obnovena na
                            další {{ $user->order_period=='yearly' ? 'rok' : 'měsíc' }}.
                        @else
                            Objednávka nebude obnovena a k uvedenému datu bude ukončena.
                        @endif


                    @else
                        nemáte žádnou aktivní objednávku
                    @endif
                    <hr>

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('order.save') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-2">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="order_size"
                                               value="500m"{{ old('order_size')=='500m'?' checked="checked"':'' }}>
                                        500MB / Měsíčně
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-2">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="order_size"
                                               value="1000y"{{ old('order_size', '1000y')=='1000y'?' checked="checked"':'' }}>
                                        1GB / Ročně
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="order_size"
                                               value="1000m"{{ old('order_size')=='1000m'?' checked="checked"':'' }}>
                                        1GB / Měsíčně
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-2">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="order_size"
                                               value="2000y"{{ old('order_size')=='2000y'?' checked="checked"':'' }}>
                                        2GB / Ročně
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="order_size"
                                               value="2000m"{{ old('order_size')=='2000m'?' checked="checked"':'' }}>
                                        2GB / Měsíčně
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-2">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="order_size"
                                               value="3000y"{{ old('order_size')=='3000y'?' checked="checked"':'' }}>
                                        3GB / Ročně
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="order_size"
                                               value="3000m"{{ old('order_size')=='3000m'?' checked="checked"':'' }}>
                                        3GB / Měsíčně
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-2">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="order_size"
                                               value="4000y"{{ old('order_size')=='4000y'?' checked="checked"':'' }}>
                                        4GB / Ročně
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="order_size"
                                               value="4000m"{{ old('order_size')=='4000m'?' checked="checked"':'' }}>
                                        4GB / Měsíčně
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-2">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="order_size"
                                               value="5000y"{{ old('order_size')=='5000y'?' checked="checked"':'' }}>
                                        5GB / Ročně
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="order_size"
                                               value="5000m"{{ old('order_size')=='5000m'?' checked="checked"':'' }}>
                                        5GB / Měsíčně
                                    </label>
                                </div>
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