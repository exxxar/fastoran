<?php

namespace App\Http\Controllers\Fastoran;

use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Section;
use App\Parts\Models\Fastoran\RestMenu;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kitchens = Section::where("is_active", 1)
            ->get();

        if ($request->ajax())
            return response()
                ->json([
                    'kitchens' => $kitchens,
                ]);

        return view('admin.kitchens.index', compact('kitchens'))
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
            'name' => 'required',
            'img' => 'required',
        ]);

        Section::create([
            'name' => $request->get('name') ?? '',
            'img' => $request->get('img') ?? '',
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
            ->route('kitchens.index')
            ->with('success', 'Кухня успешно добавлена');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $section = Section::with(["restorans"])->where("id",$id)->first();

        return view("mobile.pages.section-products",compact("section"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $param = $request->get("param");
        $value = $request->get("value");

        $kitchen = Section::find($id);
        $kitchen[$param] = $value;
        $kitchen->save();

        return response()
            ->json([
                "message" => "success",
                "status" => 200
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $kitchen = Section::find($id);
        $kitchen->delete();

        if ($request->ajax())
            return response()
                ->json([
                    'status' => 200,
                    "message" => "Success"
                ]);

        return redirect()
            ->route('kitchens.index')
            ->with('success', 'Кухня успешно удалена');
    }

    public function getMenuByKitchenId($kitchenId)
    {
        return response()
            ->json([
                "menus" => Section::with(["restorans", "restorans.menus"])
                    ->where("id", $kitchenId)
                    ->get()

            ]);;
    }

}
