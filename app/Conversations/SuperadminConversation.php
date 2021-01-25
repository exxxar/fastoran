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

        $orders = Order::with(["details", "restoran", "details.product", "user"])
            ->where('created_at', '>', Carbon::now()->subDay())
            ->get();


        if (count($orders) == 0) {
            $bot->reply("Список заказов пуст!");
            return;
        }

        $tmp = "";
        foreach ($orders as $key => $order) {

            $bot_user = BotUserInfo::where("chat_id", $order->deliveryman->telegram_chat_id)->first();
            $tmp .= sprintf("
            <tr>
<td>%s</td>
<td>%s</td>
<td>%s</td>
<td>%s</td>
<td>%s</td>
</tr>
",
                $order->id,
                $order->rest->name,
                ($order->changed_summary_price ?? $order->summary_price ?? "не указано"),
                ($order->changed_delivery_price ?? $order->delivery_price ?? "не указано"),
                ($bot_user->phone ?? $bot_user->fio ?? $bot_user->account_name ?? "не указано")
            );


        }

        $mpdf->WriteHTML("<h1>Сводка за день $current_date</h1>");

        $mpdf->WriteHTML("<table>

<tr>
<td><strong>№ заказа</strong></td>
<td><strong>Ресторан</strong></td>
<td><strong>Цена зака</strong></td>
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

        $orders = Order::with(["details", "restoran", "details.product", "user"])
            ->where('created_at', '>', Carbon::now()->subDay())
            ->get();


        if (count($orders) == 0) {
            $bot->reply("Список заказов пуст!");
            return;
        }

        foreach ($orders as $key => $order) {

            $delivery_order_tmp = "";
            foreach ($order->details as $detail) {
                $product = (object)$detail->product_details;

                $local_tmp = sprintf("%s %s шт. %s руб.\n",
                    $product->food_name ?? "не указано",
                    $detail->count,
                    $product->food_price ?? "не указано"
                );

                $delivery_order_tmp .= $local_tmp;
            }

            $custom_details = "";
            if (count($order->custom_details) > 0) {
                foreach ($order->custom_details as $detail) {
                    $local_tmp = sprintf("%s - %s руб.\n",
                        $detail->name,
                        $detail->price
                    );
                    $custom_details .= $local_tmp;
                }
            }


            $message = sprintf("*Заявка #%s*, цена заказа %s руб, цена доставки %s руб.",
                $order->id,
                ($order->changed_summary_price ?? $order->summary_price ?? "не указано"),
                ($order->changed_delivery_price ?? $order->delivery_price ?? "не указано")
            );


            $keyboard = [

                [

                    ["text" => "Цена заказа", "callback_data" => "/change_summary_price " . ($order->id)],
                    ["text" => "Цена доставки", "callback_data" => "/change_delivery_price " . ($order->id)]
                ]
            ];


            $bot->reply(
                $message,
                $keyboard
            );


        }

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
