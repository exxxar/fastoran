<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Order;
use App\Parts\Models\Fastoran\OrderDetail;

use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $order_details = OrderDetail::orderBy('id', 'DESC')
//            ->paginate(15);

        return view('admin.order_details.index');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = OrderDetail::create($request->all());
        return response()
            ->json([
                'order_detail'=>$result
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function show(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderDetail $orderDetail)
    {
        //
    }
    public function get()
    {
        $order_details = OrderDetail::all();
        $deleted_order_details = OrderDetail::onlyTrashed()->get();
        return response()
            ->json([
                "order_details" => $order_details,
                "deleted_order_details" => $deleted_order_details
            ], 200);
    }
    public function restore($id)
    {
        $order = OrderDetail::onlyTrashed()->where('id', $id)->restore();

        return response()
            ->json([
                "message" => "Заказ восстановлен",
                "status" => 200,
            ]);
    }
}
