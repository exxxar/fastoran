<?php

namespace App\Http\Controllers\Fastoran;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Order;

use App\Parts\Models\Fastoran\OrderDetail;
use App\Parts\Models\Fastoran\Restoran;
use App\User;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class OrderController extends Controller
{

    const EARTH_RADIUS =  6372795;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        if ($request->ajax()) {
            $user = User::find(auth()->guard('api')->user()->id ?? 0);

            if (is_null($user))
                return response()
                    ->json([
                        "message" => "User not found",
                        "orders" => [],
                        "status" => 404
                    ]);

            return response()
                ->json([
                    "message" => "Success",
                    'orders' => Order::where("user_id", $user->id)->get(),
                    "status" => 200
                ]);
        }

        $orders = Order::orderBy('id', 'DESC')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'))
            ->with('i', ($request->get('page', 1) - 1) * 15);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $order = Order::create($request->all());
        $order->user_id = auth()->guard('api')->user()->id;
        $order->save();

        $order_details = $request->get("order_details");

        foreach ($order_details as $od) {
            $detail = OrderDetail::create($od);
            $detail->order_id = $order->id;
            $detail->save();
        }

        return response()
            ->json([
                "message" => "success",
                "data" => $request->all(),
                "status" => 200
            ]);
    }

    public function getOrderHistory()
    {
        $user = User::find(auth()->guard('api')->user()->id ?? 0);

        if (is_null($user))
            return response()
                ->json([
                    "message" => "User not found",
                    "orders" => [],
                    "status" => 404
                ]);

        $orders = Order::with(["details", "restoran", "details.product"])
            ->where("user_id", $user->id)
            ->get();

        return response()
            ->json([
                "message" => "success",
                "orders" => $orders,
                "status" => 200
            ]);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function acceptOrder(Request $request, $orderId)
    {
        $order = Order::with(["restoran"])
            ->where("id", $orderId)
            ->first();

        $user = User::find($request->user()->id);

        if (is_null($user))
            return response()
                ->json([
                    "message" => "Deliveryman not found!"
                ], 200);

        if ($user->user_type !== UserTypeEnum::Deliveryman)
            return response()
                ->json([
                    "message" => "You are not deliveryman"
                ], 200);

        if (is_null($order))
            return response()
                ->json([
                    "message" => "Order not found!"
                ], 404);

        if (!is_null($order->deliveryman_id))
            return response()
                ->json([
                    "message" => "Order was already taken!"
                ], 200);

        $order->deliveryman_id = $user->id;
        $order->save();

        $message = sprintf("Заказ *#%s* взят доставщиком *#%s*",
            $order->id,
            $user->id
        );

        Telegram::sendMessage([
            'chat_id' => $order->restoran->telegram_channel,
            'parse_mode' => 'Markdown',
            'text' => $message,
        ]);

        return response()
            ->json([
                "message" => "Success"
            ], 200);
    }

    public function declineOrder(Request $request, $orderId)
    {
        $order = Order::with(["restoran"])
            ->where("id", $orderId)
            ->first();

        $user = User::find($request->user()->id);

        if (is_null($user))
            return response()
                ->json([
                    "message" => "Deliveryman not found!"
                ], 200);

        if ($user->user_type !== UserTypeEnum::Deliveryman)
            return response()
                ->json([
                    "message" => "You are not deliveryman"
                ], 200);

        if (is_null($order))
            return response()
                ->json([
                    "message" => "Order not found!"
                ], 404);

        if ($order->deliveryman_id !== $user->id)
            return response()
                ->json([
                    "message" => "Order linked with another Deliveryman!"
                ], 200);

        $order->deliveryman_id = null;
        $order->save();

        $message = sprintf("Доставщик *#%s* отказался от заказа *#%s*",
            $user->id,
            $order->id
        );

        Telegram::sendMessage([
            'chat_id' => $order->restoran->telegram_channel,
            'parse_mode' => 'Markdown',
            'text' => $message,
        ]);

        return response()
            ->json([
                "message" => "Success"
            ], 200);
    }

    public function getDeliverymanOrders(Request $request)
    {
        $orders = Order::with(["details","restoran"])
            ->where("deliveryman_id", $request->user()->id)
            ->get();

        return response()
            ->json([
                "orders" => $orders
            ]);
    }


    public function testOrder(){
        $restorans = Restoran::with(["menus"])->get();

        $user = User::where("phone", "+380713007745")->first();

        // $deliveryman = User::where("user_type", \App\Enums\UserTypeEnum::Deliveryman)->first();

        $phone = $user->phone;

        $lat = 48.009458;
        $lon = 37.801970;




        foreach ($restorans as $rest) {

            $range =$this->calculateTheDistance($lat,$lon,$rest->latitude, $rest->longitude);

            $order = Order::create([
                'rest_id' => $rest->id,
                'user_id' => $user->id,
                'deliveryman_id' => null,

                'status' => \App\Enums\OrderStatusEnum::InProcessing,

                'delivery_price' => (20 + (10 * 15)),
                'delivery_range' => $range,
                'delivery_note' => "Доставить крабиком",

                'receiver_name' => $user->name,
                'receiver_phone' => $user->phone,

                'receiver_delivery_time' => "18:00",
                'receiver_address' => "г.Донецк, ул. Артема, 2а",
                'receiver_order_note' => "TEST",
                'receiver_domophone' => "0000",

                'created_at' => \Carbon\Carbon::now("+3:00")
            ]);

            $menus = $rest->menus->shuffle();

            $limit = random_int(1, min(count($menus), 10));
            $delivery_order_tmp = "";
            $summ = 0;
            foreach ($menus as $product) {

                $order_detail = OrderDetail::create([
                    'product_id' => $product->id,
                    'count' => 5,
                    'price' => $product->food_price,
                    'order_id' => $order->id
                ]);

                $local_tmp = sprintf("#%s %s %s шт. %s руб.\n",
                    $product->id,
                    $product->food_name,
                    5,
                    $product->food_price
                );

                $summ += $product->food_price * 5;

                $delivery_order_tmp .= $local_tmp;

                $limit--;

                if ($limit === 0)
                    break;
            }

            $channel = $rest->telegram_channel;

            $message = sprintf("*Заявка*\nРесторан:_%s_\nФ.И.О.:_%s_\nТелефон:_%s_\nЗаказ:\n%s\nЦена доставки:*%s руб.*\nЦена заказа:*%s руб.*",
                $rest->name,
                $user->name,
                $phone,
                $delivery_order_tmp,
                $order->delivery_price,
                $summ
            );

            $tmp = "" . $order->id;
            while (strlen($tmp) < 10)
                $tmp = "0" . $tmp;

            Telegram::sendMessage([
                'chat_id' => $channel,
                'parse_mode' => 'Markdown',
                'text' => $message,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ["text" => "Подтвердить заказ!", "url" => "https://t.me/delivery_service_dn_bot?start=001$tmp"],
                            ["text" => "Отменить заказ!", "url" => "https://t.me/delivery_service_dn_bot?start=002$tmp"]
                        ]
                    ]
                ])

            ]);
        }
    }
    protected function calculateTheDistance ($fA, $lA, $fB, $lB) {

// перевести координаты в радианы
        $lat1 = $fA * M_PI / 180;
        $lat2 = $fB * M_PI / 180;
        $long1 = $lA * M_PI / 180;
        $long2 = $lB * M_PI / 180;

// косинусы и синусы широт и разницы долгот
        $cl1 = cos($lat1);
        $cl2 = cos($lat2);
        $sl1 = sin($lat1);
        $sl2 = sin($lat2);
        $delta = $long2 - $long1;
        $cdelta = cos($delta);
        $sdelta = sin($delta);

// вычисления длины большого круга
        $y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
        $x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;

//
        $ad = atan2($y, $x);
        $dist = $ad * self::EARTH_RADIUS;

        return $dist;
    }
}
