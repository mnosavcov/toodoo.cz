<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;

use App\Http\Requests;

class PaymentController extends Controller
{
    public function getFio(Request $request)
    {
//        $payments = 'https://www.fio.cz/ib_api/rest/last/'.config('app.fio.token').'/transactions.json'
        $payments = file_get_contents('https://www.fio.cz/ib_api/rest/periods/'.config('app.fio.token').'/2016-08-01/2016-08-31/transactions.json');
        $payments = json_decode($payments, true);
        $transaction_list = $payments['accountStatement']['transactionList'];

        foreach ($transaction_list as $items) {
            $payment = new Payment;
            $payment->payment_data = json_encode($items);
            foreach ($items as $item) {
                foreach ($item as $i) {
                    if($i['name']=='ID pohybu') {
                        $payment->transaction_id = $i['value'];
                        if(Payment::where('transaction_id', $i['value'])->count()) continue 3;
                    }
                    if($i['name']=='Objem') {
                        $payment->paid_amount = $i['value'];
                        $payment->amount_remain = $i['value'];
                    }
                    if($i['name']=='Datum') {
                        $date = new \Carbon\Carbon($i['value']);
                        $payment->paid_at = $date->getTimestamp();
                    }
                }
            }
            $request->user()->payment()->save($payment);
        }
        dd();


        $payments = json_decode($payments);
        dd($payments->transactionList);
    }
}
