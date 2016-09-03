@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading">seznam objednávek</div>
                    <table class="table table-bordered">
                        <tr>
                            <th></th>
                            <th>Objednáno</th>
                            <th>Konec období</th>
                            <th>Platné do</th>
                            <th>VS</th>
                            <th>Cena / Zaplaceno</th>
                            <th>Období</th>
                            <th>Velikost</th>
                            <th>Stav</th>
                        </tr>
                        @foreach($orders as $order)
                            <?php
                            $class = "";
                            if ($order->status == 'complete') $class = "bg-success";
                            if ($order->status == 'cancelled') $class = "bg-danger";
                            ?>
                            <tr class="{{ $class }}">
                                <td>
                                    <a data-toggle="collapse" data-parent="#accordion"
                                       href="#collapse-payment-{{ $order->id }}" role="button" aria-expanded="true"
                                       aria-controls="collapse-payment-{{ $order->id }}"
                                       class="order-list-more collapsed">
                                        <span class="glyphicon glyphicon-collapse-down text-primary"></span>
                                        <span class="glyphicon glyphicon-collapse-up text-primary"></span>
                                    </a>
                                </td>
                                <td>
                                    {{ $order->created_at }}
                                </td>
                                <td>{{ date('d.m.Y', $order->finish_period_at) }}</td>
                                <td>{{ date('d.m.Y', $order->paid_period_to_at) }}</td>
                                <td>{{ $order->variable_symbol }}</td>
                                <td>
                                    {{ $order->price_per_period }},-
                                    /
                                    <strong>{{ $order->paid_amount_total }}</strong>,- Kč
                                </td>
                                <td>@lang('message.order.period.'.$order->period)</td>
                                <td>{{ formatBytes($order->ordered_size) }}</td>
                                <td>@lang('message.order.status.'.$order->status)</td>
                            </tr>
                            <tr>
                                <td colspan="9" class="order-list-detail">
                                    <div id="collapse-payment-{{ $order->id }}" class="collapse"  role="tabpanel">
                                        <div class="order-list-border"></div>
                                        <div>{{ $order->description }}</div>
                                        @forelse ($order->payment as $payment)
                                            <div><strong class="text-success">
                                                    platba ze dne: {{ date('d.m.Y', $payment->paid_at) }};
                                                    VS: {{ $payment->variable_symbol }};
                                                    částka: {{ $payment->paid_amount }}.- Kč
                                                </strong></div>
                                        @empty
                                            <div><strong class="text-danger">nejsou žádné platby</strong></div>
                                        @endforelse
                                        <div class="order-list-border"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    @if(!count($orders))
                        <div class="panel-body">nemáte žádnou objednávku</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#accordion').on('show.bs.collapse', function () {
            $('#accordion .collapse.in').collapse('hide');
        })
    </script>
@endsection


<!-- Default panel contents -->


