<?php

namespace App\Http\Controllers\Admin;

use App\Parts\Models\Fastoran\RestMenu;
use Illuminate\Http\Request;
use App\ExcelImport;
use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Kitchen;
use App\Parts\Models\Fastoran\Restoran;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class RestoransController extends Controller
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
        return view('admin.restorans.index');
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
     * @param  \App\Restoran  $restorans
     * @return \Illuminate\Http\Response
     */
    public function show(Restoran $restorans)
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $param = $request->get("param");
        $value = $request->get("value");

        $user = Restoran::find($id);
        $user[$param] = $value;
        $user->save();

        return response()
            ->json([
                "message" => "Изменения сохранены",
            ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $restoran = Restoran::find($id);
        $menu = RestMenu::where("rest_id", $id)->delete();
        $restoran->delete();

        return response()
            ->json([
                "message" => "Ресторан и его меню успешно удалены",
                "status" => 200
            ]);
    }

    public function like(Request $request,$id){

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

    public function dislike($id){
        $rest = Restoran::find($id);
        $rest->rest_antilike+=$rest->rest_like>0?1:0;
        $rest->save();

        return response()
            ->json([
                "message"=>"Success",
                "status"=>200
            ]);
    }

    public function getRestoransByKitchenId($kitchenId){
        $restorans  = Kitchen::with(["restorans"])
            ->where("id",$kitchenId)
            ->first();

        return response()
            ->json([
                'restorans' => $restorans->restorans()->paginate(100),
            ]);
    }

    public function get()
    {
        $restorans = Restoran::all();
        $deleted_restorans = Restoran::onlyTrashed()->get();
        return response()
            ->json([
                "restorans" => $restorans,
                "deleted_restorans" => $deleted_restorans,
            ], 200);
    }

    public function restore($id)
    {
        $restoran = Restoran::onlyTrashed()->where('id', $id)->restore();
        $menu = RestMenu::where("rest_id", $id)->restore();
        return response()
            ->json([
                "message" => "Ресторан и его меню восстановлены",
                "status" => 200,
            ]);
    }

    public function stoplist($id)
    {
        $restoran = Restoran::find($id);
        return view('admin.restorans.stoplist', compact('restoran'));
    }

    public function uploadFile(Request $request) {
        $file = $request->file;
        $filename = $file->getClientOriginalName();

        $path = hash( 'sha256', time());
        $extension = File::extension($file->getClientOriginalName());
        if ($extension == "xlsx" || $extension == "xls")
        {
            $request->validate([
                'file' => 'required'
            ]);

            $pathOne = $request->file('file')->getRealPath();

            try
            {
                Restoran::truncate();
                Excel::import(new ExcelImport, $pathOne);

                return response()->json([
                    'success' => true,
                    'message' => 'Рестораны загружены. Обновляем',
                ], 200);
            }
            catch(\Exception $e)
            {
                return response()->json([
                        'success' => true,
                        'message' => 'Неверные данные в файле',
                    ], 200);
            }
        }
        else
        {
            return response()->json([
                'error' => 'Wrong format'
            ], 500);
        }
    }

    public function getRestorans()
    {
        $restorans = Restoran::all();
        $restorans_options = array();
        foreach ($restorans as $restoran) {
            $option = (object)[];
            $option->value = $restoran->id;
            $option->text = $restoran->name;
            array_push($restorans_options,$option);
        }
        return response()
            ->json([
                "restorans" => $restorans_options,
            ], 200);
    }
}
