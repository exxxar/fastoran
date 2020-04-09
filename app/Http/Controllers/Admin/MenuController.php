<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Kitchen;
use App\Parts\Models\Fastoran\RestMenu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
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
//        $menus = RestMenu::orderBy('id', 'DESC')
//            ->paginate(15);

//        return view('admin.menus.index', compact('menus'))
//            ->with('i', ($request->get('page', 1) - 1) * 15);
        return view('admin.menus.index');
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
        $request->validate([
            'food_name' => 'required',
            'food_remark' => 'required',
            'food_ext' => 'required',
            'food_price' => 'required',
            'rating_id' => 'required',
            'rest_id' => 'required',
            'food_category_id' => 'required',
            'food_img' => 'required',
        ]);

        $menu = RestMenu::create([

            'food_name' => $request->get('food_name') ?? '',
            'food_remark' => $request->get('food_remark') ?? '',
            'food_ext' => $request->get('food_ext') ?? 0,
            'food_price' => $request->get('food_price') ?? 0,
            'rating_id' => $request->get('rating_id') ?? 0,
            'rest_id' => $request->get('rest_id') ?? 0,
            'food_category_id' => $request->get('food_category_id') ?? 0,
            'food_img' => $request->get('food_img') ?? '',

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()
            ->json([
                'status' => 200,
                "message" => "Меню успешно добавлено",
                "menu" => $menu
            ]);

    }

    /**
     * Display the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = RestMenu::where("rest_id", $id)->get();
        return response()->json([
            "menu" => $menu
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(RestMenu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'param' => 'required',
            'value' => 'required',
        ]);

        $param = $request->get("param");
        $value = $request->get("value");

        $menu = RestMenu::find($id);
        $menu[$param] = $value;
        $menu->save();

        return response()
            ->json([
                "message" => "Изменения сохранены",
                "status" => 200
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = RestMenu::find($id);
        $menu->delete();

        return response()
            ->json([
                'status' => 200,
                "message" => "Меню успешно удалено"
            ]);
    }

    public function getMenuByRestId($restId)
    {
        return response()
            ->json([
                "menus" => RestMenu::where("rest_id", $restId)
                    ->get()
            ]);;
    }
    public function get()
    {
        $menus = RestMenu::all();
        $deleted_menus = RestMenu::onlyTrashed()->get();
        return response()
            ->json([
                "menus" => $menus,
                "deleted_menus" => $deleted_menus,
            ], 200);
    }
    public function restore($id)
    {
        $menu = RestMenu::onlyTrashed()->where('id', $id)->restore();

        return response()
            ->json([
                "message" => "Меню восстановлено",
                "status" => 200,
            ]);
    }
}
