<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendSmsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $phone;
    public $text;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($phone,$text)
    {
        $this->phone = $phone;
        $this->text = $text;
    }

}
