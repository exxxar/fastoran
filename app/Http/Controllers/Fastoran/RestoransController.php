<?php

namespace App\Http\Controllers\Fastoran;

use App\Enums\FoodStatusEnum;
use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Section;
use App\Parts\Models\Fastoran\MenuCategory;
use App\Parts\Models\Fastoran\RestMenu;
use App\Parts\Models\Fastoran\Restoran;
use Carbon\Carbon;
use http\Env\Response;
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
        $restorans = Restoran::whereNull("parent_id")
            ->orderBy('id', 'DESC')
            ->paginate(50);

        if ($request->ajax())
            return response()
                ->json([
                    'restorans' => $restorans,
                ]);


        return view('admin.restorans.index', compact('restorans'))
            ->with('i', ($request->get('page', 1) - 1) * 50);
    }


    public function cities(Request $request)
    {
        $restorans = Restoran::all()->unique("city");

        $cities = [];
        foreach ($restorans as $rest) {
            $count = Restoran::where("city", $rest->city)->count();
            array_push($cities, ["city" => $rest->city, "count" => $count]);

        }

        if ($request->ajax())
            return response()->json(["cities" => $cities]);

        return view("mobile.pages.cities", ["cities" => json_encode($cities)]);
    }

    public function getRestoransInCityWeb(Request $request, $name)
    {
        $restorans = Restoran::where("city", $name)
            ->get();

        return view("rest-list", compact("restorans"));
    }

    public function getRestoransInCity(Request $request, $name)
    {

        $restorans = Restoran::where("city", $name)
            ->get();

        if ($request->ajax())
            return response()
                ->json([
                    'restorans' => $restorans,
                ]);

        return view("mobile.pages.restorans", compact("restorans"));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Restoran $restorans
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, $domain, $city = null)
    {

        $restoran = is_null($city) ?
            Restoran::where("url", $domain)
                ->first() :
            Restoran::where("url", $domain)
                ->where("city", $city)
                ->first();

        if (is_null($restoran))
            return redirect()->route("mobile.index");


        return view("mobile.pages.restoran-info", compact("restoran"));
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
     * @param \Illuminate\Http\Request $request
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

    public function like(Request $request, $id)
    {

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

    public function dislike($id)
    {
        $rest = Restoran::find($id);
        $rest->rest_antilike += $rest->rest_like > 0 ? 1 : 0;
        $rest->save();

        return response()
            ->json([
                "message" => "Success",
                "status" => 200
            ]);
    }

    public function getRestoransBySectionId($sectionId)
    {
        $restorans = Section::with(["restorans"])
            ->where("id", $sectionId)
            ->first();

        return response()
            ->json([
                'restorans' => $restorans->restorans()->paginate(100),
            ]);
    }

    public function sales()
    {
        $products = RestMenu::where("food_status", FoodStatusEnum::Promotion)->paginate(20);

        return response()
            ->json($products);
    }

    public function sections()
    {
        $sections = Section::all();

        return response()->json($sections);
    }

    public function showSection($id)
    {
        $section = Section::with(["restorans"])->where("id", $id)->first();

        return response()->json($section);
    }
}
