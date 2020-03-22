<?php

namespace App\Http\Controllers\Fastoran;

use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\MenuRazdel;
use Illuminate\Http\Request;

class MenuRazdelController extends Controller
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
                "menu_razdels"=>MenuRazdel::all()
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
     * @param  \App\MenuRazdel  $menuRazdel
     * @return \Illuminate\Http\Response
     */
    public function show(MenuRazdel $menuRazdel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MenuRazdel  $menuRazdel
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuRazdel $menuRazdel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MenuRazdel  $menuRazdel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuRazdel $menuRazdel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MenuRazdel  $menuRazdel
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuRazdel $menuRazdel)
    {
        //
    }
}
