<?php


namespace App\Classes;


use Allanvb\LaravelSemysms\Exceptions\SmsNotSentException;
use Allanvb\LaravelSemysms\Facades\SemySMS;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\Laravel\Facades\Telegram;
use Yandex\Geocode\Facades\YandexGeocodeFacade;

trait Utilits
{
    protected $earth_radius = 6372795;

    public function calculateTheDistance($fA, $lA, $fB, $lB)
    {

// перевести координаты в радианы
        $lat1 = $fA * M_PI / 180;
        $lat2 = $fB * M_PI / 180;
        $long1 = $lA * M_PI / 180;
        $long2 = $lB * M_PI / 180;

// косинусы и синусы широт и разницы долгот
        $cl1 = cos($lat1);
        $cl2 = cos($lat2);
        $sl1 = sin($lat1);
        $sl2 = sin($lat2);
        $delta = $long2 - $long1;
        $cdelta = cos($delta);
        $sdelta = sin($delta);

// вычисления длины большого круга
        $y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
        $x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;

//
        $ad = atan2($y, $x);
        $dist = $ad * $this->earth_radius;

        return $dist;
    }

    public function preparePhone($phone)
    {
        $vowels = array("(", ")", "-", " ");
        return str_replace($vowels, "", $phone ?? '');
    }


    public function prepareSub($text)
    {

        $text = str_replace(["\n"], "", $text);

        $text = str_replace(["/"], "\\", $text);

        $start = mb_strpos($text, "выбор:") + 6;
        $end = mb_strpos($text, "Цена:");

        if ($start==0||$end==0)
            return null;

        $res = mb_substr($text, $start, $end - $start);

        $res = explode("\\", $res);

        $food_sub = [];
        foreach ($res as $r)
            array_push($food_sub, ["name" => trim($r)]);

        return count($food_sub)==0?null:json_encode($food_sub);
    }

    public function getUser()
    {

        $id = auth()->guard('api')->user()->id ?? auth()->user()->id ?? null;

        return !is_null($id) ? User::find($id) : null;

    }

    public function doHttpRequest($uri, $params = [])
    {
        try {

            $req = Request::create($uri, 'POST', $params);

            $resp = app()->handle($req);

            return response()
                ->json(json_decode($resp->getContent())
                );

        } catch (\Exception $e) {
            Log::error(sprintf("%s:%s %s",
                $e->getLine(),
                $e->getFile(),
                $e->getMessage()
            ));
        }
    }

    public function sendSms($phone, $message)
    {
        try {
            SemySMS::sendOne([
                'to' => $phone,
                'text' => $message,
                'device_id' => 'active'
            ]);
        } catch (SmsNotSentException $e) {
            Log::error(sprintf("%s:%s %s",
                $e->getLine(),
                $e->getFile(),
                $e->getMessage()
            ));
        }

    }

    public function sendToTelegram($id, $message, $keyboard = [])
    {
        try {
            $this->sendMessageToTelegramChannel($id, $message, $keyboard);
            $this->sendMessageToTelegramChannel(env("TELEGRAM_FASTORAN_ADMIN_CHANNEL"), $message);
        } catch (TelegramResponseException $e) {
            Log::error(sprintf("%s:%s %s",
                $e->getLine(),
                $e->getFile(),
                $e->getMessage()
            ));
        }

    }

    public function prepareNumber($number = 0, $length = 10)
    {
        $tmp = "" . $number;
        while (strlen($tmp) < $length)
            $tmp = "0" . $tmp;

        return $tmp;
    }

    public function getCoordsByAddress($address)
    {
        $data = YandexGeocodeFacade::setQuery($address ?? '')->load();

        $data = $data->getResponse();

        return [
            "latitude" => !is_null($data) ? $data->getLatitude() : 0,
            "longitude" => !is_null($data) ? $data->getLongitude() : 0
        ];
    }

    protected function sendMessageToTelegramChannel($id, $message, $keyboard = [])
    {
        Telegram::sendMessage([
            'chat_id' => $id,
            'parse_mode' => 'Markdown',
            'text' => $message,
            'reply_markup' => json_encode([
                'inline_keyboard' => $keyboard
            ])
        ]);

    }
}
