<?php

namespace App\Http\Controllers\Fastoran;

use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Promocode;
use App\User;
use Illuminate\Http\Request;

class PromocodeController extends Controller
{
    public function getList(Request $request)
    {

    }

    public function generate(Request $request)
    {

    }

    public function duplicate(Request $request)
    {

    }

    public function search(Request $request)
    {
        $request->validate([
            "code" => "required|max:12|min:12"
        ]);

        $code = Promocode::where("code", $request->code)
            ->first();

        return is_null($code) ?
            (
            response()
                ->json([
                    "promocode" => $code
                ])
            ) :
            (
            response()
                ->json([
                    "message" => "Промокод не найден!"
                ], 404)
            );

    }

    public function activate(Request $request)
    {
        $request->validate([
            "code" => "required|max:12|min:12",
            "phone" => "required"
        ]);

        $user = User::where("phone", $request->phone)
            ->first();

        $code = Promocode::where("code", $request->code)
            ->first();


        if ($code->user_id != null)
            return response()
                ->json([
                    "message" => $code->user->id !== $user->id ?
                        "Код уже был ранее активирован другим пользователем" :
                        "Код уже был ранее активирован Вами"
                ]);

        
    }


}
