<?php

namespace App\Http\Controllers;

use App\Order;
use App\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function getFio(Request $request)
    {
        $payments = file_get_contents('https://www.fio.cz/ib_api/rest/last/' . config('app.fio.token') . '/transactions.json');
        $payments = json_decode($payments, true);
        $transaction_list = $payments['accountStatement']['transactionList'];

        foreach ($transaction_list as $items) {
            $payment = new Payment;
            $payment->payment_data = json_encode($items);
            foreach ($items as $item) {
                foreach ($item as $i) {
                    if ($i['name'] == 'ID pohybu') {
                        $payment->transaction_id = $i['value'];
                        if (Payment::where('transaction_id', $i['value'])->count()) continue 3;
                    }
                    if ($i['name'] == 'Objem') {
                        $payment->paid_amount = $i['value'];
                        $payment->amount_remain = $i['value'];
                    }
                    if ($i['name'] == 'Datum') {
                        $date = new \Carbon\Carbon($i['value']);
                        $payment->paid_at = $date->getTimestamp();
                    }
                    if ($i['name'] == 'VS') {
                        $payment->variable_symbol = $i['value'];
                    }
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
}
