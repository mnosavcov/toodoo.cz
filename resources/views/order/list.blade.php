@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">seznam objednávek</div>
                <table class="table table-bordered">
                    <tr>
                        <th>Objednáno</th>
                        <th>Konec období</th>
                        <th>Platné do</th>
                        <th>VS</th>
                        <th>Cena / Zaplaceno</th>
                        <th>Období</th>
                        <th>Velikost</th>
                        <th>Stav</th>
                        <th>Akce</th>
                    </tr>
                    @foreach($orders as $order)
                        <?php
                        $class = "";
                        if ($order->status == 'complete') $class = "bg-success";
                        if ($order->status == 'cancelled') $class = "bg-danger";
                        ?>
                        <tr class="bg-primary">
                            <td colspan="9"><strong>{{ $order->description }}</strong></td>
                        </tr>
                        <tr class="{{ $class }}">
                            <td>{{ $order->created_at }}</td>
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
                            <td>platby</td>
                        </tr>
                    @endforeach
                </table>
                @if(!count($orders))
                    <div class="panel-body">nemáte žádnou objednávku</div>
                @endif
            </div>
        </div>
    </div>
@endsection


<!-- Default panel contents -->


