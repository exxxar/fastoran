<?php

namespace App\Http\Controllers\Fastoran;

use App\Classes\Utilits;
use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Promocode;
use App\Parts\Models\Fastoran\Promotion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PromocodeController extends Controller
{
    use Utilits;

    public function getPriceByCode(Request $request)
    {
        $request->validate([
            "product_id" => "required",
            "code" => "required|exists:promocodes"
        ],  [
            'product_id.required' => 'Акционный товар не найден!',
            'code.required' => 'Код должен объязательно присутствовать!',
            'code.exists' => 'Такой промокод не существует!',
        ]);


        return response()
            ->json([
                "price" => $this->getPriceWithDiscountByCode($request->code, $request->product_id)
            ]);
    }

    public function generate(Request $request)
    {
        $request->validate([
            "promotion_id" => "required"
        ]);

        $promotion = Promotion::find($request->promotion_id);
        if (is_null($promotion))
            throw new HttpException(404,"Акция по коду не найдена!");

        try {
            $code = substr(md5(random_int(1000000, 9999999)), 0, 12);

            Promocode::create([
                'code' => $code,
                'active' => true,
                'user_id' => null,
                'promotion_id' => $promotion->id,
            ]);
        } catch (\Exception $e) {
        }

        return response()
            ->json([
                "code" => $code
            ]);
    }


}
