<?php

namespace App\Http\Controllers\Fastoran;

use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Section;
use App\Parts\Models\Fastoran\MenuCategory;
use App\Parts\Models\Fastoran\RestMenu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menus = RestMenu::orderBy('id', 'DESC')
            ->paginate(15);

        if ($request->ajax())
            return response()
                ->json([
                    'menus' => RestMenu::all(),
                ]);

        return view('admin.menus.index', compact('menus'))
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
        $request->validate([
            'food_name' => 'required',
            'food_remark' => 'required',
            'food_ext' => 'required',
            'food_price' => 'required',
            'food_rubr_id' => 'required',
            'food_razdel_id' => 'required',
            'rest_id' => 'required',
            'food_category_id' => 'required',
            'food_img' => 'required',
            'bonus' => 'required',
        ]);

        RestMenu::create([

            'food_name' => $request->get('food_name') ?? '',
            'food_remark' => $request->get('food_remark') ?? '',
            'food_ext' => $request->get('food_ext') ?? 0,
            'food_price' => $request->get('food_price') ?? 0,
            'food_rubr_id' => $request->get('food_rubr_id') ?? 0,
            'food_razdel_id' => $request->get('food_razdel_id') ?? 0,
            'rest_id' => $request->get('rest_id') ?? 0,
            'food_category_id' => $request->get('food_category_id') ?? 0,
            'food_img' => $request->get('food_img') ?? '',
            'bonus' => $request->get('bonus') ?? 0,

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($request->ajax())
            return response()
                ->json([
                    'status' => 200,
                    "message" => "Success"
                ]);

        return redirect()
            ->route('menus.index')
            ->with('success', 'Меню успешно добавлено');
    }

    /**
     * Display the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $menu = MenuCategory::all();

        $tmp_menu = [];

        foreach ($menu as $item) {
            $tmp = $item->getFilteredMenu($id);
            if (count($tmp) > 0) {
                $menus = [];

                foreach ($tmp as $m){
                    array_push($menus,$m);
                }
                $tmp_item = [
                    "title" => $item->name,
                    "alias"=>$item->alias,
                    "menus" => $menus
                ];
                array_push($tmp_menu, $tmp_item);
            }

        }

        // $menu = RestMenu::where("rest_id", $id)->get();
        return response()->json([
            "menu_items" =>  $tmp_menu
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
     * @param \App\Menu $menu
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
                "message" => "success",
                "status" => 200
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $menu = RestMenu::find($id);
        $menu->delete();

        if ($request->ajax())
            return response()
                ->json([
                    'status' => 200,
                    "message" => "Success"
                ]);

        return redirect()
            ->route('menus.index')
            ->with('success', 'Меню успешно удалено');
    }

    public function getMenuByRestId($restId)
    {
        return response()
            ->json([
                "menus" => RestMenu::where("rest_id", $restId)
                    ->get()
            ]);;
    }
}
