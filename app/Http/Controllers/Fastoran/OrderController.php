<?php

namespace App\Http\Controllers\Fastoran;

use App\Classes\Utilits;
use App\Enums\DeliveryTypeEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Order;

use App\Parts\Models\Fastoran\OrderDetail;
use App\Parts\Models\Fastoran\RestMenu;
use App\Parts\Models\Fastoran\Restoran;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class OrderController extends Controller
{
    use Utilits;

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


        $user = User::find(auth()->guard('api')->user()->id);

        $order = Order::create($request->all());

        $order->user_id = $user->id;
        $order->latitude = $request->get("receiver_latitude") ?? null;
        $order->longitude = $request->get("receiver_longitude") ?? null;
        $order->save();


        $order_details = $request->get("order_details");

        $delivery_order_tmp = "";
        foreach ($order_details as $od) {
            $detail = OrderDetail::create($od);
            $detail->order_id = $order->id;
            $detail->save();

            $product = RestMenu::find($detail->product_id);
            $local_tmp = sprintf("#%s %s %s шт. %s руб.\n",
                $detail->product_id,
                $product->food_name,
                $detail->count,
                $product->food_price
            );

            $delivery_order_tmp .= $local_tmp;
        }

        $rest = Restoran::find($order->rest_id);

        $channel = $rest->telegram_channel;
        $range = ($this->calculateTheDistance($order->latitude ?? 0, $order->longitude ?? 0, $rest->latitude ?? 0, $rest->longitude ?? 0) / 1000);

        $range1 = $range;
        $range2 = $range + 2;

        $price1 = ceil(env("BASE_DELIVERY_PRICE") + ($range1 * env("BASE_DELIVERY_PRICE_PER_KM")));
        $price2 = ceil(env("BASE_DELIVERY_PRICE") + ($range2 * env("BASE_DELIVERY_PRICE_PER_KM")));

        $deliver_price = ceil(env("BASE_DELIVERY_PRICE") + ($range * env("BASE_DELIVERY_PRICE_PER_KM")));


        $message = sprintf("*Заявка*\nРесторан:_%s_\nФ.И.О.:_%s_\nТелефон:_%s_\nЗаказ:\n%s\nЦена доставки:*%sруб.-%s руб.*(Дистанция:%.2fкм-%.2fкм)\nЦена заказа:*%s руб.*",
            $rest->name,
            $user->name,
            $user->phone,
            $delivery_order_tmp,
            $price1,
            $price2,
            $range1,
            $range2,
            $order->summary_price
        );

        $order->delivery_price = $deliver_price;
        $order->delivery_range = floatval(sprintf("%.2f", $range));

        $order->save();

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

        //todo:проверить работу
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

    public function declineOrderAdmin(Request $request, $orderId)
    {
        $comment = $request->get("comment") ?? "Позиция отсутствует";

        $order = Order::with(["restoran", "user"])
            ->where("id", $orderId)
            ->first();

        $user = User::find($request->user()->id);

        if (is_null($user))
            return response()
                ->json([
                    "message" => "Deliveryman not found!"
                ], 200);

        if (is_null($order))
            return response()
                ->json([
                    "message" => "Order not found!"
                ], 404);

        $order->deliveryman_id = null;
        $order->status = OrderStatusEnum::DeclineByAdmin;
        $order->save();

        $message = sprintf("Заказ *#%s* отклонен!\nКоментарий:%s\nПерезвоните клиенту: %s!",
            $order->id,
            $comment,
            $order->user->phone ?? "Не найден номер телефона"
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
        $orders = Order::with(["details", "restoran", "details.product", "user"])
            ->where("deliveryman_id", $request->user()->id)
            ->get();

        return response()
            ->json([
                "orders" => $orders
            ]);
    }

    public function getOrderById($orderId)
    {
        return Order::with(["restoran", "user", "details", "details.product"])->where("id", $orderId)->first();
    }

    public function testOrder()
    {
        $restorans = Restoran::with(["menus"])->get();

        $user = User::where("phone", "+380713007745")->first();

        // $deliveryman = User::where("user_type", \App\Enums\UserTypeEnum::Deliveryman)->first();

        $phone = $user->phone;

        $lat = 48.006239;
        $lon = 37.805177;


        foreach ($restorans as $rest) {

            $range = ($this->calculateTheDistance($lat, $lon, $rest->latitude, $rest->longitude) / 1000);

            $range1 = $range;
            $range2 = $range + 2;

            $price1 = ceil(env("BASE_DELIVERY_PRICE") + ($range1 * env("BASE_DELIVERY_PRICE_PER_KM")));
            $price2 = ceil(env("BASE_DELIVERY_PRICE") + ($range2 * env("BASE_DELIVERY_PRICE_PER_KM")));


            // Log::info("RANGE=$range "." ЦЕНА:".ceil(env("BASE_DELIVERY_PRICE") + ($range * env("BASE_DELIVERY_PRICE_PER_KM"))));


            $order = Order::create([
                'rest_id' => $rest->id,
                'user_id' => $user->id,
                'deliveryman_id' => null,

                'latitude' => $lat,
                'longitude' => $lon,

                'status' => \App\Enums\OrderStatusEnum::InProcessing,

                'delivery_price' => ceil(env("BASE_DELIVERY_PRICE") + ($range2 * env("BASE_DELIVERY_PRICE_PER_KM"))),
                'delivery_range' => floatval(sprintf("%.2f-%.2f", $range1, $range2)),
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

            $message = sprintf("*Заявка*\nРесторан:_%s_\nФ.И.О.:_%s_\nТелефон:_%s_\nЗаказ:\n%s\nЦена доставки:*%sруб.-%s руб.*(Дистанция:%.2fкм-%.2fкм)\nЦена заказа:*%s руб.*",
                $rest->name,
                $user->name,
                $phone,
                $delivery_order_tmp,
                $price1,
                $price2,
                $range1,
                $range2,
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

    public function setDeliveredStatus(Request $request, $orderId)
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

        $order->status = OrderStatusEnum::Delivered;
        $order->save();

        $message = sprintf("Доставщик *#%s* успешно доставил заказ *#%s*",
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

    public function setCommentToOrder(Request $request, $orderId)
    {
        $order = Order::with(["restoran"])
            ->where("id", $orderId)
            ->first();

        $order->delivery_note = $request->get("comment") ?? '';
        $order->save();

        return response()
            ->json([
                "message" => "Success"
            ], 200);
    }


    public function setDeliverymanType(Request $request, $type)
    {
        $user = User::find($request->user()->id);
        $user->deliveryman_type = $type ?? 0;
        $user->save();

        $deliveryman_status_text = "Не установлен";
        switch ($type)
        {
            case 1: $deliveryman_status_text = "Пеший"; break;
            case 2: $deliveryman_status_text = "Велосипед"; break;
            case 3: $deliveryman_status_text = "Мотоцикл"; break;
            case 4: $deliveryman_status_text = "Машина"; break;
        }

        Telegram::sendMessage([
            'chat_id' => $user->telegram_chat_id,
            'parse_mode' => 'Markdown',
            'text' => "Ваш тип доставки изменен на '$deliveryman_status_text'!",
        ]);

        return response()
            ->json([
                "message" => "Success"
            ], 200);
    }
}
