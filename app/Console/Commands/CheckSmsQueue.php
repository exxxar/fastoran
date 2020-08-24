<?php

namespace App\Console\Commands;

use App\Classes\Utilits;
use App\Events\SendSmsEvent;
use App\SmsQueue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckSmsQueue extends Command
{

    use Utilits;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Запуск проверки очереди СМС сообщений';

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
        //
        $smsList = SmsQueue::where("status", false)->get();

        foreach ($smsList as $sms) {
            try {
                $this->sendSms($sms->phone, $sms->message);
                $sms->status = true;
                $sms->save();
            } catch (\Exception $e) {
                Log::error(sprintf("%s:%s %s",
                    $e->getLine(),
                    $e->getFile(),
                    $e->getMessage()
                ));
            }
        }
    }
}
