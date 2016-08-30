<?php

namespace App\Http\Controllers;

use App\Order;
use App\Payment;
use App\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function getFio(Request $request)
    {
        $payments = file_get_contents('https://www.fio.cz/ib_api/rest/last/' . config('app.fio.token') . '/transactions.json');
        $payments = json_decode($payments, true);
        $transaction_list = $payments['accountStatement']['transactionList']['transaction'];
        if (!count($transaction_list)) return;

        foreach ($transaction_list as $items) {
            $payment = new Payment;
            $payment->payment_data = json_encode($items);
            foreach ($items as $item) {
                if ($item['name'] == 'ID pohybu') {
                    $payment->transaction_id = $item['value'];
                    if (Payment::where('transaction_id', $item['value'])->count()) continue 2;
                }
                if ($item['name'] == 'Objem') {
                    $payment->paid_amount = $item['value'];
                    $payment->amount_remain = $item['value'];
                }
                if ($item['name'] == 'Datum') {
                    $date = new \Carbon\Carbon($item['value']);
                    $payment->paid_at = $date->getTimestamp();
                }
                if ($item['name'] == 'VS') {
                    $payment->variable_symbol = $item['value'];
                }
            }
            if ($payment->variable_symbol) {
                if ($order = Order::where('variable_symbol', $payment->variable_symbol)->first()) {
                    $payment->user_id = $order->user_id;
                }
            }
            $payment->save();
        }
    }

    public function pairing()
    {
        $payment = Payment::where('status', 'incomer')->whereNotNull('user_id')->whereNotNull('variable_symbol')->orderBy('id', 'asc')->first();
        if (!$payment) return;
        $payment->status = 'partly';

        $order = Order::where('variable_symbol', $payment->variable_symbol)->first();
        if ($order) {
            $for_payment = $order->price_per_period - $order->paid_amount_total;
            $paid_amount = $payment->amount_remain;

            if ($for_payment == $paid_amount) {
                $payment->status = 'complete';
                $payment->amount_remain = 0;

                $order->paid_amount_total = $order->price_per_period;
                $order->status = 'complete';
                $order->paid_period_to_at = $order->finish_period_at;
                $order->save();

                $user = User::find($order->user_id);
                if ($user->paid_size < $order->ordered_size) {
                    $user->paid_size = $order->ordered_size;
                }
                if ($user->paid_expire_at < $order->paid_period_to_at) {
                    $user->paid_expire_at = $order->paid_period_to_at;
                }
                if ($user->ordered_size < $order->ordered_size) {
                    $user->ordered_size = $order->ordered_size;
                }
                $user->ordered_period = $order->period;
                $user->renew_active = 1;
                $user->save();
                $user->recalcSize();

                $payment->order()->save($order, [
                    'paid_amount' => $paid_amount,
                    'description' => 'Objednávka VS: ' . $order->variable_symbol
                ]);
            }
        }

        $payment->save();
    }
}
