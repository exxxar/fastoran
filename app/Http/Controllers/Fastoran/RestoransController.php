<?php

namespace App\Http\Controllers\Fastoran;

use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Kitchen;
use App\Parts\Models\Fastoran\Restoran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RestoransController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $restorans = Restoran::orderBy('id', 'DESC')
            ->paginate(50);

        if ($request->ajax())
            return response()
                ->json([
                    'restorans' => $restorans,
                ]);

        return view('admin.restorans.index', compact('restorans'))
            ->with('i', ($request->get('page', 1) - 1) * 50);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Restoran  $restorans
     * @return \Illuminate\Http\Response
     */
    public function show(Restoran $restorans)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Restoran $restorans)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restoran $restorans)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restoran $restorans)
    {
        //
    }

    public function like(Request $request,$id){

     /*   $restLike = RestLike::where("rest_id",$id)->first();

        if (is_null($restLike)) {
            RestLike::create([
                'ip' => $request->ip(),
                'likes' => 1,
                'antilikes' => 0,
                'rest_id' => $id,
                'dat' => Carbon::now("+3:00"),
            ]);
        }
        else {
            $restLike->likes
        }
        $rest = Restoran::find($id);
        $rest->rest_like+=$rest->rest_like>0?1:0;
        $rest->save();

        return response()
            ->json([
                "message"=>"Success",
                "status"=>200
            ]);*/
    }

    public function dislike($id){
        $rest = Restoran::find($id);
        $rest->rest_antilike+=$rest->rest_like>0?1:0;
        $rest->save();

        return response()
            ->json([
                "message"=>"Success",
                "status"=>200
            ]);
    }

    public function getRestoransByKitchenId($kitchenId){
        $restorans  = Kitchen::with(["restorans"])
            ->where("id",$kitchenId)
            ->first();

        return response()
            ->json([
                'restorans' => $restorans->restorans()->paginate(100),
            ]);
    }
}
