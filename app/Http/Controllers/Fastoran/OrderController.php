<?php

namespace App\Http\Controllers\Fastoran;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Order;

use App\Parts\Models\Fastoran\OrderDetail;
use App\User;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class OrderController extends Controller
{
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
        $orders = Order::with(["details"])
            ->where("deliveryman_id", $request->user()->id)
            ->get();

        return response()
            ->json([
                "orders" => $orders
            ]);
    }
}
