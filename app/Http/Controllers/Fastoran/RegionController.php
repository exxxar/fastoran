<?php

namespace App\Http\Controllers\Fastoran;

use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Kitchen;
use App\Parts\Models\Fastoran\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $regions = Region::orderBy('id', 'DESC')
            ->paginate(15);

        if ($request->ajax())
            return response()
                ->json([
                    'regions' => Region::all(),
                ]);

        return view('admin.regions.index', compact('regions'))
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
        $request->validate([
            'name' => 'required',
            'city' => 'required',
        ]);

        Region::create([
            'name' => $request->get('name') ?? '',
            'city' => $request->get('city') ?? 0,
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
            ->route('regions.index')
            ->with('success', 'Регион успешно добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

        $region = Region::find($id);
        $region[$param]=$value;
        $region->save();

        return response()
            ->json([
                "message" => "success",
                "status" => 200
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $region = Region::find($id);
        $region->delete();

        if ($request->ajax())
            return response()
                ->json([
                    'status' => 200,
                    "message" => "Success"
                ]);

        return redirect()
            ->route('regions.index')
            ->with('success', 'Регион успешно удален');
    }
}
