<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Section;
use App\Parts\Models\Fastoran\RestMenu;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KitchenController extends Controller
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
//        $kitchens = Section::orderBy('id', 'DESC')
//            ->paginate(15);

//        return view('admin.kitchens.index', compact('kitchens'))
//            ->with('i', ($request->get('page', 1) - 1) * 15);
        return view('admin.kitchens.index');
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

        $kitchen = Section::create([
            'name' => $request->get('name') ?? '',
            'img' => $request->get('img') ?? '',
            'alt_description' => $request->get('alt_description') ?? '',
            'is_active' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()
            ->json([
                'kitchen' => $kitchen,
                "message" => "Кухня успешно добавлена"
            ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
                "message" => "Изменения сохранены",
                "status" => 200
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kitchen = Section::find($id);
        $kitchen->is_active = 0;
        $kitchen->save();
        $kitchen->delete();

        return response()
            ->json([
                'status' => 200,
                "message" => "Кухня успешно удалена"
            ]);
    }

    public function getMenuByKitchenId($kitchenId)
    {
        return response()
            ->json([
                "menus" => Section::with(["restorans", "restorans.menus"])
                    ->where("id", $kitchenId)
                    ->get()

            ], 200);
    }

    public function get()
    {
        $kitchens = Section::all();
        $deleted_kitchens = Section::onlyTrashed()->get();
        return response()
            ->json([
                "kitchens" => $kitchens,
                "deleted_kitchens" => $deleted_kitchens,
            ], 200);
    }
    public function restore($id)
    {
        $kitchen = Section::onlyTrashed()->where('id', $id)->restore();

        return response()
            ->json([
                "message" => "Кухня восстановлена",
                "status" => 200,
            ]);
    }

}
