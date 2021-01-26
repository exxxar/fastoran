<?php


namespace App\Conversations;


use App\BotUserInfo;

use App\Enums\OrderStatusEnum;
use App\Enums\UserTypeEnum;
use App\Events\SendSmsEvent;
use App\Parts\Models\Fastoran\Order;
use App\Parts\Models\Fastoran\Restoran;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mpdf\Mpdf;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;


class SuperadminConversation extends Conversation
{

    public static function generatePdf($bot)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $mpdf = new Mpdf();

        $current_date = Carbon::now("+3:00");

        $orders = Order::with(["details", "restoran", "details.product", "user", "deliveryman"])
            ->where('created_at', '>', Carbon::now("+3:00")->subDay())
            ->orderBy("rest_id", "ASC")
            ->get();


        if (count($orders) == 0) {
            $bot->reply("Список заказов пуст!");
            return;
        }

        $order_status_arr = ["В процессе", "Взят рестораном", "Взят доставщиком", "Доставлено", "Отменено админом", "В очереди"];

        $tmp = "";
        $prev_rest_id = $orders[0]->rest_id;
        $local_rest_order_price = 0;
        $local_rest_delivery_price = 0;

        $summary_orders = 0;
        $summary_delivery = 0;
        foreach ($orders as $key => $order) {

            $bot_user = !is_null($order->deliveryman) ?
                BotUserInfo::where("chat_id", $order->deliveryman->telegram_chat_id)->first() :
                null;

            if ($prev_rest_id != $order->rest_id) {
                $prev_rest_id = $order->rest_id;
                $tmp .= sprintf("<tr>
<td colspan='3'>
Сумма с заказов: %s руб
</td>
<td colspan='3'>
Сумма за доставку: %s руб
</td>
</tr>", $local_rest_order_price, $local_rest_delivery_price);

                $tmp .= "<tr style='background-color: #00a8e6;'>
<td colspan='6'></td>
</tr>";

                $local_rest_order_price = 0;
                $local_rest_delivery_price = 0;
            }

            $tmp .= sprintf("
            <tr>
<td>%s</td>
<td>%s</td>
<td>%s</td>
<td>%s руб</td>
<td>%s руб</td>
<td>%s</td>
</tr>
",
                $order->id,
                ($order->restoran->name ?? "не указано"),
                ($order_status_arr[$order->status->value] ?? $order->status->value ?? "Ошибка"),
                ($order->changed_summary_price ?? $order->summary_price ?? "не указано"),
                ($order->changed_delivery_price ?? $order->delivery_price ?? "не указано"),
                ($bot_user->phone ??
                    $bot_user->fio ??
                    $bot_user->account_name ??
                    $order->deliveryman->phone ??
                    $order->deliveryman->telegram_chat_id ??
                    $order->deliveryman->id
                    ?? "не указано")
            );


            $local_rest_order_price += ($order->changed_summary_price ?? $order->summary_price ?? 0);
            $local_rest_delivery_price += ($order->changed_delivery_price ?? $order->delivery_price ?? 0);

            $summary_orders += ($order->changed_summary_price ?? $order->summary_price ?? 0);
            $summary_delivery += ($order->changed_delivery_price ?? $order->delivery_price ?? 0);


        }


        $mpdf->WriteHTML("<h1>Сводка за день (сгенерировано $current_date )</h1>");

        $mpdf->WriteHTML("<table>

<tr>
<td><strong>№ заказа</strong></td>
<td><strong>Ресторан</strong></td>
<td><strong>Статус</strong></td>
<td><strong>Цена заказа</strong></td>
<td><strong>Цена доставки</strong></td>
<td><strong>Доставщик</strong></td>
</tr>

$tmp

</table>
");

        $mpdf->WriteHTML(sprintf("<hr>
<p>Всего заказов за день: %s</p>
<p>Сумма заказов: %s руб.</p>
<p>Сумма доставки: %s руб.</p>
",
            count($orders),
            $summary_orders,
            $summary_delivery
        ));
        $file = $mpdf->Output("order-list.pdf", \Mpdf\Output\Destination::STRING_RETURN);

        Storage::put("order-list.pdf", $file);

        $bot->sendDocument(
            "Сводная статистика за $current_date",
            InputFile::create(storage_path('app/public') . "/order-list.pdf")
        );


    }

    public static function refreshAllKeywords($bot)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $mpdf = new Mpdf();

        $current_date = Carbon::now("+3:00");

        $restorans = Restoran::all();
        $mpdf->WriteHTML("<h1>Список ключей заведений (сгенерировано $current_date)</h1><table>");
        $mpdf->WriteHTML("<tr><td>Ресторан</td><td>Город</td><td>Ключ</td></tr>");
        foreach ($restorans as $rest) {

            $keyword = substr(Str::uuid(), 0, 8);

            $rest->keyword = $keyword;
            $rest->save();


            $mpdf->WriteHTML(sprintf("<tr><td>%s</td><td>%s</td><td><strong>%s</strong></td></tr>", $rest->name, $rest->city,$keyword));
        }


        $keyword = substr(Str::uuid(), 0, 8);

        Storage::put('deliveryman.json', json_encode([
            "keyword" => $keyword
        ]));

        config(['app.deliveryman_keyword' => $keyword]);

        $mpdf->WriteHTML("<tr style='background-color: #00a8e6;'>
<td colspan='3'></td>
</tr>");
        $mpdf->WriteHTML(sprintf("<tr><td td colspan='2'>Доставка</td><td><strong>%s</strong></td></tr>", $keyword));
        $mpdf->WriteHTML("</table>");

        $file = $mpdf->Output("keywords-list.pdf", \Mpdf\Output\Destination::STRING_RETURN);

        Storage::put("keywords-list.pdf", $file);

        $bot->sendDocument(
            "Ключи заведений за $current_date",
            InputFile::create(storage_path('app/public') . "/keywords-list.pdf")
        );

        $bot->getMainMenu("Все ключи обновлены");
    }

    public static function allDayOrders($bot)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $orders = Order::with(["details", "restoran", "details.product", "user", "deliveryman"])
            ->where('created_at', '>', Carbon::now("+3:00")->subDay())
            ->orderBy("rest_id", "ASC")
            ->get();

        $bot->editReplyKeyboard();

        if (count($orders) == 0) {
            $bot->reply("Список заказов пуст!");
            return;
        }

        $summary_orders = 0;
        $summary_delivery = 0;

        foreach ($orders as $key => $order) {


            $bot_user = !is_null($order->deliveryman) ?
                BotUserInfo::where("chat_id", $order->deliveryman->telegram_chat_id)->first() :
                null;

            $message = sprintf("*Заявка #%s*, цена заказа *%s руб*, цена доставки *%s руб*, ресторан *%s*, доставщик *%s*",
                $order->id,
                ($order->changed_summary_price ?? $order->summary_price ?? "не указано"),
                ($order->changed_delivery_price ?? $order->delivery_price ?? "не указано"),
                ($order->restoran->name ?? "не указано"),
                ($bot_user->phone ??
                    $bot_user->fio ??
                    $bot_user->account_name ??
                    $order->deliveryman->phone ??
                    $order->deliveryman->telegram_chat_id ??
                    $order->deliveryman->id
                    ?? "не указано")
            );

            $summary_orders += ($order->changed_summary_price ?? $order->summary_price ?? 0);
            $summary_delivery += ($order->changed_delivery_price ?? $order->delivery_price ?? 0);

            $keyboard = [

                [

                    ["text" => "Цена заказа", "callback_data" => "/change_summary_price " . ($order->id)],
                    ["text" => "Цена доставки", "callback_data" => "/change_delivery_price " . ($order->id)],

                ]

            ];


            $bot->reply(
                $message,
                $keyboard
            );


        }

        $bot->reply(sprintf("Всего заказов за день: *%s заказов*\nСумма заказов: *%s руб*\nСумма доставки: *%s руб*",
            count($orders),
            $summary_orders,
            $summary_delivery
        ));
    }

    public static function deliverymanList($bot)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $bot_users = BotUserInfo::with(["rest"])->where("user_type", UserTypeEnum::Deliveryman)
            ->get();

        if (count($bot_users) == 0) {
            $bot->reply("Доставщиков не обнаружено.");
            return;
        }

        $user_type_array = ["Гость", "Доставщик", "Админ", "СуперАдмин"];
        foreach ($bot_users as $bot_user) {
            $message = sprintf("*%s* (%s) - %s %s %s",
                ($bot_user->fio ?? $bot_user->account_name ?? $bot_user->chat_id),
                ($phone ?? "Телефон не указан"),
                $user_type_array[$bot_user->user_type],
                ($bot_user->rest->name ?? "Ресторан не указан"),
                ($bot_user->is_working ? "Работает" : "Не работает")
            );
            $bot->reply($message, [
                [

                    ["text" => "Сбросить роль", "callback_data" => "/unset_user_type " . ($bot_user->id)]
                ],
                [

                    ["text" => "Выполненные заказы за день", "callback_data" => "/complete_day_orders " . ($bot_user->id)]
                ],

            ]);
        }

    }

    public static function changeSummaryPrice($bot, ...$d)
    {

        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $orderId = isset($d[1]) ? intval($d[1]) : 0;

        $bot->reply("Введите новую полную цену заказа:");
        $bot->startConversation("change_summary_price", [
            "order_id" => $orderId
        ]);
    }

    public static function changeDeliveryPrice($bot, ...$d)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $orderId = isset($d[1]) ? intval($d[1]) : 0;

        $bot->reply("Введите новую полную цену доставки:");
        $bot->startConversation("change_delivery_price", [
            "order_id" => $orderId
        ]);
    }

    public static function summaryPrice($bot, $message)
    {

        $order = Order::where("id",$bot->storeGet("order_id"))->first();

        if (is_null($order)){
            $bot->stopConversation();
            $bot->getMainMenu("Ошибка, заказ не найден в системе");
            return;
        }
/*
        'changed_summary_price',
        'changed_delivery_price',*/
        $order->changed_summary_price = intval($message);
        $order->save();

        $bot->stopConversation();
        $bot->getMainMenu("Спасибо, цена заказа *#$order->id* успешно обновелна на *$message руб.*");

    }

    public static function deliveryPrice($bot, $message)
    {

        $order = Order::where("id",$bot->storeGet("order_id"))->first();

        if (is_null($order)){
            $bot->stopConversation();
            $bot->getMainMenu("Ошибка, заказ не найден в системе");
            return;
        }

        $order->changed_delivery_price = intval($message);
        $order->save();

        $bot->stopConversation();
        $bot->getMainMenu("Спасибо, цена за доставку заказа *#$order->id* успешно обновелна на *$message руб.*");

    }


    public static function completeDayOrders($bot, ...$d)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $deliveryman_id = isset($d[1]) ? intval($d[1]) : 0;

        $orders = Order::with(["details", "restoran", "details.product", "user"])
            ->where("status", OrderStatusEnum::Delivered)
            ->where("deliveryman_id", $deliveryman_id)
            ->where('created_at', '>', Carbon::now()->subDay())
            ->get();

        if (count($orders) == 0) {
            $bot->reply("Список заказов пуст!");
            return;
        }

        $message = "";
        foreach ($orders as $key => $order) {

            $bot_user = !is_null($order->deliveryman) ?
                BotUserInfo::where("chat_id", $order->deliveryman->telegram_chat_id)->first() :
                null;

            $message .= sprintf("*Заявка #%s*, цена заказа *%s руб*, цена доставки *%s руб*, ресторан *%s*, доставщик *%s*\n",
                $order->id,
                ($order->changed_summary_price ?? $order->summary_price ?? "не указано"),
                ($order->changed_delivery_price ?? $order->delivery_price ?? "не указано"),
                ($order->restoran->name ?? "не указано"),
                ($bot_user->phone ??
                    $bot_user->fio ??
                    $bot_user->account_name ??
                    $order->deliveryman->phone ??
                    $order->deliveryman->telegram_chat_id ??
                    $order->deliveryman->id
                    ?? "не указано")
            );

        }

        $bot->reply($message);
    }

    public static function unsetUserType($bot, ...$d)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $bot_user_id = isset($d[1]) ? intval($d[1]) : 0;

        $bot_user = BotUserInfo::where("id", $bot_user_id)->first();

        if (is_null($bot_user_id)) {
            $bot->reply("Ошибка, пользователь не найден!");
            return;
        }
        $bot_user->user_type = 0;
        $bot_user->save();

        $bot->getFallbackMenuToChat($bot_user->chat_id, "Вам сбросили вашу роль! Введите ключевое слово:");

        $bot->reply("Сброс успешно произведен!");

    }

    public static function adminList($bot)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $bot_users = BotUserInfo::with(["rest"])->whereIn("user_type", [UserTypeEnum::Admin, UserTypeEnum::SuperAdmin])
            ->get();

        if (count($bot_users) == 0) {
            $bot->reply("Администраторов не обнаружено.");
            return;
        }

        $user_type_array = ["Гость", "Доставщик", "Админ", "СуперАдмин"];
        foreach ($bot_users as $bot_user) {
            $message = sprintf("*%s* (%s) - %s %s %s",
                ($bot_user->fio ?? $bot_user->account_name ?? $bot_user->chat_id),
                ($phone ?? "Телефон не указан"),
                $user_type_array[$bot_user->user_type],
                ($bot_user->rest->name ?? "Ресторан не указан"),
                ($bot_user->is_working ? "Работает" : "Не работает")
            );
            $bot->reply($message, [
                [

                    ["text" => "Сбросить роль", "callback_data" => "/unset_user_type " . ($bot_user->id)]
                ],

            ]);
        }


    }


}
