<?php

namespace App\Listeners;

use App\Classes\Utilits;
use App\Events\SendSmsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SmsEventListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(SendSmsEvent $event)
    {
        if (is_null($event))
            return;

        $this->sendSms($event->phone,$event->text);
    }
}
