<?php

namespace App\Http\Controllers\Fastoran;

use App\Http\Controllers\Controller;

use App\Parts\Models\Fastoran\MenuCategory;
use App\Parts\Models\Fastoran\Region;
use Illuminate\Http\Request;

class MenuCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menu_categories = MenuCategory::orderBy('id', 'DESC')
            ->paginate(15);

        if ($request->ajax())
            return response()
                ->json([
                    'menu_categories' => MenuCategory::all(),
                ]);

        return view('admin.menu_categories.index', compact('menu_categories'))
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
     * @param  \App\MenuCategory  $menuCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuCategory $menuCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MenuCategory  $menuCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuCategory $menuCategory)
    {
        //
    }
}
