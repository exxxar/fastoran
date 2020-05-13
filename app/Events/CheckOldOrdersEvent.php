<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckOldOrdersEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderId;
    public $channel;
    public $restId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($orderId,$channel,$restId)
    {
        //
        $this->orderId = $orderId;
        $this->channel = $channel;
        $this->restId = $restId;
    }


}
