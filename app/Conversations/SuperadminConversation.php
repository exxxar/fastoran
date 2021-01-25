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
            ->where('created_at', '>', Carbon::now()->subDay())
            ->orderBy("rest_id", "ASC")
            ->get();


        if (count($orders) == 0) {
            $bot->reply("Список заказов пуст!");
            return;
        }

        $order_status_arr = ["В процессе", "Взят рестораном", "Взят доставщиком","Доставлено", "Отменено админом", "В очереди"];

        $tmp = "";
        foreach ($orders as $key => $order) {

            $bot_user = !is_null($order->deliveryman) ?
                BotUserInfo::where("chat_id", $order->deliveryman->telegram_chat_id)->first() :
                null;
            $tmp .= sprintf("
            <tr>
<td>%s</td>
<td>%s</td>
<td>%s руб</td>
<td>%s руб</td>
<td>%s</td>
</tr>
",
                $order->id,
                ($order->restoran->name ?? "не указано"),
                ($order_status_arr[$order->status]??$order->status??"Ошибка"),
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


        }

        $mpdf->WriteHTML("<h1>Сводка за день $current_date</h1>");

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
        $file = $mpdf->Output("order-list.pdf", \Mpdf\Output\Destination::STRING_RETURN);

        Storage::put("order-list.pdf", $file);

        $bot->sendDocument(
            "Сводная статистика за $current_date",
            InputFile::create(storage_path('app/public') . "/order-list.pdf")
        );


    }

    public static function allDayOrders($bot)
    {
        $user = $bot->getUser();

        if (!$user->isActive()) {
            $bot->getFallbackMenu("Вы не являетесь сотрудником!");
            return;
        }

        $orders = Order::with(["details", "restoran", "details.product", "user", "deliveryman"])
            ->where('created_at', '>', Carbon::now()->subDay())
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

                    ["text" => "Цена заказ", "callback_data" => "/change_summary_price " . ($order->id)],
                    ["text" => "Цена доставки", "callback_data" => "/change_delivery_price " . ($order->id)],

                ],
                [
                    ["text" => "Доставлен", "callback_data" => "/delivered " . ($order->id)],
                    ["text" => "Отмена", "callback_data" => "/decline_order " . ($order->id)]
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
