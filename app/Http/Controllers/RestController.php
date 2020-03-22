<?php

namespace App\Http\Controllers;

use App\Parts\Models\Fastoran\Kitchen;
use App\Parts\Models\Fastoran\Region;
use App\Parts\Models\Fastoran\Restoran;
use Illuminate\Http\Request;

class RestController extends Controller
{
    //

    public function getMainPage(Request $request)
    {
        $kitchens = Kitchen::where("view", 1)
            ->get();

        $restorans = Restoran::where("moderation", true)
            ->take(12)
            ->skip(0)
            ->get();

        if ($request->ajax())
            return response()
                ->json([
                    'kitchens' => $kitchens,
                    'restorans' => $restorans
                ]);

        return view("main", compact("kitchens", "restorans"));

    }

    public function getRestList(Request $request)
    {
        $restorans = Restoran::with(["region", "kitchens", "menus"])
            ->where("moderation", true)
            ->get();

        if ($request->ajax())
            return response()
                ->json([
                    'restorans' => $restorans,
                    'regions' => Region::all(),
                    'kitchens' => Kitchen::all()
                ]);

        return view("rest-list", compact("restorans"));
    }

    public function getRestListByKitchen(Request $request, $kitchenId)
    {
        $restorans = (Kitchen::with(["restorans"])
            ->where("id", $kitchenId)
            ->get())
            ->restorans()
            ->get();

        if ($request->ajax())
            return response()
                ->json([
                    'restorans' => $restorans
                ]);

        return view("rest-list", compact("restorans"));
    }

    public function getRestByDomain(Request $request, $domain)
    {
        $restoran = Restoran::where("url", $domain)
            ->first();

        if ($request->ajax())
            return response()
                ->json([
                    'restoran' => $restoran
                ]);

        return view("rest", compact("restoran"));
    }
}
