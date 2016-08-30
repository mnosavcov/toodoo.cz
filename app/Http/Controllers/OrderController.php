<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use Carbon\Carbon;

use App\Http\Requests;
use App\Order;

class OrderController extends Controller
{
    protected $offer = [
        '500m' => ['size' => 524288000, 'period' => 'monthly', 'price' => 49],
        '1000m' => ['size' => 1073741824, 'period' => 'monthly', 'price' => 59],
        '2000m' => ['size' => 2147483648, 'period' => 'monthly', 'price' => 69],
        '3000m' => ['size' => 3221225472, 'period' => 'monthly', 'price' => 79],
        '4000m' => ['size' => 4294967296, 'period' => 'monthly', 'price' => 89],
        '5000m' => ['size' => 5368709120, 'period' => 'monthly', 'price' => 99],
        '1000y' => ['size' => 1073741824, 'period' => 'yearly', 'price' => 490],
        '2000y' => ['size' => 2147483648, 'period' => 'yearly', 'price' => 590],
        '3000y' => ['size' => 3221225472, 'period' => 'yearly', 'price' => 690],
        '4000y' => ['size' => 4294967296, 'period' => 'yearly', 'price' => 790],
        '5000y' => ['size' => 5368709120, 'period' => 'yearly', 'price' => 890],
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function form(Request $request)
    {
        return view('order.form', ['user' => $request->user()]);
    }

    public function store(StoreOrderRequest $request)
    {
        $h24 = 86400; // 60*60*24 = 1 day
        $user = $request->user();
        $variable_symbol = max((int)Order::max('variable_symbol'), date('Y000000')) + 1;
        $offer = $this->offer[$request->get('ordered_size')];
        $description = 'Objednávka prostoru o velikosti ' . formatBytes($offer['size']) . ' s ' . ($offer['period'] == 'yearly' ? 'ročním' : 'měsíčním') . ' obnovováním.';
        /* calculate price and time - begin */
        $start_period_at = new Carbon();
        $finish_period_at = new Carbon();
        $paid_period_to_at = new Carbon();

        $start_period_at = $start_period_at->getTimestamp();
        if ($offer['period'] == 'yearly') {
            $finish_period_at = $finish_period_at->addYear()->endOfDay()->getTimestamp();
        } else {
            $finish_period_at = $finish_period_at->addMonth()->endOfDay()->getTimestamp();
        }
        $full_price_time = $finish_period_at - $start_period_at;
        if ((int)$user->paid_expire_at - $h24 > $start_period_at) {
            $finish_period_at = $user->paid_expire_at;
        }
        $partial_price_time = $finish_period_at - $start_period_at;
        $paid_period_to_at = $paid_period_to_at->addDays(10)->endOfDay()->getTimestamp();

        $price_per_period = $offer['price'];
        if ($partial_price_time > 0) {
            $price_per_period = $offer['price'] * $partial_price_time / $full_price_time;
        }
        $price_per_period = floor(min($price_per_period, $offer['price']));
        /* calculate price and time - end */

        $order = new Order();
        $order->start_period_at = $start_period_at;
        $order->finish_period_at = $finish_period_at;
        $order->paid_period_to_at = $paid_period_to_at;
        $order->ordered_size = $offer['size'];
        $order->price_per_period = $price_per_period;
        $order->period = $offer['period'];
        $order->variable_symbol = $variable_symbol;
        $order->description = $description;

	    Order::byUserId($user->id)->where('status', 'unpaid')->update(['status'=> 'cancelled']);

        $user->order()->save($order);

        return redirect()->route('order.list');
    }

    public function orderList(Request $request)
    {
        return view('order.list', ['orders' => Order::byUserId($request->user()->id)->orderBy('id', 'desc')->get()]);
    }
}
