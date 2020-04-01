<?php

namespace App\Http\Controllers\Fastoran;

use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Order;

use App\Parts\Models\Fastoran\OrderDetail;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $orders = Order::orderBy('id', 'DESC')
            ->paginate(15);

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

        $orders = Order::with(["details", "restoran"])
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
}
