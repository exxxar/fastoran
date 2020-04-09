<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Parts\Models\Fastoran\MenuCategory;

use Carbon\Carbon;
use Illuminate\Http\Request;

class MenuCategoryController extends Controller
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
        return view('admin.menu_categories.index');
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
        $request->validate([
            'name' => 'required',
            'sort' => 'required',
        ]);

        $menu_category = MenuCategory::create([
            'name' => $request->get('name') ?? '',
            'sort' => $request->get('sort') ?? '',
        ]);

        return response()
            ->json([
                'menu_category' => $menu_category,
                "message" => "Категория успешно добавлена"
            ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MenuCategory  $menuCategory
     * @return \Illuminate\Http\Response
     */
    public function show(MenuCategory $menuCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MenuCategory  $menuCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuCategory $menuCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $param = $request->get("param");
        $value = $request->get("value");

        $menuCategory = MenuCategory::find($id);
        $menuCategory[$param] = $value;
        $menuCategory->save();

        return response()
            ->json([
                "message" => "Изменения сохранены",
                "status" => 200
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu_category = MenuCategory::find($id);
        $menu_category->delete();

        return response()
            ->json([
                'status' => 200,
                "message" => "Категория успешно удалена"
            ]);
    }
    public function get()
    {
        $menu_categories = MenuCategory::all();
        $deleted_menu_categories = MenuCategory::onlyTrashed()->get();
        return response()
            ->json([
                "menu_categories" => $menu_categories,
                "deleted_menu_categories" => $deleted_menu_categories
            ], 200);
    }
    public function restore($id)
    {
        $menu_category = MenuCategory::onlyTrashed()->where('id', $id)->restore();

        return response()
            ->json([
                "message" => "Категория восстановлена",
                "status" => 200,
            ]);
    }
}
