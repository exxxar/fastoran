<?php

namespace App\Console\Commands;

use App\Classes\Utilits;
use App\Enums\OrderStatusEnum;
use App\Events\CheckOldOrdersEvent;
use App\Events\SendSmsEvent;
use App\Parts\Models\Fastoran\Order;
use App\Parts\Models\Fastoran\OrderDetail;
use App\Parts\Models\Fastoran\Promocode;
use Illuminate\Console\Command;

class ResendOrdersInQueue extends Command
{

    use Utilits;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Отправка сообщений в каналы ресторанов после открытия ресторана';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $orders = Order::with(["restoran", "user"])->where("status", OrderStatusEnum::InQueue)->get();

        foreach ($orders as $order) {
            $rest = $order->restoran;
            $user = $order->user;

            $order_details = OrderDetail::where("order_id", $order->id)->first();

            $delivery_order_tmp = $this->prepareOrderDetails(
                $order_details,
                $order,
                $user);

            $range = $order->delivery_range;
            $price2 = $order->delivery_price;

            $message_channel = sprintf(
                "*Заявка #%s* (из %s)\n" .
                "Ресторан:_%s_\n" .
                "Ф.И.О.:_%s_\n" .
                "Телефон:_%s_\n" .
                "Заказ:\n%s\n" .
                "Заметка к заказу:\n%s\n\n%s\n" .
                "Время доставки: %s\n" .
                "Адрес доставки:%s\n" .
                "Цена основного заказа:*%s руб.*"
                ,
                $order->id,
                $order->client ?? "fastoran.com",
                $rest->name ?? "Заведение без имени (ошибка)",
                $order->receiver_name ?? $user->name ?? 'Без имени',
                $order->receiver_phone ?? $user->phone ?? 'Без номера телефона (ошибка)',
                $delivery_order_tmp,
                $order->receiver_order_note ?? "Не указана",
                $tmp_custom_details ?? "Нет дополнительных позиций",
                $order->receiver_delivery_time ?? "По готовности",
                $order->receiver_address ?? "Не задан",
                $order->summary_price
            );

            $message_admin = sprintf("%s\nПолная цена доставки:*%s руб.*(Дистанция:%.2fкм)\n",
                $message_channel,
                (!$order->take_by_self ? $price2 : "самовывоз, 0"),
                $range
            );

            $orderId = $this->prepareNumber($order->id);

            event(new CheckOldOrdersEvent($orderId, $rest->telegram_channel, $rest->id));

            event(new SendSmsEvent($user->phone, "Ваш заказ #$order->id (fastoran.com) в обработке!"));

            $this->sendMessageToTelegramChannel($rest->telegram_channel, $message_channel, [
                [
                    ["text" => "Подтвердить заказ!", "url" => "https://t.me/delivery_service_dn_bot?start=001$orderId"],
                    ["text" => "Отменить заказ!", "url" => "https://t.me/delivery_service_dn_bot?start=002$orderId"]
                ]
            ]);

            $this->sendMessageToTelegramChannel(env("TELEGRAM_FASTORAN_ADMIN_CHANNEL"), $message_admin);

        }

    }
}
