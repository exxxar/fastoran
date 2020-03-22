<?php

namespace App\Http\Controllers\Fastoran;

use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\MenuCategory;
use App\Parts\Models\Fastoran\MenuRubrik;
use Illuminate\Http\Request;

class MenuRubrikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()
            ->json([
                "menu_rubriks"=>MenuRubrik::all()
            ]);
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
     * @param  \App\MenuRubrik  $menuRubrik
     * @return \Illuminate\Http\Response
     */
    public function show(MenuRubrik $menuRubrik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MenuRubrik  $menuRubrik
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuRubrik $menuRubrik)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MenuRubrik  $menuRubrik
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuRubrik $menuRubrik)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MenuRubrik  $menuRubrik
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuRubrik $menuRubrik)
    {
        //
    }
}
