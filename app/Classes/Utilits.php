<?php


namespace App\Classes;


use Allanvb\LaravelSemysms\Facades\SemySMS;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\Laravel\Facades\Telegram;

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

    public function sendSms($phone, $message)
    {
        SemySMS::sendOne([
            'to' => $phone,
            'text' => $message,
            'device_id' => 'active'
        ]);
    }

    public function sendToTelegram($id, $message, $keyboard = [])
    {
        try {
            Telegram::sendMessage([
                'chat_id' => $id,
                'parse_mode' => 'Markdown',
                'text' => $message,
                'reply_markup' => json_encode([
                    'inline_keyboard' => $keyboard
                ])

            ]);
        } catch (TelegramResponseException $e) {
            Log::info($e->getMessage() . " " . $e->getFile() . " " . $e->getLine());
        }

    }
}
