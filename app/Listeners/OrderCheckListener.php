<?php

namespace App\Listeners;

use App\Classes\Utilits;
use App\Enums\OrderStatusEnum;
use App\Events\CheckOldOrdersEvent;
use App\Parts\Models\Fastoran\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCheckListener
{
    use Utilits;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(CheckOldOrdersEvent $event)
    {
        if (is_null($event))
            return;


        $lastOrderId = $event->orderId;
        $channel = $event->channel;

        $orders = Order::where("status", OrderStatusEnum::InProcessing)->get();

        if (count($orders) <= 1)
            return;

        $message = "";
        $buttons = [];

        foreach ($orders as $order) {
            $orderId = $this->prepareNumber($order->id);

            if ($lastOrderId === $orderId)
                continue;

            $message .= sprintf("\xE2\x9D\x97\xE2\x9D\x97\xE2\x9D\x97Заказ *#%s* не подтвержден! (%s)\n", $order->id, $order->created_at);

            $accept = sprintf("Подтвердить (#%s)!",$order->id);
            $decline = sprintf("Отменить (#%s)!",$order->id);
            $orderId = $this->prepareNumber($order->id);

            array_push($buttons,   [
                ["text" => $accept, "url" => "https://t.me/delivery_service_dn_bot?start=001$orderId"],
                ["text" => $decline, "url" => "https://t.me/delivery_service_dn_bot?start=002$orderId"]
            ]);


        }

        $this->sendMessageToTelegramChannel($channel, $message,$buttons);
    }
}
