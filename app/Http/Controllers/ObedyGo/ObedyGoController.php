<?php

namespace App\Http\Controllers\ObedyGo;

use App\Classes\Utilits;
use App\Events\SendSmsEvent;
use App\Http\Controllers\Controller;
use App\ObedyGoCategory;
use App\ObedyGoProduct;
use App\Parts\Models\Fastoran\Restoran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mpdf\Mpdf;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class ObedyGoController extends Controller
{
    use Utilits;

    public function getProductList()
    {
        return response()->json(ObedyGoProduct::all());
    }

    public function getDeliveryRange(Request $request)
    {
        $request->validate([
            'address' => 'required',
        ]);

        $coords = (object)$this->getCoordsByAddress($request->get("address"));

        $range = ($this->calculateTheDistance(
            $coords->latitude,
            $coords->longitude,
            env("OBEDYGO_LATITUDE"),
            env("OBEDYGO_LONGITUDE")));

        $price = $range <= 3 ?
            env("OBEDYGO_BASE_DELIVERY_PRICE") :
            ceil(env("OBEDYGO_BASE_DELIVERY_PRICE") + (($range ) * env("OBEDYGO_BASE_DELIVERY_PRICE_PER_KM")));

        return response()
            ->json([
                "range" => floatval(sprintf("%.2f", ($range <= 2 ? $range : ($range + 2)))),
                "price" => $price,
                "latitude" => $coords->latitude,
                "longitude" => $coords->longitude
            ]);


    }
    public function sendWish(Request $request)

    {
        $request->validate([
            'phone' => "required",
            'email' => "nullable|email",
            "from" => "string|required",
            "message" => "required"
        ]);

        $phone = $request->get("phone") ?? '';
        $email = $request->get("email") ?? '';
        $from = $request->get("from") ?? '';
        $address = $request->get("address") ?? '';
        $message = $request->get("message") ?? '';


        $tmp_message = sprintf("<b>Заявка:</b>\nТелефон: %s\nПочта: %s\nФ.И.О.: %s\nАдресс: %s\nСообщение: %s",
            $phone,
            $email,
            $from,
            $address,
            $message
        );

        $this->sendMessageToTelegramChannel(env("TELEGRAM_FASTORAN_OBEDY_GO_CHANNEL"), $tmp_message);
        if ($request->ajax())
            return response()
                ->json([
                    "message" => "success",
                    "status" => 200
                ]);

        return redirect()
            ->back()
            ->with("message", "Сообщение отправлено!");

    }

    public function sendVoice(Request $request)
    {

        $phone = $request->phone ?? "+380710000000";
        $username = $request->name ?? "-";

        $files = $request->file('files');

        array_map('unlink', glob(storage_path("app/public/uploads/*")));

        if ($request->hasFile('files')) {
            foreach ($files as $file) {
                $name = "record-obedy-" . time() . ".mp3";
                $file->storeAs("/uploads/", $name);
                Telegram::sendAudio([
                    'chat_id' => env("TELEGRAM_FASTORAN_OBEDY_GO_CHANNEL"),
                    "caption" => "<b>Голосовая заявка от пользователя [$username]</b>\nНомер телефона:<i> $phone </i>",
                    'parse_mode' => 'HTML',
                    'audio' => \Telegram\Bot\FileUpload\InputFile::create(storage_path('app/public') . "/uploads/$name"),
                ]);

                Storage::delete("/uploads/$name");
            }
        }


        return "success";
    }

    public function getCategoryList()
    {
        return response()->json(ObedyGoCategory::all());
    }

    public function order(Request $request)
    {

        $request->validate([
            "phone" => "required",
            "name" => "required",
            "address" => "required",
            "delivery_price" => "required",
            "delivery_range" => "required",
            "products" => "required",
        ]);

        $phone = $this->preparePhone($request->get("phone") ?? $request->get("receiver_phone") ?? '+380710000012');

        $name = $request->get("name");
        $address = $request->get("address");
        $message = $request->get("message") ?? '';
        $products = $request->get("products") ?? [];
        $total_weight = $request->get("total_weight") ?? 0;
        $total_price = $request->get("total_price") ?? 0;
        $total_count = $request->get("total_count") ?? 0;
        $delivery_price = $request->get("delivery_price") ?? 0;
        $delivery_range = $request->get("delivery_range") ?? 0;

        $arr = ["Без категории", "Стандарт", "Экспрес", "Премиум", "Собери сам"];
        $tmp = "";
        foreach ($products as $index => $item) {
            $tmp_product = (object)$item["product"];

            $tmp_titles = $tmp_product->title;
            $tmp_weight_str = $tmp_product->weight . "гр ";
            if (count($tmp_product->positions) > 0) {
                $tmp_titles .= " (";
                $tmp_weight_str .= " (";
            }


            foreach ($tmp_product->positions as $index2 => $position) {
                $tmp_position = (object)$position;
                $tmp_titles .= $tmp_position->title;
                $tmp_weight_str .= $tmp_position->weight . "гр";
                if (count($tmp_product->positions) != ($index2 + 1)) {
                    $tmp_titles .= ", ";
                    $tmp_weight_str .= " + ";
                }
            }

            if (count($tmp_product->positions) > 0) {
                $tmp_weight_str .= ")";
                $tmp_titles .= ")";
            }


            if (!$tmp_product->is_week) {
                $day_index = $tmp_product->day_index;

                $today = Carbon::now()->dayOfWeek;

                $order_date = $today >= 5 ? 7 - $today + $day_index : $day_index;

                $order_date = Carbon::now()->addDays($order_date);
                $order_date = ($order_date->day . "-" . $order_date->month . "-" . $order_date->year);
            } else
                $order_date = "Всю следующую неделю";

            if ($tmp_product->addition) {
                $order_date = Carbon::now()->addDays(1);
                $order_date = ($order_date->day . "-" . $order_date->month . "-" . $order_date->year);
            }
            $food_part_id = $tmp_product->food_part_id;

            $tmp .= sprintf("<tr><td>#%s</td> <td>%s<br>Заказ на <strong>%s</strong></td>  <td>%s</td> <td>%s руб.</td> <td> %s ед.</td></tr>",
                ($index + 1),
                ("<strong>" . ($arr[$food_part_id] ?? "Дополнительно") . "</strong>: " . $tmp_titles),
                $order_date,
                $tmp_weight_str,
                $tmp_product->price,
                $item["quantity"]
            );


        }

        $mpdf = new Mpdf();


        $current_date = Carbon::now("+3:00");

        $number = Str::uuid();
        $mpdf->WriteHTML("<h1>Счет на оплату</h1>");
        $mpdf->WriteHTML("<h6>Уникальный идентификатор заказа <strong style='color:darkred'>$number</strong></h6>");
        $mpdf->WriteHTML('<h3>Сервис "ОбедыGO"</h3>');
        $mpdf->WriteHTML('<hr>');
        $mpdf->WriteHTML("<ul>
 <li>Имя заказчика <strong>$name</strong></li>
 <li>Телефон заказчика <strong>$phone</strong></li>
 <li>Адрес заказчика <strong>$address</strong></li>
 <li>Дополнительная информация от заказчика <strong>$message</strong></li>
 <li>Сумма заказа <strong>$total_price руб.</strong></li>
 <li>Масса заказа <strong>$total_weight гр</strong></li>
 <li>Количество позиций в заказе <strong>$total_count ед.</strong></li>
 <li>Бесплатная доставка по Ворошиловскому району</li>
 <li>Минимальный заказ - от <strong>3х</strong> порций</li>
 <li>Дата и время осуществления заказа <strong>$current_date!</strong></li>
</ul>
<hr>
<h3>Ваш заказ состоит из следующих позиций:</h3>
<style>
th:nth-child(1),
td:nth-child(1) {
width: 50px;
}

th:nth-child(2),
td:nth-child(2) {
width: 250px;
}

th:nth-child(3),
td:nth-child(3) {
width: 250px;
}

th:nth-child(4),
td:nth-child(4) {
width: 100px;
}

th:nth-child(5),
td:nth-child(5) {
width: 100px;
}

</style>
");

        $promo_count = round($total_price / 100);
        $code = substr((string)Str::uuid(), 0, 16);
        \App\LotteryPromocode::create([
            'code' => $code,
            'max_activation_count' => $promo_count,
            'current_activation_count' => 0,
        ]);

        $mpdf->WriteHTML("<table>

<tr>
<td><strong>№</strong></td>
<td><strong>Название</strong></td>
<td><strong>Масса, гр</strong></td>
<td><strong>Цена, руб</strong></td>
<td><strong>Колличество, шт</strong></td>
</tr>

$tmp

</table>
<hr>
<h3>Ваш промокод для участия в акциях:</h3>
<p>$code - всего доступно <strong>$promo_count</strong> активаций </p>
<h4>Команда Обеды<span style='color:red'>GO</span> благодарит Вас за использование нашего сервиса! Мы стараемся быть лучше для Вас!</h4>
");
        $file = $mpdf->Output("order-$phone.pdf", \Mpdf\Output\Destination::STRING_RETURN);

        Storage::put("order-$phone.pdf", $file);


        /*  Mail::to()
              ->send(new \App\Mail\CheckMail(storage_path('app\public')."\\codes.pdf"));*/


        Telegram::sendDocument([
            'chat_id' => env("TELEGRAM_FASTORAN_OBEDY_GO_CHANNEL"),
            'document' => InputFile::create(storage_path('app/public') . "/order-$phone.pdf"),
            'parse_mode' => "Markdown",
            'caption' => sprintf((
                "*Заявка ОбедыGO:*\n" .
                "Время заказа: *%s* \n" .
                "Номер телефона: *%s*\n" .
                "Имя покупателя: *%s*\n" .
                "Адрес доставки: *%s*\n" .
                "Сообщение от пользователя: *%s*\n" .
                "Суммарная масса продукции: *%s* гр.\n" .
                "Суммарная цена продукции: *%s* руб.\n" .
                "Суммарное число порций: *%s* ед.".
                "Примерная цена доставки: *%s* руб. (%s км)"

            ),
                $current_date,
                $phone,
                $name,
                $address,
                $message,
                $total_weight,
                $total_price,
                $total_count,
                $delivery_price,
            $delivery_range
            ),
        ]);

        event(new SendSmsEvent($phone, "Мы получили вашу заявку на заказ из сервиса ОбедыGO!"));
        Storage::delete("order-$phone.pdf");
        return $mpdf->Output("order-$phone.pdf", 'I');
        //$this->sendMessageToTelegramChannel(env("TELEGRAM_FASTORAN_ADMIN_CHANNEL"), $message_admin);

    }
}
