<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use Carbon\Carbon;

use App\Http\Requests;
use App\Order;
use App\Notifications\OrderConfirmation;

class OrderController extends Controller
{
    protected $offer;

    public function __construct()
    {
        $this->middleware('auth');
        $this->offer = config('offer.offer');
    }

    public function form(Request $request)
    {
        $offer = [];

        foreach ($this->offer as $o) {
            $offer[] = $o;
        }

        return view('order.form', ['user' => $request->user(), 'offer' => $offer]);
    }

    public function store(StoreOrderRequest $request)
    {
        $user = $request->user();
        $variable_symbol = max((int)Order::max('variable_symbol'), date('Y000000')) + 1;
        $offer = $this->offer[$request->get('ordered_size')];
        $description = 'Objednávka prostoru o velikosti ' . formatBytes($offer['size']) . ' s ' . ($offer['period'] == 'yearly' ? 'ročním' : 'měsíčním') . ' obnovováním.';

        /* calculate price and time - begin */
        $start_period_at = (new Carbon())->getTimestamp();
        if ($offer['period'] == 'yearly') {
            $finish_period_at = (new Carbon())->addYear()->endOfDay()->getTimestamp();
        } else {
            $finish_period_at = (new Carbon())->addMonth()->endOfDay()->getTimestamp();
        }

        $full_price_time = $finish_period_at - $start_period_at;
        if ((int)$user->paid_expire_at > $finish_period_at) {
            $finish_period_at = $user->paid_expire_at;
        }
        $partial_price_time = $finish_period_at - $start_period_at;

        $price_per_period = $offer['price'];
        if ($partial_price_time > 0) {
            $price_per_period = $offer['price'] * $partial_price_time / $full_price_time;
        }
        $price_per_period = floor(min($price_per_period, $offer['price']));

        $ordered_unpaid_expire_at = (new Carbon())->addDays(10)->endOfDay()->getTimestamp();
        /* calculate price and time - end */

        $paid_size = $user->paid_size;

        $order = new Order();
        if ($offer['size'] > $paid_size) {
            $order->start_period_at = $start_period_at;
            $order->finish_period_at = $finish_period_at;
            $order->paid_period_to_at = $ordered_unpaid_expire_at;
            $order->period = $offer['period'];
            $order->ordered_size = $offer['size'];
            $order->price_per_period = $price_per_period;
            $order->paid_amount_total = 0;
            $order->variable_symbol = $variable_symbol;
            $order->status = 'unpaid';
            $order->description = $description;

            $user->ordered_unpaid_size = $offer['size'];
            $user->ordered_unpaid_expire_at = $ordered_unpaid_expire_at;
            $user->save();
            $user->recalcSize();
        } else {
            $order->start_period_at = $start_period_at;
            $order->finish_period_at = $finish_period_at;
            $order->paid_period_to_at = $finish_period_at;
            $order->period = $offer['period'];
            $order->ordered_size = $offer['size'];
            $order->price_per_period = 0;
            $order->paid_amount_total = 0;
            $order->variable_symbol = $variable_symbol;
            $order->status = 'complete';
            $order->description = $description;

            $user->ordered_unpaid_size = 0;
            $user->ordered_unpaid_expire_at = 0;
            $user->ordered_size = $offer['size'];
            $user->ordered_period = $offer['period'];
            $user->save();
            $user->recalcSize();
        }

        // deleted all previous unpaid orders
        Order::byUserId($user->id)->where('status', 'unpaid')->update(['status' => 'cancelled']);

        $user->order()->save($order);

        $user->notify(new OrderConfirmation($order));

        return redirect()->route('order.list');
    }

    public function orderList(Request $request)
    {
        return view('order.list', ['orders' => Order::byUserId($request->user()->id)->orderBy('id', 'desc')->with('payment')->get()]);
    }
}
