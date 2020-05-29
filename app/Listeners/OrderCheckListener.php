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
        $restId = $event->restId;

        $orders = Order::where("status", OrderStatusEnum::InProcessing)
            ->where("rest_id", $restId)
            ->get();

        if (count($orders) <= 1)
            return;

        $message = sprintf("\xE2\x9D\x97У вас осталось %s заказов в обработке!:\n", count($orders)-1);
        $buttons = [];

        $counter = 2;

        foreach ($orders as $order) {
            $orderId = $this->prepareNumber($order->id);

            if ($lastOrderId === $orderId)
                continue;
            $message .= sprintf("*#%s*(%s)\n", $order->id, $order->created_at);

            if ($counter===0)
                break;

            $counter--;
        }

        if (count($orders)>10)
            $message .= "\n...\n*Полный список можно глянуть в боте!*";

        $restId = $this->prepareNumber($restId);
        array_push($buttons, [
            ["text" => "Показать", "url" => "https://t.me/delivery_service_dn_bot?start=004$restId"],
        ]);

        $this->sendMessageToTelegramChannel($channel, $message, $buttons);
    }
}
